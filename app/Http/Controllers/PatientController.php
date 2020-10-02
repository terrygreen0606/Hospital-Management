<?php

namespace App\Http\Controllers;

use App\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
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
        $records = Patient::query();
        if (!empty($request->query())) {
            foreach ($request->query() as $key => $value) {
                if ($key == 'page') {
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
     * @param  \App\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function show($patient)
    {
        return is_numeric($patient) ? Patient::find($patient) : Patient::where('rx_number', $patient)->first();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $patient)
    {
        $data = $request->all();
        try {
            $update = Patient::find($patient)->update($data);
            $return = $update
                ? array(
                    'error'   => false,
                    'message' => 'Successfully updated patient ',
                    'data'    => $patient,
                )
                : array(
                    'error'   => true,
                    'message' => 'Failed to update patient ',
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
     * @param  \App\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function destroy(Patient $patient)
    {

        try {
            $delete = $patient->delete();
            $return = $delete
                ? array(
                    'error'   => false,
                    'message' => 'Successfully deleted patient ',
                )
                : array(
                    'error'   => true,
                    'message' => 'Failed to delete patient ',
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
