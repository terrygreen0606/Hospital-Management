<?php

namespace App\Listeners;

use App\Events\InvoiceCreated;
use App\Notifications\AvailablePrescription;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendInvoiceSMS
{
    /**
     * Handle the event.
     *
     * @param  InvoiceCreated  $event
     * @return void
     */
    public function handle(InvoiceCreated $event)
    {
        $invoice = $event->invoice;
        //if (($invoice->order->priority == 'NimbleALL') && ($invoice->order->current_transaction_status == 'Waiting for Print')) {
        $user   = $invoice->user;
        $user->notify(new AvailablePrescription($invoice));
        //}
    }
}
