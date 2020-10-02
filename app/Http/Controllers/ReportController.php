<?php

namespace App\Http\Controllers;

use App\Invoice;
use App\Order;
use App\Payment;
use App\Report;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $reports = Report::all();
        $records = $reports;

        return $records;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $reports = Report::query();

        if (!empty($request->query())) {
            foreach ($request->query() as $key => $value) {
                $reports->where($key, $value);
            }
        }

        return $reports->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Report  $report
     */
    public function show(Report $report)
    {
        return $report;
    }

    public function analyze($option, $key = null, $default = 0)
    {
        $report = Report::where('name', $option)->first();

        if ($report) {
            if (is_null($key)) {
                return $report->value ?? $default;
            } else {
                return $report->value[$key] ?? $default;
            }
        }

        return $default;
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $users    = User::all();
        $patients = User::whereRole('patient')->get();
        $payments = Payment::query();
        $invoices = Invoice::query();
        $orders   = Order::all();

        $user_payments = [];
        foreach ($users as $user) {
            $user_payments["payments_user_{$user->id}"] = array(
                "count"   => count($user->payments),
                "user_id" => $user->id,
                "total"   => round($user->payments->sum("amount")),
            );

            foreach ($user->payment_count as $tag => $value) {
                $user_payments["payments_user_{$user->id}"][$value[0]] = $value[1];
            }
        }

        $patient_payments = [];
        foreach ($patients as $user) {
            $patient_payments["payments_patient_{$user->id}"] = array(
                "count"      => count($user->payments),
                "patient_id" => $user->id,
                "total"      => round($user->payments->sum("amount")),
            );

            foreach ($user->payment_count as $tag => $value) {
                $user_payments["payments_user_{$user->id}"][$value[0]] = $value[1];
            }
        }

        $d_return = array(
            "years"  => $invoices->get(["amount", "user_id", "created_at"])->groupBy(function ($val) {
                return Carbon::parse($val->created_at)->format("Y");
            }),

            "months" => $invoices->get()->groupBy(function ($val) {
                return Carbon::parse($val->created_at)->format("Y-m");
            }),

            "weeks"  => $invoices->get()->groupBy(function ($val) {
                return Carbon::parse($val->created_at)->format("W");
            }),

            "days"   => $invoices->get()->groupBy(function ($val) {
                return Carbon::parse($val->created_at)->format("Y-m-d");
            }),
        );

        $invoices_data = [];
        $d_count       = 0;
        foreach ($d_return as $period => $period_invoices) {
            $p_response = [];
            foreach ($period_invoices as $p => $values) {
                $p_response[$p] = array(
                    "count" => count($values),
                    "total" => round($values->sum("amount")),
                );
                $d_count += count($values);
            }

            $invoices_data[$period] = $p_response;
        }

        $days = ["sunday", "monday", "tuesday", "wednesday", "thursday", "friday", "saturday"];
        foreach ($days as $day) {
            $invoices_data["this-week-invoices"][$day] = $invoices_data["days"][date("Y-m-d", strtotime("{$day} this week"))] ?? ["count" => 0, "total" => 0];
        }

        $return = array(
            "years"  => $payments->get(["amount", "invoice_id", "user_id", "status", "created_at"])->groupBy(function ($val) {
                return Carbon::parse($val->created_at)->format("Y");
            }),

            "months" => $payments->get()->groupBy(function ($val) {
                return Carbon::parse($val->created_at)->format("Y-m");
            }),

            "weeks"  => $payments->get()->groupBy(function ($val) {
                return Carbon::parse($val->created_at)->format("W");
            }),

            "days"   => $payments->get()->groupBy(function ($val) {
                return Carbon::parse($val->created_at)->format("Y-m-d");
            }),
        );

        $payments_data = [];
        $p_count       = 0;
        foreach ($return as $period => $period_payments) {
            $p_response = [];
            foreach ($period_payments as $p => $values) {
                $p_response[$p] = array(
                    "count" => count($values),
                    "total" => round($values->sum("amount")),
                );
                $p_count += count($values);
            }

            $payments_data[$period] = $p_response;
        }

        $days = ["sunday", "monday", "tuesday", "wednesday", "thursday", "friday", "saturday"];
        foreach ($days as $day) {
            $payments_data["this-week-payments"][$day] = $payments_data["days"][date("Y-m-d", strtotime("{$day} this week"))] ?? ["count" => 0, "total" => 0];
        }

        $reports = array(
            "users"    => array(
                "count" => count($users),
            ),
            "patients" => array(
                "count" => count($patients),
            ),
            "payments" => array(
                "count" => count(Payment::all()),
                "total" => round($payments->sum("amount")),
            ),
            "invoices" => array(
                "count" => count(Invoice::all()),
                "total" => round($invoices->sum("amount")),
            ),
            "orders"   => array(
                "count" => count($orders),
            ),
        );

        $reports = array_merge($reports, $payments_data, $invoices_data);

        $combined_reports = array_merge($reports, $user_payments, $patient_payments);

        foreach ($combined_reports as $name => $value) {
            Report::updateOrCreate(["name" => $name], compact("name", "value"));
        }

        return $combined_reports;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function destroy(Report $report)
    {
        //
    }
}
