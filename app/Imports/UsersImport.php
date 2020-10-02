<?php

namespace App\Imports;

use App\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;


class UsersImport implements ToModel

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
        return new User([
            'name'   => $row[0],
            'avatar' => $row[1],
            'email'  => $row[2],
            'phone'  => $row[3],
            'password' => $row[4],
            'role' => $row[5],
            'lang' => $row[6],
            'otp' => $row[7],
            'provider' => $row[8],
            'provider_id' => $row[9],
            'meta' => $row[10],
            'theme' => $row[11],
        ]);
    }
}
