<?php

namespace App\Http\Controllers;

use App\Formulary;
use App\Prescriber;

use Illuminate\Http\Request;

class FormularyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $rec = Formulary::query();

        return $rec->orderBy('created_at', 'desc')->paginate(10);
    }

    public function prescribersPremium($premium, $non_premium) {
        $rec = Prescriber::query();

        if($premium == 'Yes' && $non_premium == "Yes"){
            $rec->where('status', 'Premium');
            $rec->orWhere('status', 'Non-Premium');
        }
        if($premium == 'Yes' && $non_premium == 'No'){
            $rec->where('status', 'Premium');
        }
        if($premium == 'No' && $non_premium == 'Yes'){
            $rec->where('status', 'Non-Premium');
        }

        return $rec->orderBy('created_at', 'desc')->paginate(10);
    }

    public function myFormularies($status) {
        $rec = Formulary::query();

        if($status == 'Non-Premium') {
            $rec->where('non_premium', 'Yes');
        }
        if($status == 'Premium') {
            $rec->where('premium', 'Yes');
        }
        return $rec->orderBy('created_at', 'desc')->paginate(10);
    }
}
