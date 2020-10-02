<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'ndc', 'name', 'size', 'price', 'vendor'
    ];

    protected $casts = [
        'size' => 'float',
    ];
}
