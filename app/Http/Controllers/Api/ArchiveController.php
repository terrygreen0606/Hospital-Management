<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ArchiveOrder;

class ArchiveController extends Controller
{
    public function orders() {
    	$orders = ArchiveOrder::paginate(10);
    	return response()->json([
    		'orders' => $orders,
    	],200);
    }
}
