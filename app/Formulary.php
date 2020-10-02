<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Formulary extends Model
{
    public $timestamps = true;
    
    protected $fillable = [
        'disease_state',
        'product_type',
        'product_name',
        'size',
        'brand',
        'insurance',
        'drx_club',
        'stock_status',
        'available_with_insurance',
        'eta',
    ];
}
