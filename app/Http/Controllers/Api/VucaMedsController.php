<?php

namespace App\Http\Controllers\Api;

use App\Report;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\NDCWithVideo;

class VucaMedsController extends Controller
{
    public function index(Request $request)
    {
        $res = NDCWithVideo::find($request->video_id);

        $id = str_replace('-', '', $request->video_id);

        $stat_url = 'https://widget.medsoncue.com/Video.aspx?t=88d0dbba-01ee-4572-ab05-ca13e0c540a0&c=ljivvu3329AF&idtype=1&drugid=';

        $file = $stat_url . $id;
        $html = $this->curl($file);
        $exists = true;

        if(strpos($html,"1600")){
            $exists = false;
        }elseif (strpos($html,"1300")) {
            $exists = false;
        }

        $res->video = $exists ? $file : null;

        return response()->json($res);
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
