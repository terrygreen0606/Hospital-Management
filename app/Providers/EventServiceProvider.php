<?php

namespace App\Providers;

use App\Events\GenerateSystemToken;
use App\Events\UserSaved;
use App\Listeners\TokenListener;
use App\Listeners\UserSaved as ListenersUserSaved;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        GenerateSystemToken::class => [
            TokenListener::class,
        ],
        UserSaved::class => [
            ListenersUserSaved::class
        ],
        'App\Events\InvoiceCreated' => [
            'App\Listeners\SendInvoiceSMS',
        ],
        'App\Events\PaymentCreated' => [
            'App\Listeners\SendPaymentSMS',
        ],
        'App\Events\PaymentReceived' => [
            'App\Listeners\SendPaymentReceivedSMS',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
