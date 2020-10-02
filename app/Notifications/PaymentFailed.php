<?php

namespace App\Notifications;

use App\Payment;
use NotificationChannels\Twilio\TwilioChannel;
use NotificationChannels\Twilio\TwilioSmsMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PaymentFailed extends Notification
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
        $amount = $this->payment->amount;
        return (new TwilioSmsMessage())
            ->content("We could not complete your payment of ${$amount}!
            If you have any questions or need to contact us, please email us at rxorders@dermrxpharmacy.com or call us on  844 504 8772");
    }
}
