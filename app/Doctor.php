<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $fillable = [
        'address',
        'city',
        'state',
        'zip_code',
        'serial_number',
        'category',
        'user_id',
    ];

    protected $casts = [
        'created_at' => 'datetime:m/d/Y',
        'user_id'    => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
