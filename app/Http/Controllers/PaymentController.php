<?php

namespace App\Http\Controllers;

use App\Notifications\PaymentFailed;
use App\Notifications\PaymentProcessing;
use App\Notifications\PaymentReceived;
use App\Order;
use App\Payment;
use App\Invoice;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Stripe\Charge;
use Stripe\Stripe;

class PaymentController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('api')->except('stripeWebhook');
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Builder[]|Collection
     */
    public function index(Request $request)
    {
        $records = Payment::query();
        $records = $records->with(['user', 'invoice']);
        if (!empty($request->query())) {

            foreach ($request->query() as $key => $value) {
                if ($key == 'page') {
                    continue;
                } elseif ($key == 'date') {
                    $records->whereDate('created_at', '>=', $value);
                } elseif ($key == 'ids') {
                    $records->whereIn('user_id', json_decode($value));
                } elseif ($key == 'statusNotEqualTo') {
                    $records->where('status', '!=', $value);
                } elseif ($key == 'searchQuery') {
                    $records->whereHas('invoice', function($query) use ($value) {
                        $query->where('number', 'LIKE', '%' . $value . '%');
                    });
                } else {
                    $records->where($key, $value);
                }
            }
        }

        return $records->orderBy('created_at', 'desc')->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return array|Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        try {
            Stripe::setApiKey($request->stripe_secret);
            // Stripe::setApiKey(env('STRIPE_SECRET'));
            $charge = Charge::create([
                "amount"      => ($request->amount) * 100,
                "currency"    => "USD",
                "source"      => $request->token,
                "description" => "DermRX Pharmacy Payment Request From {$request->phone} For {$request->invoice_number}",
            ]);

            $data['reference'] = $charge->id;
            $data['request']   = $charge->status;
            $data['shipping']  = $data['shipping']['cost'];

            $data['orders'] = array_filter($data['orders']);
            $payment        = Payment::create($data);

            // Invoice Status
            $inv = Invoice::where('number', $data['invoice_number'])->first()->update(['status' => $data['invoice_status']]);

            // $payment->user->notify(new PaymentProcessing($payment));
            $return = $payment
                ? array(
                    'error'   => false,
                    'message' => 'Successfully created payment ',
                    'payment' => $payment,
                )
                : array(
                    'error'   => true,
                    'message' => 'Failed to create payment ',
                );
        } catch (Exception $e) {
            $return = array(
                'error'   => true,
                'message' => $e->getMessage(),
            );
        }

        return $return;
    }

    /**
     * Display the specified resource.
     *
     * @param Payment $record
     * @return Builder|Builder[]|Collection|\Illuminate\Database\Eloquent\Model
     */
    public function show($record)
    {
        return Payment::with(['user', 'invoice'])->find($record);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Payment $record
     * @return array|Response
     */
    public function update(Request $request, $record)
    {
        $data = $request->all();
        try {
            $update = Payment::find($record)->update($data);
            $return = $update
                ? array(
                    'error'   => false,
                    'message' => 'Successfully updated payment ',
                    'data'    => $record,
                )
                : array(
                    'error'   => true,
                    'message' => 'Failed to update payment ',
                );
        } catch (Exception $e) {
            $return = array(
                'error'   => true,
                'message' => $e->getMessage(),
            );
        }

        return $return;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Payment $record
     * @return array|Response
     */
    public function destroy($record)
    {
        try {
            $delete = Payment::find($record)->delete();
            $return = $delete
                ? array(
                    'error'   => false,
                    'message' => 'Successfully deleted payment ',
                )
                : array(
                    'error'   => true,
                    'message' => 'Failed to delete payment ',
                );
        } catch (Exception $e) {
            $return = array(
                'error'   => true,
                'message' => $e->getMessage(),
            );
        }

        return $return;
    }

    public function stripeWebhook(Request $request)
    {
        // You can find your endpoint's secret in your webhook settings
        $endpoint_secret = config('services.stripe.webhooksecret');
        $payload         = @file_get_contents('php://input');
        $sig_header      = $_SERVER['HTTP_STRIPE_SIGNATURE'];
        $event           = null;

        Log::channel('stripe')->info(date('Y-m-d H:i:s') . " \n -----START STRIPE \n {$payload}  \n -----END STRIPE-----" . date('Y-m-d H:i:s') . "-----");

        try {
            $event   = \Stripe\Webhook::constructEvent($payload, $sig_header, $endpoint_secret);
            $intent  = $event->data->object;
            $payment = Payment::where('reference', $intent->id)->first();

            if ($payment) {
                switch ($event->type) {
                    case "charge.succeeded":
                        $payment->update(['status' => 'completed']);
                        foreach ($payment->orders as $id) {
                            $order = Order::find($id);
                            if ($order) {
                                $order->update(['current_transaction_status' => 'Completed']);
                                $payment->invoice->amount = $payment->invoice->amount - $order->total_price_paid;
                            }
                        }

                        $payment->save();

                        $payment->user->notify(new PaymentReceived($payment));

                        return array(
                            'intentId' => $intent->id,
                            'message'  => 'Payment succeded',
                        );

                        break;

                    case "charge.failed":
                        $payment->update(['status' => 'failed']);
                        foreach ($payment->orders as $id) {
                            Order::find($id)->update(['current_transaction_status' => 'Failed']);
                        }
                        $payment->user->notify(new PaymentFailed($payment));
                        $error_message = $intent->last_payment_error ? $intent->last_payment_error->message : "";

                        return array(
                            'intentId' => $intent->id,
                            'message'  => 'Payment failed: ' . $error_message,
                        );

                        break;

                    case "charge.captured":
                        $payment->update(['status' => 'processing']);
                        foreach ($payment->orders as $id) {
                            Order::find($id)->update(['current_transaction_status' => 'Awaiting Payment']);
                        }
                        $error_message = $intent->last_payment_error ? $intent->last_payment_error->message : "";

                        return array(
                            'intentId' => $intent->id,
                            'message'  => 'Payment processing: ' . $error_message,
                        );

                        break;

                    default:
                        $error_message = $intent->last_payment_error ?? "";

                        return array(
                            'intentId' => $intent->id,
                            'message'  => 'Payment failed: ' . $error_message,
                        );

                        break;
                }
            } else {
                return array(
                    'intentId' => $intent->id,
                    'message'  => 'Payment Not Found',
                );
            }
        } catch (\UnexpectedValueException $e) {
            return array(
                'message' => 'Invalid payload',
            );
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            return array(
                'message' => 'Invalid signature',
            );
        }
    }
}
