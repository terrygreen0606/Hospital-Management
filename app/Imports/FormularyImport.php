<?php

namespace App\Imports;

use App\Formulary;
use Illuminate\Support\Collection;
// use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class FormularyImport implements ToModel, WithStartRow, WithBatchInserts, WithChunkReading
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
        return 10;
    }

    public function chunkSize(): int
    {
        return 10;
    }

    /**
     * @param array $row
     *
     * @return  \Illuminate\Database\Eloquent\Collection|null
     */
    public function model(array $row)
    {
        return new Formulary([
            'disease_state' => $row[0],
            'product_type' => $row[1],
            'product_name' => $row[2],
            'size' => $row[3],
            'brand' => $row[4],
            'insurance' => $row[5],
            'drx_club' => $row[6],
            'stock_status' => $row[7],
            'available_with_insurance' => $row[8],
            'eta' => $row[9],
        ]);
    }
}
