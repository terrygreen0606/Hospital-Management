<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NDCWithVideo extends Model
{
    protected $fillable = ['ncd9_formatted', 'name', 'dosage_form_name', 'route_name'];
}
