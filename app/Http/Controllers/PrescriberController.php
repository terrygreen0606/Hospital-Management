<?php

namespace App\Http\Controllers;

use App\Prescriber;
use App\User;
use App\Order;
use App\Invoice;
use App\Models\Account;
use App\PatientProviderPrescriber;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PrescriberController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['api'])->except(['getPatients', 'getInvoices', 'getOrders', 'getPatientIds']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $records = Prescriber::query();
        if (!empty($request->query())) {
            foreach ($request->query() as $key => $value) {
                if ($key == 's') {
                    $records->where('name', 'like', "%{$value}%");
                        // ->orWhere('address', 'like', "%{$value}%")
                        // ->orWhere('dea', 'like', "%{$value}%");
                } elseif ($key == 'page') {
                    continue;
                } elseif ($key == 'date') {
                    $records->whereDate('created_at', '>=', $value);
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        try {
            $data['dob'] = substr($data['npi'], -6);
            $data['uuid'] = "";
            $data['role'] = "prescriber";

            $user = User::create($data);
            $data['user_id'] = $user->id;
            $create = Prescriber::create($data);
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
     * @param  \App\Prescriber  $prescriber
     * @return \Illuminate\Http\Response
     */
    public function show($prescriber)
    {
        return Prescriber::find($prescriber);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Prescriber  $prescriber
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $prescriber)
    {
        $data = $request->all();
        try {
            $update = Prescriber::find($prescriber)->update($data);
            $user = User::find($data['user_id'])->update($data);
            $return = $update
                ? array(
                    'error'   => false,
                    'message' => 'Successfully updated prescriber ',
                    'data'    => $prescriber,
                )
                : array(
                    'error'   => true,
                    'message' => 'Failed to update prescriber ',
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
     * @param  \App\Prescriber  $prescriber
     * @return \Illuminate\Http\Response
     */
    public function destroy(Prescriber $prescriber)
    {

        try {
            $user_id = $prescriber->user_id;
            $user = User::find($user_id);
            $account = Account::where('name', $user->phone);
            if($account->count() > 0) $account->forceDelete();
            $user->delete();
            $delete = $prescriber->delete();
            $return = $delete
                ? array(
                    'error'   => false,
                    'message' => 'Successfully deleted prescriber ',
                )
                : array(
                    'error'   => true,
                    'message' => 'Failed to delete prescriber ',
                );
        } catch (\Exception $e) {
            $return = array(
                'error'   => true,
                'message' => $e->getMessage(),
            );
        }

        return $return;
    }

    public function getOrders($id) {
        $user = User::with('prescriber')->find($id);

        if ($user->prescriber) {
            return Order::where('prescriber_npi', $user->prescriber->npi)->paginate(25);
        }
    }

    public function getPatients($id) {
        $user = User::with('prescriber')->find($id);

        if ($user->prescriber) {
            $orders = Order::where('prescriber_npi', $user->prescriber->npi)->get();

            $ps = [];
            foreach($orders as $o){
                if($o->user){
                    $ps[] = $o->user_id;
                }
            }

            return User::with('patient')->whereIn('id', $ps)->paginate(25);
        }
    }

    public function getPatientIds($id) {
        $user = User::with('prescriber')->find($id);

        if ($user->prescriber) {
            $orders = Order::where('prescriber_npi', $user->prescriber->npi)->get();

            $ps = [];
            foreach($orders as $o){
                if($o->user){
                    $ps[] = $o->user_id;
                }
            }

            return array_values(array_unique($ps));
        }
    }

    public function getInvoices($id) {
        $user = User::with('prescriber')->find($id);

        if ($user->prescriber) {
            $orders = Order::where('prescriber_npi', $user->prescriber->npi)->get();
            $ps = [];
            foreach($orders as $o){
                if($o->invoice){
                    $ps[$o->invoice_id] = $o->invoice;
                }
            }

            return array_values( array_unique($ps));
        }
    }

    public function prescriberReport($id) {
        $user = User::with('prescriber')->find($id);
        // $ppp = PatientProviderPrescriber::where('prescriber_id', $id);
        $hasNPI = false;

        if($user->prescriber){
            $orders = Order::where('prescriber_npi', $user->prescriber->npi);
            $dermrx = Order::where('prescriber_npi', $user->prescriber->npi)->where('pharmacy_name', 'DermRX Pharmacy');
            $cf = Order::where('prescriber_npi', $user->prescriber->npi)->where('pharmacy_name', 'CF Pharmacy');
            
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

            $yearly = Order::whereBetween('created_at', [$startOfYear, $endOfYear])->where('prescriber_npi', $user->prescriber->npi);
            $quarterly = Order::whereBetween('created_at', [$firstOfQuarter, $lastOfQuarter])->where('prescriber_npi', $user->prescriber->npi);
            $weekly = Order::whereBetween('created_at', [$weekStartDate, $weekEndDate])->where('prescriber_npi', $user->prescriber->npi);
            $monthly = Order::whereBetween('created_at', [$firstDay, $lastDay])->where('prescriber_npi', $user->prescriber->npi);

            $hasNPI = true;

            $c = 0;

            $order_list = $orders->select('id')->get();
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

        }

        $inv = array(
            't_invoice' => $hasNPI ? count($inv_ids) : 0,
            't_completed' =>  $hasNPI ? $c : 0,
            'per'   =>  $hasNPI ? $per : 0
        );

        $data['year'] =  $hasNPI ? $yearly->count() : 0;
        $data['quarter'] =  $hasNPI ? $quarterly->count() : 0;
        $data['month'] =  $hasNPI ? $monthly->count() : 0;
        $data['week'] = $hasNPI ? $weekly->count() : 0;
        $data['script'] =  $hasNPI ? $orders->count() : 0;
        $data['dermrx'] =  $hasNPI ? $dermrx->count() : 0;
        $data['cf'] =  $hasNPI ? $cf->count() : 0;
        $data['invoice'] = $inv;

        return response()->json($data);
    }
}
