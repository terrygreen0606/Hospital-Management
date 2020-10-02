<?php

namespace App\Imports;

use App\Invoice;
use App\Notifications\AvailablePrescription;
use App\Notifications\InvoiceUpdated;
use App\Notifications\TrackingNumber;
use App\Order;
use App\Patient;
use App\User;
use App\Provider;
use App\Prescriber;
use App\OrderDuplicate;
use App\PatientProviderPrescriber;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Illuminate\Http\Request;

//, WithStartRow
class InvoiceImport implements ToCollection, WithStartRow
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
        $pharmacy_id = session("pharmacy_id");
        $sent = false;
        foreach ($rows as $row) {
            if (empty($row[0]) || empty($row[25])) {
                continue;
            }

            $dob_date = isset($row['25']) && !empty($row['25'])
                ? collect(Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['25']))->format('mdy'))
                : array();
            
            $current_transaction_status_date = isset($row['1']) && !empty($row['1'])
                ? collect(Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['1']))->format('m/d/y'))
                : array();

            $date_filled = isset($row['5']) && !empty($row['5'])
                ? collect(Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['5']))->format('m/d/y'))
                : array();

            $date_written = isset($row['6']) && !empty($row['6'])
                ? collect(Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['6']))->format('m/d/y'))
                : array();

            $rx_status_changed_on = isset($row['8']) && !empty($row['8'])
                ? collect(Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['8']))->format('m/d/y'))
                : array();
            
            $check_user_phone = User::where("phone", preg_replace('/\D+/', '', $row[24]));
            if($check_user_phone->count() > 0) {

                $user_dob = $check_user_phone->where("dob", $dob_date[0]);

                if($user_dob->count() <= 0) {
                    $order_dup = new OrderDuplicate;
                    $order_dup->status                         = "Phone number already exist but with different DOB";
                    $order_dup->data                           = json_encode($row);
                    $order_dup->name                           = "$row[18] $row[19]";
                    $order_dup->prescriber_name                = "$row[28] $row[29]";
                    $order_dup->rx_number                      = $row[0];
                    $order_dup->current_transaction_status_date= $current_transaction_status_date[0];
                    $order_dup->priority                       = $row[2];
                    $order_dup->dispensed_item_name            = $row[3];
                    $order_dup->current_transaction_status     = $row[4];
                    $order_dup->date_filled                    = $date_filled[0];
                    $order_dup->date_written                   = $date_written[0];
                    $order_dup->rx_status                      = $row[7];
                    $order_dup->rx_status_changed_on           = $rx_status_changed_on[0];
                    $order_dup->number_of_refills_allowed      = $row[9];
                    $order_dup->directions_translated          = $row[10];
                    $order_dup->rx_total_quantity_remaining    = $row[11];
                    $order_dup->refills_remaining              = $row[12];
                    $order_dup->refill_number                  = $row[13];
                    $order_dup->dispensed_quantity             = $row[14];
                    $order_dup->days_supply                    = $row[15];
                    $order_dup->total_price_paid               = number_format($row[16], 2);
                    $order_dup->patient_paid_amount            = number_format($row[17], 2);
                    $order_dup->dispensed_item_ndc             = $row[26];
                    $order_dup->serial_number                  = $row[27];
                    $order_dup->prescriber_npi                 = $row[32];
                    $order_dup->pharmacy_name                  = $row[33];
                    $order_dup->tracking_number                = $row[34] ?? 'N/A';
                    $order_dup->save();
                    continue;
                }
                
            }

            $user = User::updateOrCreate([
                "phone" => preg_replace('/\D+/', '', $row[24]),
                ], [
                "name"  => "$row[18] $row[19]",
                "email" => '',
                "phone" => preg_replace('/\D+/', '', $row[24]),
                "role"  => 'patient',
                "dob"   => $dob_date[0],
                "uuid"  => ""
            ]);
            
            $date = date("ymd");
            $number = "RX-{$row[27]}-{$user->id}-{$date}";
            
            
            if(!$pharmacy_id) {
                $phar = Provider::where('name', 'like', "%{$row[33]}%")->first();
                if ($phar) {
                    $phar_id = $phar->id;
                } else {
                    $phar_id = null;
                }
                
            } else {
                $phar = Provider::where('user_id', $pharmacy_id)->first();
                $phar_id = $phar->id;
            }

            $patient = Patient::updateOrCreate([
                "user_id" => $user->id,
            ], [
                "address"       => empty($row[20]) ? 'N/A' : $row[20],
                "city"          => $row[21],
                "state"         => $row[22],
                "zip_code"      => $row[23],
                "serial_number" => $row[27],
                "category"      => $row[31],
                "user_id"       => $user->id,
                "pharmacy_id"   => $phar_id
            ]);

            $order = Order::where([
                "rx_number"     => $row[0],
                "refill_number" => $row[13],
                "pharmacy_name" => $row[33],
            ]);


            if($order->count() == 1){
                $order = $order->first();

                if($order->current_transaction_status !== 'Completed')
                { 
                    $order->priority                   = $row[2];
                    $order->dispensed_item_name        = $row[3];
                    $order->current_transaction_status = $row[4];
                    $order->rx_status                  = $row[7];
                    $order->rx_status_changed_on       = $rx_status_changed_on[0];
                    $order->number_of_refills_allowed  = $row[9];
                    $order->directions_translated      = $row[10];
                    $order->rx_total_quantity_remaining= $row[11];
                    $order->refills_remaining          = $row[12];
                    $order->dispensed_quantity         = $row[14];
                    $order->days_supply                = $row[15];
                    $order->total_price_paid           = number_format($row[16], 2);
                    $order->patient_paid_amount        = number_format($row[17], 2);
                    $order->save();
                }else{
                    $order->tracking_number            = $row[34] ?? 'N/A';
                    $order->save();
                }
                
            }else{
                $order = new Order;
                $order->rx_number                      = $row[0];
                $order->current_transaction_status_date= $current_transaction_status_date[0];
                $order->priority                       = $row[2];
                $order->dispensed_item_name            = $row[3];
                $order->current_transaction_status     = $row[4];
                $order->date_filled                    = $date_filled[0];
                $order->date_written                   = $date_written[0];
                $order->rx_status                      = $row[7];
                $order->rx_status_changed_on           = $rx_status_changed_on[0];
                $order->number_of_refills_allowed      = $row[9];
                $order->directions_translated          = $row[10];
                $order->rx_total_quantity_remaining    = $row[11];
                $order->refills_remaining              = $row[12];
                $order->refill_number                  = $row[13];
                $order->dispensed_quantity             = $row[14];
                $order->days_supply                    = $row[15];
                $order->total_price_paid               = number_format($row[16], 2);
                $order->patient_paid_amount            = number_format($row[17], 2);
                $order->dispensed_item_ndc             = $row[26];
                $order->serial_number                  = $row[27];
                $order->prescriber_npi                 = $row[32];
                $order->pharmacy_name                  = $row[33];
                $order->tracking_number                = $row[34] ?? 'N/A';
                $order->user_id                        = $user->id;
                $order->save();
            }
            
            if(isset($row['33']) && !empty($row['33'])){

                $prescriber = Prescriber::where('npi', $row[32])->first();
                $pres_id = 0;

                if($prescriber) $pres_id = $prescriber->user_id;
                else {
                    $pres_data = array(
                        "name"      => "$row[28] $row[29]",
                        "address"   => "",
                        "state"     => "",
                        "status"    => "Non-Premium",
                        "npi"       => $row[32],
                        "uuid"      => "",
                        "dob"       => substr($row[32], -6),
                        "role"      => "doctor",
                        "phone"     => preg_replace('/[^0-9]/', '', $row[24])
                    );

                    $pres = User::create($pres_data);
                    $pres_data['user_id'] = $pres->id;
                    $pres = Prescriber::create($pres_data);
                    $pres_id = $pres->id;
                }

                $pres_id = $pres_id == '' ? 0 : $pres_id;

                if($phar_id) {
                    $data = array(
                        'patient_id'    => $user->id,
                        'provider_id'   => $phar_id,
                        'prescriber_id' => $pres_id,
                        'order_id'      => $order->id,
                    );
                    
                    $ppp = PatientProviderPrescriber::create($data);
                }

            }

            $invoice = Invoice::where('number', $number)->first();

            if ($invoice) {
                $my_orders = $invoice->orders ?? [];

                if (!in_array($order->id, $my_orders)) {
                   array_push($my_orders, $order->  id);
                }

                $invoice->orders = $my_orders;
                $invoice->amount += number_format($row[16], 2);
                $invoice->save();
        
                if($sent == false) {
                    // $user->notify(new InvoiceUpdated($invoice));
                    $sent = true;
                }
                
            } else {    
                if (($row[2] == 'D-Print') || ($row[2] == 'E-Auto Refills') || empty($row[25])) {
                    continue;
                }


                $invoice = Invoice::create([
                    'user_id'       => $user->id,
                    'amount'        => number_format($row[16], 2),
                    'orders'        => [$order->id],
                    "serial_number" => $row[27],
                    'number'        => $number,
                ]);

                if (($row[2] == 'NimbleALL') && ($row[4] == 'Waiting for Print')) {
                    // $user->notify(new AvailablePrescription($invoice));
                }
            }
            
            if (isset($row[34]) && !empty($row[34]) && ($row[4] == 'Completed')) {
                // $user->notify(new TrackingNumber($row[33], $row[34]));
            }
        }
        
        session()->flush();
    }
}
