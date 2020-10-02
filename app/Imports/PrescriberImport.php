<?php

namespace App\Imports;

use App\Prescriber;
use App\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;

class PrescriberImport implements ToCollection, WithStartRow
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
    public function collection(Collection $rows)
    {
        $count = 1;
        foreach ($rows as $row) {
            
            if($count > 1)
            {
                if (empty($row[0])) {
                    continue;
                }
                
                $data = array(
                    "name"      => "$row[0]",
                    "address"   => "$row[5]",
                    "state"     => "",
                    "status"    => "Non-Premium",
                    "npi"       => $row[1],
                    "uuid"      => "",
                    "dob"       => substr($row[1], -6),
                    "role"      => "prescriber",
                    "phone"     => preg_replace('/[^0-9]/', '', $row[3]),
                    "dea"       => $row[2]
                );

                // $npi = intval($row[0]);
                // $data = array(
                //     "name"      => "$row[1]",
                //     "address"   => "$row[2]",
                //     "state"     => "$row[3]",
                //     "status"    => "$row[4]",
                //     "npi"       => $npi,
                //     "uuid"      => "",
                //     "dob"       => substr($npi, -6),
                //     "role"      => "prescriber"
                // );

                $pres = Prescriber::where('npi', $row[1])->first();

                if($pres){
                    $data['phone'] = $pres->phone;
                    $user = User::updateOrCreate(
                        [
                            "phone" => $pres->phone,
                            "dob"   => substr($row[1], -6),
                        ],
                        $data
                    );

                    $data['user_id'] = $user->id;
                    $pres->update($data);

                }else{
                    $user = User::create($data);
                    $data['user_id'] = $user->id;
                    $pres = Prescriber::create($data);

                }
            }
            $count++;
        }
    }
}
