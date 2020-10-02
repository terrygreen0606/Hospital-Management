<?php

namespace App\Imports;

use App\ArchiveOrder;
use Illuminate\Support\Collection;
// use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Carbon\Carbon;

class OrderArchiveImport implements ToModel, WithStartRow, WithBatchInserts, WithChunkReading
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

    public function batchSize(): int
    {
        return 1000;
    }

    public function chunkSize(): int
    {
        return 50000;
    }
    /**
    * @param array $row
    *
    * @return  \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // dd(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[5]));
        // dd(Carbon::createFromFormat($row[5]));
        return new ArchiveOrder([
            'rx_number' => $row[0],
            'prescriber_full_name' => $row[1],
            'prescriber_npi' => $row[2],
            'prescriber_primary_city' => $row[3],
            'prescriber_primary_state' => $row[4],
            'date_filled' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[5])->format('d/m/Y'),
            'refill_or_new' => $row[6],
            'dispensed_item_name' => $row[7],
            'dispensed_item_ndc' => $row[8],
            'dispensed_item_dosage_form' => $row[9],
            'dispensed_item_stock_size' => $row[10],
            'dispensed_quantity' => $row[11],
            'pay_method' => $row[12],
            'primary' => $row[13],
            'pharmacy' => $row[14],
        ]);
    }
}
