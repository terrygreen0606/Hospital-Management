<?php

namespace App\Http\Controllers\Api;

use App\Activity;
use App\Patient;
use App\Http\Controllers\Controller;
use App\Disbursal;
use App\User;
use App\WebHook;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Osen\Mpesa\B2C;

class DisbursalController extends Controller
{
    public function __construct()
    {
        B2C::init(
            array(
                'env'              => setting('mpesa-b2c', 'env', 'sandbox'),
                'type'             => setting('mpesa-b2c', 'type', 4),
                'shortcode'        => setting('mpesa-b2c', 'shortcode', '174379'),
                'key'              => setting('mpesa-b2c', 'key', 'l6jE7kgV4lCtNH4aveMueR9QdGkbutfR'),
                'secret'           => setting('mpesa-b2c', 'secret', '5slRuAafb4Gk7Ogo'),
                'passkey'          => setting('mpesa-b2c', 'passkey', 'bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919'),
                'callback_url'     => url('api/lipa/reconcile'),
                'results_url'      => url('api/lipa/results'),
                'timeout_url'      => url('api/lipa/timeout'),
            )
        );
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return Disbursal::all();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search_through(Request $request)
    {
        $reports = Disbursal::query();

        if (!empty($request->query())) {
            foreach ($request->query() as $key => $value) {
                if ($key == 'date') {
                    $reports->whereDate('created_at', '>=', $value);
                } else {
                    $reports->where($key, $value);
                }
            }
        }

        return $reports->get();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Disbursal  $disbursal
     * @return \Illuminate\Http\Response
     */
    public function show($disbursal)
    {
        return Disbursal::with(['patient'])->find($disbursal);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Disbursal  $disbursal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Disbursal $disbursal)
    {
        $data = $request->all();
        try {
            $update = $disbursal->update($data);
            $return = $update
                ? array(
                    'error' => false,
                    'message' => 'Successfully updated disbursal ',
                    'data'    => $disbursal,
                )
                : array(
                    'error' => true,
                    'message' => 'Failed to update disbursal ',
                );
        } catch (\Exception $e) {
            $return = array(
                'error' => true,
                'message' => $e->getMessage(),
            );
        }

        return $return;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Disbursal  $disbursal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Disbursal $disbursal)
    {
        try {
            $delete = $disbursal->delete();
            $return = $delete
                ? array(
                    'error' => false,
                    'message' => 'Successfully deleted disbursal ',
                )
                : array(
                    'error' => true,
                    'message' => 'Failed to delete disbursal ',
                );
        } catch (\Exception $e) {
            $return = array(
                'error' => true,
                'message' => $e->getMessage(),
            );
        }

        return $return;
    }

    public function request_disbursal(Request $request)
    {
        try {
            return B2C::send($request->phone, $request->amount, $request->reference, 'Request Disbursal', 'Disbursal', function ($response) use ($request) {
                $shortcode = B2C::$config->shortcode;
                $data = $request->all();

                if (isset($response['OriginatorConversationID'])) {
                    $data['request'] = $response['OriginatorConversationID'];
                    $data['reference'] = str_random(7);

                    $user = User::where('phone', $data['phone'])->first();
                    if ($user) {
                        $data['user_id'] = $user->id;
                    } else {
                        $patient = Patient::firstOrCreate(['phone' => $data['phone']], $data);
                        $data['patient_id'] = $patient->id;
                    }

                    $data['meta']        = array(
                        "type"        => $data["trans_type"] ?? 'b2c',
                        "time"        => $data["trans_time"] ?? time(),
                        "shortcode"   => $data["shortcode"] ?? $shortcode,
                        "invoice"     => $data["invoice"] ?? $request->reference,
                        "balance"     => $data["balance"] ?? 0,
                        "transaction" => $data["transaction"] ?? time(),
                    );

                    $disbursal = Disbursal::firstOrCreate(['request', $data['request']], $data);

                    $data['name']    = "Disbursal Request";
                    $data['details'] = "Disbursal of KES " . round($data['amount']) . " sent to {$data['phone']}" . $response["ResponseDescription"];
                    $notification    = Activity::create($data);
                }

                $this->forward($shortcode, $response);
                return $response;
            });
        } catch (\Throwable $th) {
            return ['errorCode' => 1, 'errorMessage' => $th->getMessage()];
        }
    }

    public function validation(Request $request)
    {
        return B2C::validate();
    }

    public function reconcile(Request $request)
    {
        B2C::reconcile(function ($response) {
            $shortcode = B2C::$config->shortcode;

            $Result                              = $response["Result"];
            $ResultType                          = $Result["ResultType"];
            $ResultCode                          = $Result["ResultCode"];
            $ResultDesc                          = $Result["ResultDesc"];
            $OriginatorConversationID            = $Result["OriginatorConversationID"];
            $ConversationID                      = $Result["ConversationID"];
            $mpesaReceiptNumber                       = $Result["TransactionID"];
            $ResultParameters                    = $Result["ResultParameters"];
            $ResultParameter                     = $Result["ResultParameters"]["ResultParameter"];
            $TransactionReceipt                  = $ResultParameter[0]["Value"];
            $amount                   = $ResultParameter[1]["Value"];
            $B2CWorkingAccountAvailableFunds     = $ResultParameter[2]["Value"];
            $B2CUtilityAccountAvailableFunds     = $ResultParameter[3]["Value"];
            $transactionDate        = $ResultParameter[4]["Value"];
            $ReceiverPartyPublicName             = $ResultParameter[5]["Value"];
            $B2CChargesPaidAccountAvailableFunds = $ResultParameter[6]["Value"];
            $B2CRecipientIsRegisteredPatient    = $ResultParameter[7]["Value"];
            $ReferenceData                       = $Result["ReferenceData"];
            $ReferenceItem                       = $ReferenceData["ReferenceItem"];
            $QueueTimeoutURL                     = $ReferenceItem[0]["Value"];

            $balance = compact('B2CWorkingAccountAvailableFunds', 'B2CUtilityAccountAvailableFunds');


            if ($ResultCode == 0 || $ResultCode == '0') {
                $disbursal = Disbursal::where('request', $OriginatorConversationID)->orderBy('created_at', 'desc')->first();
                $disbursal->$disbursal->update(
                    [
                        'status'  => "paid",
                        'amount'  => $amount,
                        'receipt' => $mpesaReceiptNumber,
                        'meta'    => array(
                            "type"      => 'b2c',
                            "time"      => $transactionDate,
                            "shortcode" => '',
                            "invoice"   => time(),
                            "balance"   => $balance,
                        ),
                    ]
                );

                $data = [
                    'name'    => "Disbursal Receipt",
                    'details' => "{$ResultDesc}. Disbursal of KES {$amount} received from {$disbursal->phone}",
                    'user_id' => $disbursal->user_id ?? '',
                    'patient_id' => $disbursal->patient_id ?? ''
                ];

                Activity::create($data);

                $this->forward($shortcode, $response);

                return true;
            } else {
                $this->forward($shortcode, $response);

                return false;
            }

            $this->forward($shortcode, $response);

            return true;
        });
    }

    public function forward($shortcode, $json)
    {
        $data    = ['json' => $json];
        $headers = array("Content-Type" => "application/json");
        $hooks   = WebHook::where('shortcode', $shortcode)->get();

        foreach ($hooks as $hook) {
            $forwarder = new Client([
                'base_uri' => rtrim($hook->link, '/'),
            ]);

            if (!empty($hook->username) && !empty($hook->password)) {
                $data['auth'] = array($hook->username) && !empty($hook->password);
            }

            if (!empty($hook->key) && !empty($hook->secret)) {
                $headers["Authorization"] = "Basic " . base64_encode($hook->key . $hook->secret);
            }

            $data['headers'] = $headers;

            $forwarder->post($data);
        }
    }
}
