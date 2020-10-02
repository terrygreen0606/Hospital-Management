<?php

namespace App\Imports;

use App\Product;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;

class ProductImport implements ToCollection, WithStartRow
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
     * @return  \Illuminate\Database\Eloquent\Collection|null
     */
    public function collection(Collection $rows)
    {

        foreach ($rows as $row) {
            if (empty($row[0])) {
                continue;
            }

            Product::create(
                [
                    'ndc'    => str_replace('-', '', $row[0]),
                    'name'   => $row[1],
                    'size'   => $row[2],
                    'price'  => number_format($row[3], 2),
                    'vendor' => $row[4],
                ]
            );
        }
    }
}
