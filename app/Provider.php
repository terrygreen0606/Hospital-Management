<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Provider extends Model
{
    
    protected $fillable = [
        'name',
        'user_id',
        'state',
        'address',
        'city',
        'state',
        'zipcode',
        'pharmacy_pioneer_rx_id',
        'web_address',
        'ncpdp',
        'npi',
        'dea'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
