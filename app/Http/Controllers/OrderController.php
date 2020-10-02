<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
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
        $records = Order::query();
        if (!empty($request->query())) {
            foreach ($request->query() as $key => $value) {
                if ($key == 's') {
                    $records->where('dispensed_item_name', 'like', "%{$value}%")->orWhere('pharmacy_name', 'like', "%{$value}%");
                } elseif ($key == 'page') {
                    continue;
                } elseif ($key == 'date') {
                    $records->whereDate('created_at', '>=', $value);
                } elseif ($key == 'ids') {
                    $records->whereIn('user_id', json_decode($value));
                } elseif ($key == 'searchQuery') {
                    $records->where('dispensed_item_name', 'LIKE', '%' . $value . '%');
                } else {
                    $records->where($key, $value);
                }
            }
        }

        return $records->with(['user', 'patient_data.pharmacy'])->orderBy('created_at', 'desc')->paginate(10);
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
            $create = Order::create($data);
            $return = $create
                ? array(
                    'error'   => false,
                    'message' => 'Successfully created ' . $request->role,
                    'data'    => $create,
                )
                : array(
                    'error'   => true,
                    'message' => 'Failed to create ' . $request->role,
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
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show($order)
    {
        return is_numeric($order) ? Order::with('user')->find($order) : Order::with('user')->where('rx_number', $order)->first();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $order)
    {
        $data = $request->all();
        try {
            if (strpos($order, ",")) {
                $order = explode(",",$order);
                $update = Order::whereIn('id', $order)->update($data);
            }else{
                $update = Order::find($order)->update($data);
            }
            
            $return = $update
                ? array(
                    'error'   => false,
                    'message' => 'Successfully updated order ',
                    'data'    => $order,
                )
                : array(
                    'error'   => true,
                    'message' => 'Failed to update order ',
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
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {

        try {
            $delete = $order->delete();
            $return = $delete
                ? array(
                    'error'   => false,
                    'message' => 'Successfully deleted order ',
                )
                : array(
                    'error'   => true,
                    'message' => 'Failed to delete order ',
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
