<?php

// For add'active' class for activated route nav-item
function active_class($path, $active = 'active') {
  request()->is($path) ? $active : '';
}

// For checking activated route
function is_active_route($path) {
  request()->is($path) ? 'true' : 'false';
}

// For add 'show' class for activated route collapse
function show_class($path)
{
    request()->is($path) ? 'show' : '';
}

if(!function_exists('encode_phone_number'))  {
    function encode_phone_number(string $number, string $code = '254') {
        // remove preceding plus if it exists
        $number = preg_replace('/^\+/', '', $number);

        if (starts_with($number, $code))
            return $number;

        if (starts_with($number, '07')) {
            $real = substr($number, 1);
            return $code . $real;
        } else {
            return $code . $number;
        }
    }
}

if (!function_exists('get_country_code_from_ip')) {
    function get_country_code_from_ip(\Illuminate\Http\Request $request) {
        $ip = $request->ip();
        $detailsId = json_decode(file_get_contents("https://ipinfo.io/{$ip}"));
        dd($detailsId->country);
    }
}
if (!function_exists('is_empty')){
    function is_empty($var) {
        if (is_array($var) && count($var) > 0)
            return false;
        $var = trim($var, ' ');
        if (is_null($var)) return true;
        if (empty($var)) return true;

        return false;
    }
}
if (!function_exists('check_if_attempt_is_fraudulent')) {

    function check_if_attempt_is_fraudulent(float $attempt_ip, float $action_ip) : bool {
        $fraud = true;
        if ($attempt_ip !== $action_ip) {
            $fraud = true;
        }
        return $fraud;
    }
}

