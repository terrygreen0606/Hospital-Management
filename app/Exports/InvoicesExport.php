<?php

namespace App\Exports;

use App\Invoice;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;

class InvoicesExport implements FromQuery
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
        return Invoice::query()->whereDate('created_at', $this->date);
    }
}
