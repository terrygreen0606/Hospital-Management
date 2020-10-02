<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function __invoke(Request $request)
    {
        $records = [];

        if ($request->query('query')) {
            $records = User::where('name', 'like', "%{$request->query('query')}%")->get();
            //     Patient::where('first_name', 'like', "%{$request->query('query')}%")
            //         ->orWhere('middle_name', 'like', "%{$request->query('query')}%")
            //         ->orWhere('last_name', 'like', "%{$request->query('query')}%")
            //         ->get(),
            // );

            return view('table')
                ->with('records', $records)
                ->with('table', 'search')
                ->with('fields', ['name'])
                ->with('columns', ['name'])
                ->with('title', "Search results for {$request->query('query')}");
        }
    }
}
