<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;

use App\AdminVideo;

class AdminVideoImport implements ToCollection, WithStartRow
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
                'admin_video_id'    =>$row[0],
                'admin_video_title' =>$row[1]
            ];

            $insert_data[] = $data;
        }

        $insert_data = collect($insert_data);
        $chunks = $insert_data->chunk(500);

        foreach ($chunks as $chunk)
        {
            AdminVideo::insert($chunk->toArray());
        }
    }
}
