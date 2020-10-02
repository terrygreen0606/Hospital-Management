<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Order;
use App\Invoice;
use App\User;
use App\Provider;
use App\Patient;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    public function admin_reports() {
        
        // $user = User;
        $invoice = Invoice::all();


        $n1 = Carbon::now();
        $weekStartDate = $n1->startOfWeek()->format('Y-m-d');
        $weekEndDate = $n1->endOfWeek()->format('Y-m-d');

        $n2 = Carbon::now(); 
        $firstDay = $n2->firstOfMonth()->format('Y-m-d'); 
        $lastDay = $n2->lastOfMonth()->format('Y-m-d');

        $n3 = Carbon::now(); 
        $firstOfQuarter = $n3->firstOfQuarter()->format('Y-m-d');
        $lastOfQuarter = $n3->lastOfQuarter()->format('Y-m-d');

        $n4 = Carbon::now();
        $startOfYear = $n4->startOfYear()->format('Y-m-d');
        $endOfYear   = $n4->endOfYear()->format('Y-m-d');

        $yearly = Order::whereBetween('created_at', [$startOfYear, $endOfYear]);
        $quarterly = Order::whereBetween('created_at', [$firstOfQuarter, $lastOfQuarter]);
        $weekly = Order::whereBetween('created_at', [$weekStartDate, $weekEndDate]);
        $monthly = Order::whereBetween('created_at', [$firstDay, $lastDay]);

        $doctors = User::where('role', 'doctor')->orWhere('role', 'prescriber');
        $pharmacies = User::where('role', 'pharmacy')->orWhere('role', 'provider');
        $patients = User::where('role', 'patient');

        $completed = Invoice::where('status', 'completed');

        $order_list = Order::select('id')->get();

        $c = 0;
        $inv_ids = [];
        foreach($order_list as $ord) {
            // echo '%"'.$ord->id.'"%'. '     ';
            $inv = Invoice::where('orders', 'like', '%'.$ord->id.'%')->first();
            if($inv !== null) array_push($inv_ids, $inv->id);
        }

        $inv_ids = array_unique($inv_ids);
        foreach($inv_ids as $id) {
            $invoice = Invoice::find($id);
            if($invoice->status == 'Completed') $c++;
        }

        $per = 0;

        if($c != 0) {
            $per = ($c / count($inv_ids)) * 100;
        }
        // if($completed->count() > 0) $per = ($completed->count() / $invoice->count()) * 100;


        $inv = array(
            't_invoice' => count($inv_ids),
            't_completed' =>  $c,
            'per'   =>  $per
        );

        $data['doctors'] = $doctors->count();
        $data['pharmacies'] = $pharmacies->count();
        $data['patients'] = $patients->count();
        $data['invoice'] = $inv;
        $data['year'] =  $yearly->count();
        $data['quarter'] =  $quarterly->count();
        $data['month'] =  $monthly->count();
        $data['week'] = $weekly->count();

        return response()->json($data);
    }

    public function provider_reports($id) {
        
        $pharmacy = Provider::where('user_id', $id)->first();

        $patient = Patient::select('user_id')->where('pharmacy_id', $pharmacy->id)->get();

        $p_ids = [];

        foreach($patient as $pat) {
            array_push($p_ids, $pat->user_id);
        }
        
        $invoice = Invoice::whereIn('user_id', $p_ids)->get();


        $n1 = Carbon::now();
        $weekStartDate = $n1->startOfWeek()->format('Y-m-d');
        $weekEndDate = $n1->endOfWeek()->format('Y-m-d');

        $n2 = Carbon::now(); 
        $firstDay = $n2->firstOfMonth()->format('Y-m-d'); 
        $lastDay = $n2->lastOfMonth()->format('Y-m-d');

        $n3 = Carbon::now(); 
        $firstOfQuarter = $n3->firstOfQuarter()->format('Y-m-d');
        $lastOfQuarter = $n3->lastOfQuarter()->format('Y-m-d');

        $n4 = Carbon::now();
        $startOfYear = $n4->startOfYear()->format('Y-m-d');
        $endOfYear   = $n4->endOfYear()->format('Y-m-d');

        $yearly = Order::whereBetween('created_at', [$startOfYear, $endOfYear])->whereIn('user_id', $p_ids);
        $quarterly = Order::whereBetween('created_at', [$firstOfQuarter, $lastOfQuarter])->whereIn('user_id', $p_ids);
        $weekly = Order::whereBetween('created_at', [$weekStartDate, $weekEndDate])->whereIn('user_id', $p_ids);
        $monthly = Order::whereBetween('created_at', [$firstDay, $lastDay])->whereIn('user_id', $p_ids);

        $doctors = User::where('role', 'doctor')->orWhere('role', 'prescriber');
        $pharmacies = User::where('role', 'pharmacy')->orWhere('role', 'provider');
        $patients = User::where('role', 'patient')->whereIn('id', $p_ids);

        $completed = Invoice::where('status', 'completed')->whereIn('user_id', $p_ids);

        $order_list = Order::select('id')->whereIn('user_id', $p_ids)->get();

        $c = 0;
        $inv_ids = [];
        foreach($order_list as $ord) {
            // echo '%"'.$ord->id.'"%'. '     ';
            $inv = Invoice::where('orders', 'like', '%'.$ord->id.'%')->first();
            if($inv !== null) array_push($inv_ids, $inv->id);
        }

        $inv_ids = array_unique($inv_ids);
        foreach($inv_ids as $id) {
            $invoice = Invoice::find($id);
            if($invoice->status == 'Completed') $c++;
        }

        $per = 0;

        if($c != 0) {
            $per = ($c / count($inv_ids)) * 100;
        }
        // if($completed->count() > 0) $per = ($completed->count() / $invoice->count()) * 100;


        $inv = array(
            't_invoice' => count($inv_ids),
            't_completed' =>  $c,
            'per'   =>  $per
        );

        $data['doctors'] = $doctors->count();
        $data['pharmacies'] = $pharmacies->count();
        $data['patients'] = $patients->count();
        $data['invoice'] = $inv;
        $data['year'] =  $yearly->count();
        $data['quarter'] =  $quarterly->count();
        $data['month'] =  $monthly->count();
        $data['week'] = $weekly->count();




        return response()->json($data);
    }
}
