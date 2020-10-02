<?php

namespace App\Exports;

use App\User;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;

class UsersExport implements FromQuery
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
        return User::query()->whereDate('created_at', $this->date);
    }
}
