<?php

namespace App\Exports;

use App\Customer;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;

class CustomersExport implements FromQuery
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
        return Customer::query()->whereDate('created_at', $this->date);
    }
}
