<?php

namespace App\Http\Controllers\Api;

use App\Activity;
use App\Patient;
use App\Http\Controllers\Controller;
use App\Mail\GenericMessage;
use App\Payment;
use App\Setting;
use App\User;
use App\WebHook;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class MiscController extends Controller
{
    public function __construct()
    {
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

    public function send_sms(Request $request)
    {
        $provider = (settings('notifications_sms', 'use-onfon', 'no') == 'yes') ? 'onfon' : 'at';
        $response = send_sms($request->phone, $request->message, $provider);
        return $response;
    }

    public function send_email(Request $request)
    {
        $create = '';
        foreach ($request->email as $email) {
            $user = User::where('email', $email)->first();
            $contents = array(
                'subject' => $request->subject,
                'message' => $request->message
            );

            $create = Mail::to($user->email, $user->name)->send(new GenericMessage($contents));
        }

        if (count(Mail::failures()) > 0) {
            return  array(
                'error' => true,
                'message' => 'Failed to send email ',
            );
        }

        return array(
            'error' => false,
            'message' => 'Successfully sent email ',
            'data'    => $create,
        );
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

    public function settings(Request $request)
    {
        $reports = Setting::query();

        if (!empty($request->query())) {
            foreach ($request->query() as $key => $value) {
                $reports->where($key, $value);
            }
        }

        return $reports->get();
    }

    public function monthly(Request $request)
    {
        $reports = Payment::query();

        if (!empty($request->query())) {
            foreach ($request->query() as $key => $value) {
                $reports->where($key, $value);
            }
        }

        $return = array(
            "years" => $reports->get(['amount', 'patient_id', 'user_id', 'status', 'created_at'])->groupBy(function ($val) {
                return Carbon::parse($val->created_at)->format('Y');
            }),

            "months" => $reports->get()->groupBy(function ($val) {
                return Carbon::parse($val->created_at)->format('Y-m');
            }),

            "weeks" => $reports->get()->groupBy(function ($val) {
                return Carbon::parse($val->created_at)->format('W');
            }),

            "days" => $reports->get()->groupBy(function ($val) {
                return Carbon::parse($val->created_at)->format('Y-m-d');
            })
        );
        $response = [];
        foreach ($return as $period => $period_payments) {
            $p_response = [];
            $p_count = 0;
            foreach ($period_payments as $p => $values) {
                $p_response[$p] = array(
                    'count' => count($values),
                    'total' => $values->sum('amount'),
                );
                $p_count += count($values);
            }

            $response[$period] = $p_response;
        }

        $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
        foreach ($days as $day) {
            $response['this-week'][$day]  = $response['days'][date('Y-m-d', strtotime("{$day} this week"))] ?? ['count' => 0, 'total' => 0];
        }

        return $response;
    }
}
