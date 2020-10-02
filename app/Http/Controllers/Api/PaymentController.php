<?php

namespace App\Http\Controllers\Api;

use App\User;
use App\Payment;
use App\WebHook;
use App\Activity;
use App\Patient;
use Osen\Mpesa\C2B;
use Osen\Mpesa\STK;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notifications\PaymentReceivedAdmin;
use Illuminate\Support\Facades\Notification;

class PaymentController extends Controller
{
    public function __construct()
    {
        STK::init(
            array(
                'env'              => setting('mpesa-c2b', 'env', 'sandbox'),
                'type'             => setting('mpesa-c2b', 'type', 4),
                'shortcode'        => setting('mpesa-c2b', 'shortcode', '174379'),
                'key'              => setting('mpesa-c2b', 'key', 'l6jE7kgV4lCtNH4aveMueR9QdGkbutfR'),
                'secret'           => setting('mpesa-c2b', 'secret', '5slRuAafb4Gk7Ogo'),
                'passkey'          => setting('mpesa-c2b', 'passkey', 'bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919'),
                'validation_url'   => url('api/lipwa/validate'),
                'confirmation_url' => url('api/lipwa/confirm'),
                'callback_url'     => url('api/lipwa/reconcile'),
                'results_url'      => url('api/lipwa/results'),
                'timeout_url'      => url('api/lipwa/timeout'),
            )
        );

        C2B::init(
            array(
                'env'              => setting('mpesa-c2b', 'env', 'sandbox'),
                'type'             => setting('mpesa-c2b', 'type', 4),
                'shortcode'        => setting('mpesa-c2b', 'shortcode', '174379'),
                'key'              => setting('mpesa-c2b', 'key', 'l6jE7kgV4lCtNH4aveMueR9QdGkbutfR'),
                'secret'           => setting('mpesa-c2b', 'secret', '5slRuAafb4Gk7Ogo'),
                'username'         => setting('mpesa-c2b', 'username', ''),
                'passkey'          => setting('mpesa-c2b', 'passkey', 'bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919'),
                'validation_url'   => url('api/lipwa/validate'),
                'confirmation_url' => url('api/lipwa/confirm'),
                'callback_url'     => url('api/lipwa/reconcile'),
                'timeout_url'      => url('api/lipwa/timeout'),
                'response_url'     => url('api/lipwa/response'),
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
        return Payment::all();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search_through(Request $request)
    {
        $reports = Payment::query();

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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $response = array(
            "trans_type"  => $request->TransactionType ?? 'C2B',
            "receipt"     => $request->TransID,
            "trans_time"  => $request->TransTime,
            "amount"      => $request->TransAmount,
            "shortcode"   => $request->BusinessShortCode,
            "reference"   => $request->BillRefNumber,
            "invoice"     => $request->InvoiceNumber,
            "balance"     => $request->OrgAccountBalance,
            "transaction" => $request->ThirdPartyTransID,
            "phone"       => $request->MSISDN,
            "first_name"  => $request->FirstName,
            "middle_name" => $request->MiddleName,
            "last_name"   => $request->LastName,
        );

        $data = array_merge(
            $request->all(),
            $response
        );

        try {
            $patient = Patient::firstOrCreate(['phone' => $data['phone']], $data);

            $data['patient_id'] = $patient->id;
            $data['meta']        = array(
                "type"        => $data["trans_type"],
                "time"        => $data["trans_time"],
                "shortcode"   => $data["shortcode"],
                "invoice"     => $data["invoice"],
                "balance"     => $data["balance"],
                "transaction" => $data["transaction"],
            );
            $payment = Payment::firstOrCreate(['reference', $data['reference']], $data);

            $paid             = $payment->paid += $data['amount'];
            $payment->balance = $paid - $data['amount'];
            $payment->status  = 'completed';
            $payment->save();

            $data['name']    = "Payment Receipt";
            $data['details'] = "Payment of KES " . round($data['amount']) . " received from {$data['phone']}";
            $notification    = Activity::create($data);

            if(settings('notifications_mail', 'notify', 'no') == 'yes'){
                Notification::route('mail', settings("general_details", "email", "hi@osen.co.ke"))->notify(new PaymentReceivedAdmin($payment));
            }
            
            send_follow_up_text($patient, ['amount' => $payment->amount]);

            $return = ($patient && $payment && $notification)
                ? array(
                    'error' => false,
                    'message' => 'Successfully created payment ',
                    'data'    => compact('patient', 'payment', 'notification'),
                )
                : array(
                    'error' => true,
                    'message' => 'Failed to create payment ',
                );
        } catch (\Exception $e) {
            $return = array(
                'error' => true,
                'message' => $e->getMessage(),
            );
        }

        return $return['error'] ? C2B::confirm(function ($response) {
            return false;
        }) : C2B::confirm();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function kopokopo(Request $request)
    {
        $shortcode = settings('mpesa_kopokopo', 'shortcode', '');
        $api_key   = settings('mpesa_kopokopo', 'api_key', '');

        $data                    = $request->all();
        $service_name            = $data['service_name'];
        $business_number         = $data['business_number'];
        $transaction_reference   = $data['transaction_reference'];
        $internal_transaction_id = $data['internal_transaction_id'];
        $transaction_timestamp   = $data['transaction_timestamp'];
        $transaction_type        = $data['transaction_type'];
        $amount                  = $data['amount'];
        $amount                  = round($amount);
        $first_name              = $data['first_name'];
        $last_name               = $data['last_name'];
        $middle_name             = $data['middle_name'];
        $sender_phone            = $data['sender_phone'];
        $currency                = $data['currency'];
        $account_number          = $data['account_number'];

        $response = array(
            "trans_type"  => $transaction_type,
            "receipt"     => $transaction_reference,
            "trans_time"  => $transaction_timestamp,
            "amount"      => $amount,
            "shortcode"   => $business_number,
            "reference"   => $account_number,
            "invoice"     => $transaction_reference,
            "balance"     => 0,
            "transaction" => $internal_transaction_id,
            "phone"       => $sender_phone,
            "first_name"  => $first_name,
            "middle_name" => $middle_name,
            "last_name"   => $last_name,
        );

        $data = array_merge(
            $request->all(),
            $response
        );

        try {
            $patient = Patient::firstOrCreate(['phone' => $data['phone']], $data);

            $data['patient_id'] = $patient->id;
            $data['meta']        = array(
                "type"        => $data["trans_type"],
                "time"        => $data["trans_time"],
                "shortcode"   => $data["shortcode"],
                "invoice"     => $data["invoice"],
                "balance"     => $data["balance"],
                "transaction" => $data["transaction"],
            );
            $payment          = Payment::firstOrCreate(['reference', $data['reference']], $data);
            $paid             = $payment->paid += $data['amount'];
            $payment->balance = $paid - $data['amount'];
            $payment->status  = 'completed';
            $payment->save();

            $data['name']    = "Payment Receipt";
            $data['details'] = "Payment of KES " . round($data['amount']) . " received from {$data['phone']}";
            $notification    = Activity::create($data);

            send_follow_up_text($patient, ['amount' => $payment->amount]);

            $data = $request->all();
            $signature = $data['signature'] ?? '';
            unset($data['signature']);
            ksort($data);

            $b = array();
            foreach ($data as $key => $value) {
                $b[] = $key . '=' . $value;
            }

            sort($b);

            $base_string       = implode('&', $b);
            $signature_created = base64_encode(hash_hmac("sha1", $base_string, $api_key, true));

            $return = ($signature_created == $signature)
                ? array(
                    'error' => true,
                    'message' => 'Successfully created payment ',
                    'data'    => compact('patient', 'payment', 'notification'),
                )
                : array(
                    'error' => true,
                    'message' => 'Invalid signature ',
                );
        } catch (\Exception $e) {
            $return = array(
                'error' => true,
                'message' => $e->getMessage(),
            );
        }

        return $return['error']
            ? [
                "status"             => "03",
                "description"        => "Invalid payment",
                "subscriber_message" => $return['message'],
            ]
            : [
                "status"             => "01",
                "description"        => "Accepted",
                "subscriber_message" => $return['message'],
            ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function show($payment)
    {
        return Payment::with(['patient'])->find($payment);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Payment $payment)
    {
        $data = $request->all();
        try {
            $update = $payment->update($data);
            $return = $update
                ? array(
                    'error' => false,
                    'message' => 'Successfully updated payment ',
                    'data'    => $payment,
                )
                : array(
                    'error' => true,
                    'message' => 'Failed to update payment ',
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
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payment $payment)
    {
        try {
            $delete = $payment->delete();
            $return = $delete
                ? array(
                    'error' => false,
                    'message' => 'Successfully deleted payment ',
                )
                : array(
                    'error' => true,
                    'message' => 'Failed to delete payment ',
                );
        } catch (\Exception $e) {
            $return = array(
                'error' => true,
                'message' => $e->getMessage(),
            );
        }

        return $return;
    }

    public function request_payment(Request $request)
    {
        try {
            return STK::send($request->phone, $request->amount, $request->reference, 'Request Payment', 'Payment', function ($response) use ($request) {
                $shortcode = STK::$config->shortcode;
                $data      = $request->all();

                if (isset($response['MerchantRequestID'])) {
                    $data['request']   = $response['MerchantRequestID'];
                    $data['reference'] = strtoupper(str_random(7));

                    $user = User::where('phone', $data['phone'])->first();
                    if ($user) {
                        $data['user_id'] = $user->id;
                    } else {
                        $patient            = Patient::firstOrCreate(['phone' => $data['phone']], $data);
                        $data['patient_id'] = $patient->id;
                    }

                    $data['meta'] = array(
                        "type"        => $data["trans_type"] ?? 'stk',
                        "time"        => $data["trans_time"] ?? time(),
                        "shortcode"   => $data["shortcode"] ?? $shortcode,
                        "invoice"     => $data["invoice"] ?? $request->reference,
                        "balance"     => $data["balance"] ?? 0,
                        "transaction" => $data["transaction"] ?? time(),
                    );

                    $payment = Payment::firstOrCreate(['request', $data['request']], $data);

                    $data['name']    = "Payment Request";
                    $data['details'] = "Payment request of KES " . round($data['amount']) . " sent to {$data['phone']}";
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
        return C2B::validate();
    }

    public function reconcile(Request $request)
    {
        return STK::reconcile(function ($response) {
            $shortcode         = STK::$config->shortcode;
            $response          = $response["Body"];
            $resultCode        = $response["stkCallback"]["ResultCode"];
            $resultDesc        = $response["stkCallback"]["ResultDesc"];
            $merchantRequestID = $response["stkCallback"]["MerchantRequestID"];

            if (isset($response["stkCallback"]["CallbackMetadata"])) {
                $CallbackMetadata = $response["stkCallback"]["CallbackMetadata"]["Item"];

                $amount             = $CallbackMetadata[0]["Value"] ?? 0;
                $mpesaReceiptNumber = $CallbackMetadata[1]["Value"] ?? '';
                $balance            = $CallbackMetadata[2]["Value"] ?? 0;
                $transactionDate    = $CallbackMetadata[3]["Value"] ?? time();
                $phone              = $CallbackMetadata[4]["Value"] ?? '';

                $user     = User::where('phone', $phone)->first();
                $patient = Patient::where('phone', $phone)->first();
                if ($patient) {
                    $user = $patient;
                }

                $payment = Payment::where('request', $merchantRequestID)->orderBy('created_at', 'desc')->first();
                $payment->update(
                    [
                        'status'  => "completed",
                        'amount'  => $amount,
                        'phone'   => $phone,
                        'receipt' => $mpesaReceiptNumber,
                        'meta'    => array(
                            "type"      => 'stk',
                            "time"      => $transactionDate,
                            "shortcode" => '',
                            "invoice"   => time(),
                            "balance"   => $balance,
                        ),
                    ]
                );

                $data = [
                    'name'    => "Payment Receipt",
                    'details' => "{$resultDesc}. Payment of KES {$amount} received from {$phone}",
                ];
                $notification = Activity::create($data);

                send_follow_up_text($user, ['amount' => $amount]);

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
