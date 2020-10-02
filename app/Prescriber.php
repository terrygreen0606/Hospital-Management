<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Prescriber extends Model
{
    protected $fillable = [
        "user_id",
        "created_time",
        "assigned_to",
        "prescribers_no",
        "created_by",
        "modified_time",
        "last_modified_by",
        "source",
        "dps",
        "dea",
        "classification",
        "upin",
        "group_code",
        "alternate_id",
        "legacy_number",
        "npi",
        "primary_address",
        "name",
        "address",
        "prescriber_type",
        "suite_no",
        "phone",
        "city",
        "fax",
        "state",
        "specialization",
        "zip_code",
        "state_license",
        "status"
    ];

    protected $casts = [
        'created_at' => 'datetime:m/d/Y',
    ];

    public function orders() {
        return $this->hasMany('App\Order', 'prescriber_npi', 'npi');
    }
}
