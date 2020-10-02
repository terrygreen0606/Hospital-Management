<?php

use App\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\Twilio\TwilioChannel;
use NotificationChannels\Twilio\TwilioSmsMessage;

class PaymentReceivedPatient extends Notification
{
    use Queueable;

    public $payment;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Payment $payment)
    {
        $this->payment = $payment;
    }

    public function via($notifiable)
    {
        return [TwilioChannel::class];
    }

    public function toTwilio($notifiable)
    {
        $url = url("receipts/{$this->payment->invoice->number}");
        
        return (new TwilioSmsMessage())
            ->content("Hey {$notifiable->name} - Your payment of {$this->amount} has been received. \n $url");
    }
}