<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\PatientProviderPrescriber;
use App\Order;
use App\Invoice;

class PPPController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $records = PatientProviderPrescriber::query();
        
        $records = $records->with(['patient.patient', 'provider', 'order']);



        return $records->orderBy('created_at', 'desc')->paginate(10);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return PatientProviderPrescriber::with(['patient.patient', 'provider', 'order'])->find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getOrders($id) {
        $orderArray = Invoice::select('orders')->where('user_id', $id)->get();
        $orders = [];
        foreach($orderArray as $row) {
            $orders = array_merge($orders, $row->orders);
        }
        $orderIDs = array_unique($orders);

        return Order::whereIn('id', $orderIDs)->paginate(10);
    }

    public function getOrderData($user_id, $order_id) {
        return PatientProviderPrescriber::with(['patient.patient', 'provider', 'order'])->where('patient_id', $user_id)->where('order_id', $order_id)->first();
    }

    public function getPrescriberOrders($user_id) {
        return PatientProviderPrescriber::query()
                    ->with(['patient.patient', 'provider', 'order'])
                    ->where('prescriber_id', $user_id)
                    ->paginate(10);
    }

    public function getProviderOrders($user_id) {
        return PatientProviderPrescriber::query()
                    ->with(['patient.patient', 'provider', 'order'])
                    ->where('provider_id', $user_id)
                    ->paginate();
    }
}
