<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LoginRequest extends Model
{
    protected $table = 'login_requests';

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function setTokenAttribute()
    {
        $this->attributes['token'] = $this->user->generateAUserToken();
    }
}
