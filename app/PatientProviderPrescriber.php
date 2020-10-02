<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PatientProviderPrescriber extends Model
{
    protected $fillable = [
        'provider_id', 'patient_id', 'prescriber_id', 'order_id'
    ];


    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    public function provider()
    {
        return $this->belongsTo(User::class, 'provider_id');
    }

    public function prescriber()
    {
        return $this->belongsTo(User::class, 'prescriber_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

}
