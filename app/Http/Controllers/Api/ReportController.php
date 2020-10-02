<?php

namespace App\Http\Controllers\Api;

use App\Report;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
}
