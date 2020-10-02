<?php

namespace App\Exports;

use App\Payment;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;

class PaymentsExport implements FromQuery
{
    use Exportable;
    
    protected $date;

    function __construct($date){
        $this->date = $date;
    }

    /**
     * @return \Illuminate\Support\Query
     */
    public function query()
    {
        return Payment::query()->whereDate('created_at', $this->date);
    }
}
