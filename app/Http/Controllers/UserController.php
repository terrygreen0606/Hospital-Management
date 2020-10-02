<?php

namespace App\Http\Controllers;

use App\User;
use App\Patient;
use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
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
        $req = $request->all();
        $records = User::query()->with(['patient']);

        if (!empty($request->query())) {
            foreach ($request->query() as $key => $value) {
                if ($key == 's') {
                    $records->where('name', 'like', "%{$value}%");
                } elseif ($key == 'page') {
                    continue;
                } elseif ($key == 'pharmacy_id') {
                    $records->whereHas('patient', function ($query) use($value) {
                        return $query->where('pharmacy_id', $value);
                    });
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
        if ($request->has('password')) {
            $data['password'] = Hash::make($data['password']);
        }
        try {
            if ($request->hasFile('avatar')) {
                $image          = $request->file('avatar');
                $path           = $image->store('public/avatars');
                $path           = str_replace('public/', '', $path);
                $data['avatar'] = asset("storage/$path");
            } else {
                $data['avatar'] = "https://api.adorable.io/avatars/285/{$data['email']}";
            }
            $data["dob"] = date("mdy", strtotime($data['dob']));
            
            $create = User::create($data);
            $data['user_id'] = $create->id;
            $create = Patient::create($data);
            
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
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show($user = null)
    {
        return is_null($user) ? user() : User::with('patient')->find($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $user)
    {
        $data = $request->all();
        $data['uuid'] = "";
        if ($request->has('new-password')) {
            $data['password'] = Hash::make($data['new-password']);
        }

        try {
            if ($request->hasFile('avatar')) {
                $image          = $request->file('avatar');
                $path           = $image->store('public/avatars');
                $path           = str_replace('public/', '', $path);
                $data['avatar'] = asset("storage/$path");
            }

            $user   = User::find($user);
            $update = $user->update($data);
            if (isset($data['patient']) && !is_null($data['patient'])) {
                $user->patient->update($data['patient']);
            }

            $return = $update
                ? array(
                    'error'   => false,
                    'message' => 'Successfully updated profile ',
                    'data'    => $user,
                )
                : array(
                    'error'   => true,
                    'message' => 'Failed to update profile ',
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function complete_profile(Request $request, $user)
    {
        $data             = $request->all();
        $data['password'] = Hash::make($data['password']);

        try {
            $update = user()->update($data);
            $return = $update
                ? array(
                    'error'   => false,
                    'message' => 'Successfully updated your account ',
                    'data'    => $user,
                )
                : array(
                    'error'   => true,
                    'message' => 'Failed to update user account ',
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
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        try {
            $account = Account::where('name', $user->phone);
            if($account->count() > 0) $account->forceDelete();
            $delete = $user->delete();
            $return = $delete
                ? array(
                    'error'   => false,
                    'message' => 'Successfully deleted user ',
                )
                : array(
                    'error'   => true,
                    'message' => 'Failed to delete user ',
                );
        } catch (\Exception $e) {
            $return = array(
                'error'   => true,
                'message' => $e->getMessage(),
            );
        }

        return $return;
    }

    public function prescriberData($id) {
        return User::with(['prescriber'])->find($id);
    }
}
