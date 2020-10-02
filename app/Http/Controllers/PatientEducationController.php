<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\NDCWithVideo;
use App\ConditionVideo;
use App\AdminVideo;
use App\MedVideoAndMap;
use App\Invoice;
use App\Order;

class PatientEducationController extends Controller
{
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

        switch ($req['type']) {
            case 'ndc':
                $record = NDCWithVideo::query();
                $res =  $record->orderBy('created_at', 'desc')->paginate(10);
                foreach ($res as $key => $row) {
                    $row->video = $this->getNDCVideo($row->ncd9_formatted);
                }
                return response()->json($res);
                break;
            case 'cov':
                $record = ConditionVideo::query();
                $res = $record->orderBy('created_at', 'desc')->paginate(10);
                foreach ($res as $key => $row) {
                    $row->video = $this->getConVideo($row->condition_video_id);
                }
                return response()->json($res);
                break;
            case 'adv':
                $record = AdminVideo::query();
                $res = $record->orderBy('created_at', 'desc')->paginate(10);
                foreach ($res as $key => $row) {
                    $row->video = $this->getADVideo($row->admin_video_id);
                }
                return response()->json($res);
                break;
            case 'mvm':
                $record = MedVideoAndMap::query();
                return $record->orderBy('created_at', 'desc')->paginate(10);
                break;
            case 'orders':
                return $this->getOrders($request->user_id);
                break;
          }
    }

    public function getNDCVideo($vid_id) {
        $id = str_replace('-', '', $vid_id);
        $stat_url = 'https://widget.medsoncue.com/Video.aspx?t=88d0dbba-01ee-4572-ab05-ca13e0c540a0&c=ljivvu3329AF&idtype=1&drugid=';
        $file = $stat_url . $id;
        // $html = $this->curl($file);
        // $exists = true;

        // if(strpos($html,"1600")){
        //     $exists = false;
        // }elseif (strpos($html,"1300")) {
        //     $exists = false;
        // }

        // return $exists ? $file : null;
        return $file;
    }

    public function getADVideo($vid_id) {
        $stat_url = 'http://widget.medsoncue.com/Video.aspx?t=88d0dbba-01ee-4572-ab05-ca13e0c540a0&c=ljivvu3329AF&idtype=3&vid=';
        $file = $stat_url . $vid_id;
        return $file;
    }

    public function getConVideo($vid_id) {
        $stat_url = 'http://widget.medsoncue.com/Video.aspx?t=88d0dbba-01ee-4572-ab05-ca13e0c540a0&c=ljivvu3329AF&idtype=4&vid=';
        $file = $stat_url . $vid_id;
        return $file;
    }

    public function getOrders($user_id) {
        $orders = Invoice::select('orders')->where('user_id', $user_id)->get();
        $order_ids = [];

        foreach ($orders as $row) {
            $order_ids = array_merge($row->orders, $order_ids);
        }
        $orderlist = Order::whereIn('id', $order_ids)->get();

        // dd($orderlist);
        return $orderlist;
    }

    function curl($url){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        $return = curl_exec($ch);
        curl_close ($ch);
        return $return;
    }
}
