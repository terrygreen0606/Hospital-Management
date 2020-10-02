<?php

namespace App\Jobs;

use App\Payment;
use App\Services\FundsTransfer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class RecordPayment implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $payment;

    /**
     * Create a new job instance.
     *
     * @param Payment $payment
     */
    public function __construct(Payment $payment)
    {
        $this->payment = $payment;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $ft = new FundsTransfer();
        //$ft->make_payment_from_user_wallet_to_system_account($this->payment);
        $this->payment->update(['status' => 'success']);
        dispatch(new SendSms($this->payment->user->phone, "We have received your payment of {$this->payment->amount}"));
    }
}
