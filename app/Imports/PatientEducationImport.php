<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;

use App\NDCWithVideo;

class PatientEducationImport implements ToCollection, WithStartRow
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
        $insert_data = [];

        foreach ($rows as $row) {
            if (empty($row[0])) continue;

            $data = [
                'ncd9_formatted'    =>$row[0],
                'name'              =>$row[1],
                'dosage_form_name'  =>$row[2],
                'route_name'        =>$row[3]
            ];

            $insert_data[] = $data;
        }

        $insert_data = collect($insert_data);
        $chunks = $insert_data->chunk(500);

        foreach ($chunks as $chunk)
        {
            NDCWithVideo::insert($chunk->toArray());
        }
    }
}
