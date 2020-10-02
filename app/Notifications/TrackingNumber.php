<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use NotificationChannels\Twilio\TwilioChannel;
use NotificationChannels\Twilio\TwilioSmsMessage;

class TrackingNumber extends Notification
{
    public $number;
    public $pharmacy;

    public function __construct($pharmacy, $number)
    {
        $this->number   = $number;
        $this->pharmacy = $pharmacy;
    }

    public function via($notifiable)
    {
        return [TwilioChannel::class];
    }

    public function toTwilio($notifiable)
    {
        return (new TwilioSmsMessage())
            ->content("Hey {$notifiable->name} - Your {$this->pharmacy} order has been shipped. Your tracking number is {$this->number}");
    }
}
