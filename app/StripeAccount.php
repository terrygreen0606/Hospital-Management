<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StripeAccount extends Model
{
    
    protected $fillable = [
        'stripe_key',
        'user_id',
        'stripe_secret',
        'active'
    ];
}
