<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'rx_number',
        'current_transaction_status_date',
        'priority',
        'dispensed_item_name',
        'current_transaction_status',
        'date_filled',
        'date_written',
        'rx_status',
        'rx_status_changed_on',
        'number_of_refills_allowed',
        'directions_translated',
        'rx_total_quantity_remaining',
        'refills_remaining',
        'refill_number',
        'dispensed_quantity',
        'days_supply',
        'total_price_paid',
        'patient_paid_amount',
        'serial_number',
        'dispensed_item_ndc',
        'prescriber_npi',
        'pharmacy_name',
        'tracking_number',
        'user_id',
    ];

    protected $casts = [
        'created_at'  => 'datetime:m/d/Y',
        'date_filled' => 'datetime:m/d/Y',
        'user_id'     => 'integer',
    ];

    protected $appends = [
        'prescriber', 'patient', 'item', 'video'
    ];

    public function getPrescriberAttribute()
    {
        return Prescriber::where('npi', $this->prescriber_npi)->first();
    }

    public function getPatientAttribute()
    {
        return Patient::where('serial_number', $this->serial_number)->first();
    }

    public function getVideoAttribute(){
        return "https://widget.medsoncue.com/Video.aspx?t=88d0dbba-01ee-4572-ab05-ca13e0c540a0&c=ljivvu3329AF&idtype=1&drugid=" . substr($this->dispensed_item_ndc, 0, -2);;
    }

    public function getItemAttribute()
    {
        return Product::where('ndc', $this->prescriber_npi)->first();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }

    public function patient_data() {
        return $this->belongsTo(Patient::class, 'user_id', 'user_id');
    }

    public function prescriber() {
        return $this->belongsTo('App\Prescriber', 'prescriber_npi', 'npi');
    }

    // public function prescriber()
    // {
    //     return $this->hasOne(Prescriber::class, 'npi', 'prescriber_npi');
    // }
}
