<?php

namespace App\Jobs;

use App\Notifications\AvailablePrescription;
use App\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class OrderNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $order;

    /**
     * Create a new job instance.
     *
     * @param Order $order
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if (is_null($this->order)) {
            $orders = Order::where('priority', 'like', '%NimballALL%')->orWhere('rx_status', 'like', '%Waiting for print%')->get();
            foreach ($orders as $order) {
                $user   = $order->invoice->user;
                $url = url("checkout/{$order->invoice->number}");
                dispatch(new SendSms($user->phone, "Hey {$user->name} - Don't forget! Your prescription from DermRx is now available. Place your order now. \n $url"));
            }
        } else {
            $user = $this->order->invoice->user;
            $url = url("checkout/{$this->order->invoice->number}");
            dispatch(new SendSms($user->phone, "\"Hey {$user->name} - Don't forget! Your prescription from DermRx is now available. Place your order now. \n $url"));
        }
    }
}
