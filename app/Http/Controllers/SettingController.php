<?php

namespace App\Http\Controllers;

use App\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
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
        $records = Setting::query();
        if (!empty($request->query())) {
            foreach ($request->query() as $key => $value) {
                if ($key == 's') {
                    $records->where('name', 'like', "%{$value}%");
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
            $option = Setting::updateOrCreate(['name' => $data['name']], $data);

            return $option
                ? array(
                    'error'   => false,
                    'message' => 'Successfully updated settings ',
                    'data'    => $option,
                )
                : array(
                    'error'   => true,
                    'message' => 'Failed to update settings ',
                );
        } catch (\Exception $e) {
            return array(
                'error'   => true,
                'message' => $e->getMessage(),
            );
        }
    }

    public function single(Request $request, $option, $key = null, $default = '')
    {
        $setting = Setting::where('name', $option)->first();

        if ($setting) {
            if (is_null($key)) {
                return empty($setting->value) ? $default : $setting->value;
            } else {
                return (empty($setting->value[$key]) || is_null($setting->value[$key])) ? $default : $setting->value[$key];
            }
        }

        return $default;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function destroy($setting)
    {

        try {
            $delete = Setting::find($setting)->delete();
            return $delete
                ? array(
                    'error'   => false,
                    'message' => 'Successfully deleted setting ',
                )
                : array(
                    'error'   => true,
                    'message' => 'Failed to delete setting ',
                );
        } catch (\Exception $e) {
            return array(
                'error'   => true,
                'message' => $e->getMessage(),
            );
        }
    }
}
