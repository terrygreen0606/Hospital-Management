<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $fillable = [
        'address',
        'city',
        'state',
        'zip_code',
        'serial_number',
        'category',
        'user_id',
        'pharmacy_id'
    ];

    protected $casts = [
        'created_at' => 'datetime:m/d/Y',
        'user_id'    => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pharmacy() {
        return $this->belongsTo(Provider::class, 'pharmacy_id', 'id');
    }

    public function pharmacy2() {
        return $this->belongsTo(Provider::class, 'pharmacy_id', 'user_id');
    }
}
