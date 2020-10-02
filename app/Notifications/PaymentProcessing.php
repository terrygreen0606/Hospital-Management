<?php

namespace App\Notifications;

use App\Payment;
use NotificationChannels\Twilio\TwilioChannel;
use NotificationChannels\Twilio\TwilioSmsMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PaymentProcessing extends Notification
{
    public $payment;

    function __construct($payment)
    {
        $this->payment = $payment;
    }

    public function via($notifiable)
    {
        return [TwilioChannel::class];
    }

    public function toTwilio($notifiable)
    {
        return (new TwilioSmsMessage())
            ->content("Congratulations! Your prescription is being processed. If you have any questions or need to contact us, please email us at rxorders@dermrxpharmacy.com or call us on  844 504 8772");
    }
}
