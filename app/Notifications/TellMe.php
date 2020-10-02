<?php

namespace App\Notifications;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use NotificationChannels\Twilio\TwilioChannel;
use NotificationChannels\Twilio\TwilioSmsMessage;

class TellMe extends Notification
{
    use Queueable;

    public $user;

    function __construct(User $user)
    {
        $this->user = $user;
    }

    public function via($notifiable)
    {
        return [TwilioChannel::class];
    }

    public function toTwilio($notifiable)
    {
        $url = url("users/{$this->user->id}");

        return (new TwilioSmsMessage())
            ->content("Hey {$notifiable->name} - Don't forget! Your prescription from DermRx is now available. Place your invoice now. \n $url");
    }
}
