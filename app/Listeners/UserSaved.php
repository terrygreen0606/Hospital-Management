<?php

namespace App\Listeners;

use App\Events\UserSaved as EventsUserSaved;
use App\Notifications\TellMe;
use App\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class UserSaved
{

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(EventsUserSaved $event)
    {
        $event->user->notify(new TellMe($event->user));
    }
}
