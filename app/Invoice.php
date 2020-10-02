<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'user_id', 'orders', "number", 'amount', 'signature',
    ];

    protected $casts = [
        'created_at' => 'datetime:m/d/Y',
        'user_id'    => 'integer',
        'orders'     => 'array',
        'amount'     => 'float',
    ];

    protected $appends = [
        'status', 'invoice_orders', 'patient'
    ];

    public function getPatientAttribute()
    {
        return Patient::where('serial_number', $this->invoice_orders[0]->serial_number)->first();
    }

    public function getInvoiceOrdersAttribute()
    {
        $orders = [];

        if (is_array($this->orders)) {
            foreach ($this->orders as $rx) {
                $orders[] = Order::find($rx);
            }
        }

        return array_unique($orders);
    }

    public function getStatusAttribute(){
        $orders = [];
        if(is_array($this->orders)) {
            $order = Order::find($this->orders);
            foreach($order as $row){
                array_push($orders, $row->current_transaction_status);
            }

            $order_len = count($order);
            $counts = array_count_values($orders);
            $completedOrders = 0;
            if(array_key_exists('Completed',  $counts)){
                $completedOrders = $counts['Completed'];
            }else{
                $completedOrders = 0;
            }

            if($order_len == $completedOrders){
                return 'Completed';
            }elseif ($completedOrders < $order_len && $completedOrders != 0) {
                return 'Pending';
            } elseif ($completedOrders == 0) {
                return 'Open';
            }
        }
        return 'Open';
    }

    public function getStatusAttributeBckUp()
    {
        $orders = [];
        if (is_array($this->orders)) {
            foreach ($this->orders as $rx) {
                $order = Order::find($rx);
                if ($order) {
                    $orders[$order->current_transaction_status][] = $order;
                }
            }
        }

        $statuses = [
            'Cancelled', 'Completed', 'Paid-Shipping', 'Open'
        ];

        if (isset($orders['Waiting for Print'])) {
            return 'Open';
        } elseif (isset($orders['Completed']) && (count($orders['Completed']) == count($this->orders))) {
            return 'Completed';
        } else {
            return 'Open';
        }
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function patient_data() {
        return $this->belongsTo(Patient::class, 'user_id', 'user_id');
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }
}
