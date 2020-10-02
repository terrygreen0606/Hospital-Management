<?php

namespace App\Jobs;

use App\Services\TwilioLaravel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendSms implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $phone;
    protected $message;

    /**
     * Create a new job instance.
     *
     * @param $phone
     * @param $message
     */
    public function __construct($phone, $message)
    {
        $this->message = $message;
        $this->phone = $phone;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $result = TwilioLaravel::notify($this->phone, $this->message);
        Log::info('From Twilio', [
            "message" => $result
        ]);
    }
}
