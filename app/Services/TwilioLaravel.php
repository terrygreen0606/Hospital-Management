<?php


namespace App\Services;


use Twilio\Rest\Client;

class TwilioLaravel
{
    protected static $client;

    public function __construct(Client $client)
    {
        self::$client = $client;
    }

    public static function notify(string  $number, string $message)
    {
        return self::$client->messages->create($number, [
            'from' => env('TWILIO_FROM'),
            'body' => $message
        ]);
    }
}
