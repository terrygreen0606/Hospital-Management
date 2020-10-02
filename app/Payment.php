<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'amount', 'paid', 'balance', 'shipping', 'invoice_id', 'orders', 'user_id', 'request', 'reference', 'receipt', 'status', 'pending', 'meta'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime:m/d/Y',
        'invoice_id' => 'integer',
        'orders'     => 'array',
        'user_id'    => 'integer',
        'amount'     => 'float',
        'paid'       => 'float',
        'shipping'   => 'float',
        'balance'    => 'float',
        'meta'       => 'array',
    ];

    protected $appends = [
        'invoice_orders'
    ];

    public function getAmountAttribute($value)
    {
        return number_format($value, 2);
    }

    public function getShippingAttribute($value)
    {
        return number_format($value, 2);
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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function activity()
    {
        return $this->hasMany(Activity::class);
    }
}
