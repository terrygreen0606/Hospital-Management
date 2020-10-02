<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SignaturePadController extends Controller
{
    public function upload(Request $request)
    {
        $path     = public_path('storage/signatures/');
        $parts    = explode(";base64,", $request->signature);
        $type_aux = explode("image/", $parts[0]);
        $type     = $type_aux[1];
        $base64   = base64_decode($parts[1]);
        $name     = uniqid() . '.' . $type;
        $file     = $path . $name;

        file_put_contents($file, $base64);
        return "/storage/signatures/{$name}";
    }
}
