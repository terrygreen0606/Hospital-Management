<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ArchiveOrder extends Model
{
	public $timestamps = true;
	
    protected $fillable = [
    	'rx_number',
		'prescriber_full_name',
		'prescriber_npi',
		'prescriber_primary_city',
		'prescriber_primary_state',
		'date_filled',
		'refill_or_new',
		'dispensed_item_name',
		'dispensed_item_ndc',
		'dispensed_item_dosage_form',
		'dispensed_item_stock_size',
		'dispensed_quantity',
		'pay_method',
		'primary',
		'pharmacy',
    ];

    // protected $casts = [
    // 	'date_filled' => 'datetime:d/m/Y',
    // ];
}
