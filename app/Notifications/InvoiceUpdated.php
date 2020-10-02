<?php

namespace App\Notifications;

use App\Invoice;
use NotificationChannels\Twilio\TwilioChannel;
use NotificationChannels\Twilio\TwilioSmsMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InvoiceUpdated extends Notification
{
    public $invoice;

    function __construct($invoice)
    {
        $this->invoice = $invoice;
    }

    public function via($notifiable)
    {
        return [TwilioChannel::class];
    }

    public function toTwilio($notifiable)
    {
        $url = url("invoices/{$this->invoice->number}");
        $url = url("/");

        return (new TwilioSmsMessage())
            ->content("Hey {$notifiable->name} - Your Invoice has been updated!. Check it out now. \n $url");
    }
}
