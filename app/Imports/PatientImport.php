<?php

namespace App\Imports;

use App\User;
use App\Patient;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;

class PatientImport implements ToCollection, WithStartRow
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
            User::firstOrCreate(
                [
                    "phone" => preg_replace('/\D+/', '', $row[24]),
                    "dob"   => $row[25],
                ],
                [
                    "name"    => "$row[18] $row[19]",
                    "address" => empty($row[20]) ? 'N/A' : $row[20],
                    "email"   => ' ',
                    "phone"   => preg_replace('/\D+/', '', $row[24]),
                    "role"    => 'patient',
                    "dob"     => $row[25],
                ]
            );

            Patient::firstOrCreate(
                [
                    'serial_number' => $row[27]
                ],
                [
                    "last_name"     => $row[18],
                    "first_name"    => $row[19],
                    "address"       => $row[20],
                    "city"          => $row[21],
                    "state"         => $row[22],
                    "zip_code"      => $row[23],
                    "phone"         => preg_replace('/\D+/', '', $row[24]),
                    "dob"           => $row[25],
                    "serial_number" => $row[27],
                    "category"      => $row[31],
                ]
            );
        }
    }
}
