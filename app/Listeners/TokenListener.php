<?php

namespace App\Listeners;

use App\Events\GenerateSystemToken;
use App\LoginRequest;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class TokenListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(GenerateSystemToken $event)
    {
        $user = $event->user;
        $token = new LoginRequest([
            "user_id" => $user->id,
            "token" => $user->generateAUserToken(),
        ]);
        $token->save();

    }
}
