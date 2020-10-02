<?php

namespace App\Imports;

use App\Payment;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;


class PaymentsImport implements ToModel, WithStartRow
{
    /**
     * Skip the heading row
     *
     * @return int
     */
    public function startRow(): int 
    {
        return 2;
    }
    /**
    * @param array $row
    *
    * @return  \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Payment([
            //
        ]);
    }
}
