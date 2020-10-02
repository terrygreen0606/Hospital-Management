<?php

namespace App\Http\Controllers;

use App\Notifications\AvailablePrescription;
use App\Invoice;
use App\Notifications\GenericEmail;
use Illuminate\Http\Request;

class MiscController extends Controller
{
    public function send_sms(Invoice $invoice = null)
    {
        return $invoice->user->notify(new AvailablePrescription($invoice));

        return array(
            'error'   => false,
            'message' => 'Successfully sent sms '
        );
    }

    public function send_email(Request $request, Invoice $invoice = null)
    {
        $contents = array(
            'subject' => $request->subject,
            'message' => $request->message,
            'link'    => url("/")
        );

        return $invoice->user->notify(new GenericEmail($contents));
        return array(
            'error'   => false,
            'message' => 'Successfully sent email '
        );
    }
}
