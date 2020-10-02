<?php

namespace App\Imports;

use App\Order;
use App\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;

class OrderImport implements ToCollection, WithStartRow
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

            $user = User::firstOrCreate([
                "phone" => preg_replace('/\D+/', '', $row[24]),
                "dob"   => date('mdy', strtotime($row[25])),
            ], [
                "name"  => "$row[18] $row[19]",
                "email" => 'N/A',
                "phone" => preg_replace('/\D+/', '', $row[24]),
                "role"  => 'patient',
                "dob"   => date('mdy', strtotime($row[25])),
            ]);

            Order::create(
                [
                    "rx_number"                       => $row[0],
                    "current_transaction_status_date" => date('Y-m-d H:i:s', strtotime($row[1])),
                    "priority"                        => $row[2],
                    "dispensed_item_name"             => $row[3],
                    "current_transaction_status"      => $row[4],
                    "date_filled"                     => $row[5],
                    "date_written"                    => $row[6],
                    "rx_status"                       => $row[7],
                    "rx_status_changed_on"            => $row[8],
                    "number_of_refills_allowed"       => $row[9],
                    "directions_translated"           => $row[10],
                    "rx_total_quantity_remaining"     => $row[11],
                    "refills_remaining"               => $row[12],
                    "refill_number"                   => $row[13],
                    "dispensed_quantity"              => $row[14],
                    "days_supply"                     => $row[15],
                    "total_price_paid"                => number_format($row[16], 2),
                    "patient_paid_amount"             => number_format($row[17], 2),
                    "serial_number"                   => $row[27],
                    "dispensed_item_ndc"              => $row[26],
                    "prescriber_npi"                  => $row[32],
                    "pharmacy_name"                   => $row[33],
                    "user_id"                         => $user->id,
                ]
            );
        }
    }
}
