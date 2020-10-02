<?php

use App\Report;

if (!function_exists('analyze')) {
    function analyze($option, $key = null, $default = '')
    {
        $report = Report::where('name', $option)->first();

        if ($report) {
            if (is_null($key)) {
                return $report->value ?? $default;
            } else {
                return $report->value[$key] ?? $default;
            }
        }

        return $default;
    }
}

if (!function_exists('analysis')) {
    function analysis($option = null, $key = null, $default = '')
    {
        if (is_null($option)) {
            return Report::all();
        }
        
        $report = Report::where('name', $option)->first();

        if ($report) {
            if (is_null($key)) {
                return $report->value ?? $default;
            } else {
                return $report->value[$key] ?? $default;
            }
        }

        return $default;
    }
}

