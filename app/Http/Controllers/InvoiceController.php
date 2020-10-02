<?php

namespace App\Http\Controllers;

use App\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['api']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $rec = $request->query();

        if(!empty($rec) && array_key_exists('showStatus', $rec)){
            $records = Invoice::with(['user']);
            $records = $records->get();
            $result = [];
            foreach($records as $rec){
                if($rec->status == 'Open') array_push($result['Open'], $rec);
                if($rec->status == 'Cancelled') array_push($result['Cancelled'], $rec);
                if($rec->status == 'Pending') array_push($result['Pending'], $rec);
            }
        }else{
            $records = Invoice::with(['user', 'patient_data.pharmacy']);
            // $records = Invoice::query();

            
            if (!empty($request->query())) {
                foreach ($request->query() as $key => $value) {
                    if ($key == 'page') {
                        continue;
                    } elseif ($key == 'date') {
                        $records->whereDate('created_at', '>=', $value);
                    } elseif ($key == 'status') {
                        $records->whereHas('order', function ($q) {
                            return $q->whereNot('rx_status', 'Completed')->whereNot('rx_status', 'Cancelled');
                        });
                    } elseif ($key == 'ids') {
                        $records->whereIn('user_id', json_decode($value));
                    } elseif ($key == 'searchQuery') {
                        $records->where('number', 'LIKE', '%' . $value . '%');
                    } elseif ($key == 'user_id') {
                        $records->where('user_id', $value);
                    }

                    // NOTE: I removed this because if there is an unecessary query from search url it will return an error
                    // else {
                    //     $records->where($key, $value);
                    // }
                }
            }
            return $records->orderBy('created_at', 'desc')->paginate(10);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        try {
            $create = Invoice::create($data);
            $return = $create
                ? array(
                    'error'   => false,
                    'message' => 'Successfully created invoice',
                    'data'    => $create,
                )
                : array(
                    'error'   => true,
                    'message' => 'Failed to create invoice',
                );
        } catch (\Exception $e) {
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
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show($invoice)
    {
        if(is_numeric($invoice)) {
            return Invoice::with(['user', 'payment', 'patient_data'])->find($invoice);
        }else{
            $res = Invoice::where('number', $invoice)->first();
            $result = Invoice::with(['user', 'payment', 'patient_data'])->where('user_id', $res->user_id)->first();
            $resultAdd = Invoice::with(['user', 'payment', 'patient_data'])->where('user_id', $res->user_id)->get();

            foreach($resultAdd as $row){
                // print_r($row->orders);
                $newOrders = array_merge($result->orders, $row->orders);
                $result->orders = array_unique($newOrders);

                $newIO = array_merge($result->invoice_orders, $row->invoice_orders);

                $result->invoice_orders = array_unique($newIO);
            }

            return $result;
        }
        // return is_numeric($invoice) ? Invoice::with(['user', 'payment'])->find($invoice) : Invoice::with(['user', 'payment'])->where('number', $invoice)->first();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $invoice)
    {
        $data = $request->all();
        try {
            $update = Invoice::find($invoice)->update($data);
            $return = $update
                ? array(
                    'error'   => false,
                    'message' => 'Successfully updated invoice ',
                    'data'    => $invoice,
                )
                : array(
                    'error'   => true,
                    'message' => 'Failed to update invoice ',
                );
        } catch (\Exception $e) {
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
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invoice $invoice)
    {
        try {
            $delete = $invoice->delete();
            $return = $delete
                ? array(
                    'error'   => false,
                    'message' => 'Successfully deleted invoice ',
                )
                : array(
                    'error'   => true,
                    'message' => 'Failed to delete invoice ',
                );
        } catch (\Exception $e) {
            $return = array(
                'error'   => true,
                'message' => $e->getMessage(),
            );
        }

        return $return;
    }
}
