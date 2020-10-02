<?php


namespace App\Services;


use Illuminate\Http\Request;

class AuthService
{
    public function login(Request $request)
    {
        $token = $request->get('token');
    }
}
