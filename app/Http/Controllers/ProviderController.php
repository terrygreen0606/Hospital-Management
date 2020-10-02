<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Order;
use App\Provider;
use App\Patient;
use App\Models\Account;

class ProviderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $records = Provider::query();
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
        $records = $records->with(['user']);

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
        $data = $request->all();
        // dd($data);
        $data['dob'] = substr($data['npi'], -6);
        if ($request->has('password')) {
            $data['password'] = Hash::make($data['password']);
        }
        try {
            $data['avatar'] = "https://api.adorable.io/avatars/285/{$data['email']}";
            $data['uuid'] = '1-provider-1';
            $data['role'] = 'pharmacy';

            $create = User::create($data);
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
            
            $data['user_id'] = $create->id;
            $provider = Provider::create($data);
            

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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Provider::with(['user'])->find($id);
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
        $data = $request->all();
        $data['email'] = $data['user']['email'];
        $data['phone'] = $data['user']['phone'];

        unset($data['user']);
        unset($data['created_at']);
        unset($data['updated_at']);

        try {
            $user = User::find($data['user_id'])->update($data);
            $update = Provider::find($id)->update($data);
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Provider $provider)
    {
        $account = Account::where('owner_id', $provider->user_id)->forcedelete();
        $user = User::find($provider->user_id)->delete();
        try {
            $delete = $provider->delete();
            $return = $delete
                ? array(
                    'error'   => false,
                    'message' => 'Successfully deleted provider ',
                )
                : array(
                    'error'   => true,
                    'message' => 'Failed to delete provider ',
                );
        } catch (\Exception $e) {
            $return = array(
                'error'   => true,
                'message' => $e->getMessage(),
            );
        }

        return $return;
    }

    public function get_patients_ids($id)
    {
        $patient_ids = Patient::select('user_id')->where('pharmacy_id', $id)->get();
        $ids = [];
        foreach($patient_ids as $row) {
            array_push($ids, $row->user_id);
        }
        return $ids;
    }

    public function get_pharmacy_data($id){
        $data = Provider::where('user_id', $id)->first();

        return $this->get_patients_ids($data->id);
        
        // $patient_ids = Patient::select('user_id')->where('pharmacy_id', $id)->get();
        // $ids = [];
        // foreach($patient_ids as $row) {
        //     array_push($ids, $row->user_id);
        // }
        // return $ids;
    }

    public function get_pharmacy_orders($id)
    {
        $ids = $this->get_pharmacy_data($id);

        $records = Order::query();
        $records->whereIn('user_id', $ids);

        return $records->with(['user', 'patient_data.pharmacy'])->orderBy('created_at', 'desc')->paginate(10);
    }
}
