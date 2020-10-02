<?php

namespace App\Http\Controllers\Api;

use App\Report;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Log;

use App\Notifications\AvailablePrescription;
use App\Notifications\TrackingNumber;
use App\Order;
use App\Patient;
use App\User;
use App\Pioneer;
use App\Invoice;
use App\Provider;
use App\Prescriber;
use App\PatientProviderPrescriber;
use Illuminate\Support\Carbon;


class PioneerController extends Controller
{
    public function index(Request $request) {
        $header = $request->header('Authorization');
        $data = $request->all();

        if($header == 'Basic RGVybVJYOmQzck1yWHAxMG4zM3I=' || $header == 'Basic RGVybVJ4OmQzck1yWHAxMG4zM3I=') {
            $mess_id = $data['MessageHeader']['MessageID'];
            $jsonData = json_encode($data);

            $this->saveData($data);

            $pioneer = new Pioneer;
            $pioneer->data = $jsonData;
            $pioneer->status = 'success';
            $pioneer->save();

            Log::info($jsonData);

            if($pioneer) {
                $response = [
                    "Message_Header"    => [
                        "Message_ID"    => $mess_id,
                        "Message_Type"  => "ACK"
                    ]
                ];

                return response()->json($response);
            }
            $response = [
                "Message_Header"    => [
                    "Message_ID"    => $mess_id,
                    "Message_Type"  => "NAK",
                    "Error"         => "Error saving data"
                ]
            ];
            return $response;
        } else{
            $pioneer = new Pioneer;
            $pioneer->data = json_encode($data);
            $pioneer->status = 'Authentication Failed';
            $pioneer->save();

            $response = [
                "Message_Header"    => [
                    "Message_ID"    => $data['MessageHeader']['MessageID'],
                    "Message_Type"  => "NAK",
                    "Error"         => "Wrong credentials"
                ]
            ];
            return $response;
        }

    }

    public function getAll(Request $request) {
        $record = Pioneer::query();
        $res =  $record->orderBy('created_at', 'desc')->paginate(10);
        return response()->json($res);
    }

    public function saveData($data)
    {

        $patient = $data['Body']['Patient'];
        $rx = $data['Body']['Rx'];
        $pharmacy = $data['Body']['Pharmacy'];
        $prescriber = $data['Body']['Prescribers'];

        $dob_date = isset($patient['DateOfBirth']) && !empty($patient['DateOfBirth'])
                ? date("mdy",strtotime($patient['DateOfBirth']))
                : array();

        // $phone_numbers = $patient['PhoneNumbers']['PhoneNumber'];
        $phone_numbers = isset($patient['PhoneNumbers']['PhoneNumber']) && !empty($patient['PhoneNumbers']['PhoneNumber']) ? $patient['PhoneNumbers']['PhoneNumber'] : null;
        $phone_number = null;
        $uuid = $patient['Identification']['PatientPioneerRxID'];
        $name = $patient['Name']['LastName'] . " " . $patient['Name']['FirstName'];
        $email = $patient['Email'];
        $serialNumber = $patient['Identification']['SerialNumberPerson'];
        $addresses = $patient['Addresses']['Address'];
        $address = null;
        $city = null;
        $state = null;
        $zipCode = null;
        $zipCode = null;

        if($phone_numbers !== null){
            foreach($phone_numbers as $pn){
                if($pn['Type'] == 'Primary') $phone_number = $pn['AreaCode'] . $pn['Number'];
            }
        }

        foreach($addresses as $row){
            if($row['Type'] == 'Primary'){
                $address = $row['AddressLine'];
                $city = $row['City'];
                $state = $row['StateCode'];
                $zipCode = $row['ZipCode'];
            }
        }


        $user = User::updateOrCreate([
            "uuid" => preg_replace('/\D+/', '', $uuid)
        ], [
            "uuid"  => preg_replace('/\D+/', '', $uuid),
            "name"  => $name,
            "email" => $email,
            "phone" => preg_replace('/\D+/', '', $phone_number),
            "role"  => 'patient',
            "dob"   => $dob_date,
        ]);

        $date = date("ymd");
        $number = "RX-{$serialNumber}-{$user->id}-{$date}";
        
        $phar_id = null;
        $phar = Provider::where('name', 'like', "%{$pharmacy['PharmacyName']}%")->first();
        if($phar) {
            $phar_id = $phar->user_id;
        }

        $patient = Patient::updateOrCreate([
            "user_id" => $user->id,
        ], [
            "address"       => empty($address) ? 'N/A' : $address,
            "city"          => $city,
            "state"         => $state,
            "zip_code"      => $zipCode,
            "serial_number" => $serialNumber,
            "category"      => null,
            "user_id"       => $user->id,
            "pharmacy_id"   => $phar_id
        ]);

        $current_transaction_status_date = $rx['RxStatusChangedOnDateTimeUTC'];
        $date_filled = $rx['DateFilledUTC'];
        $date_written = $rx['DateWritten'];
        $rx_status_changed_on = $rx['RxTransactionStatusChangedOnDateTimeUTC'];
        $rxNumber = $rx['RxNumber'];
        $refillNumber = $rx['RefillNumber'];
        $pharmacyName = $pharmacy['PharmacyName'];
        $priority = $rx['PriorityTypeText'];
        $itemName = $rx['MedicationPrescribed']['WrittenName'];
        $currentTransactionStatus = $rx['CurrentRxTransactionStatusText'];
        $currentRxStatus = $rx['CurrentRxStatusText'];
        $refillsAllowed = $rx['NumberOfRefillsAllowed'];
        $direction = $rx['DirectionsTranslatedEnglish'];
        $quantityRemaining = $rx['QuantityRemaining'];
        $refillsRemaining = $rx['QuantityRemaining'];
        $dispensedQuantity = $rx['MedicationDispensed']['PartialFillTotalDispensedQuantity'];
        $daysSupply = $rx['MedicationDispensed']['DaysSupply'];
        $totalPricePaid = str_replace(",", "", $rx['TotalPricePaid']);
        $patientPaidAmount = str_replace(",", "", $rx['PatientPaidAmount']);
        $ndc = $rx['MedicationPrescribed']['NDC'];
        $prescriberNPI = $prescriber['Prescriber'][0] ? $prescriber['Prescriber'][0]['Identification']['NPI'] : null;
        $prescriberUUID = $prescriber['Prescriber'][0] ? $prescriber['Prescriber'][0]['Identification']['PrescriberPioneerRxID'] : null;
        $trackingNumber = $rx['TrackingNumber'];
        $prescriberAddress = isset($prescriber['Prescriber'][0]['Addresses']['Address'][0]) ? $prescriber['Prescriber'][0]['Addresses']['Address'][0] : null;

        $order = Order::where([
            "rx_number"     => $rxNumber,
            "refill_number" => $refillNumber,
            "pharmacy_name" => $pharmacyName,
        ]);
        if($order->count() == 1){

            $order = $order->first();
            if($res->current_transaction_status !== 'Completed')
            {
                $order->priority                   = $priority;
                $order->dispensed_item_name        = $itemName;
                $order->current_transaction_status = $currentTransactionStatus;
                $order->rx_status                  = $currentRxStatus;
                $order->rx_status_changed_on       = date("m/d/y",strtotime($rx_status_changed_on));
                $order->number_of_refills_allowed  = $refillsAllowed;
                $order->directions_translated      = $direction;
                $order->rx_total_quantity_remaining= number_format($quantityRemaining);
                $order->refills_remaining          = number_format($refillsRemaining);
                $order->dispensed_quantity         = $dispensedQuantity;
                $order->days_supply                = $daysSupply;
                $order->total_price_paid           = $totalPricePaid;
                $order->patient_paid_amount        = $patientPaidAmount;
                $order->save();
            }
        }else{
            $order = new Order;
            $order->rx_number                      = $rxNumber;
            $order->current_transaction_status_date= date("m/d/y",strtotime($current_transaction_status_date));
            $order->priority                       = $priority;
            $order->dispensed_item_name            = $itemName;
            $order->current_transaction_status     = $currentTransactionStatus;
            $order->date_filled                    = ate("m/d/y",strtotime($date_filled));
            $order->date_written                   = date("m/d/y",strtotime($date_written));
            $order->rx_status                      = $currentRxStatus;
            $order->rx_status_changed_on           = date("m/d/y",strtotime($rx_status_changed_on));
            $order->number_of_refills_allowed      = $refillsAllowed;
            $order->directions_translated          = $direction;
            $order->rx_total_quantity_remaining    = number_format($quantityRemaining);
            $order->refills_remaining              = number_format($refillsRemaining);
            $order->refill_number                  = $refillNumber;
            $order->dispensed_quantity             = $dispensedQuantity;
            $order->days_supply                    = $daysSupply;
            $order->total_price_paid               = $totalPricePaid;
            $order->patient_paid_amount            = $patientPaidAmount;
            $order->dispensed_item_ndc             = $ndc;
            $order->serial_number                  = $serialNumber;
            $order->prescriber_npi                 = $prescriberNPI;
            $order->pharmacy_name                  = $pharmacyName;
            $order->tracking_number                = $trackingNumber ?? 'N/A';
            $order->user_id                        = $user->id;
            $order->save();
            $order = new Order;
        }
        
        $presc = Prescriber::where('npi', $prescriberNPI)->first();
        $pres_id = 0;
        if($presc) $pres_id = $presc->user_id == '' ? 0 : $presc->user_id;

        if(!$presc) {

            $phone_numbers = $prescriber['Prescriber'][0] ? $prescriber['Prescriber'][0]['PhoneNumbers']['PhoneNumber'] : [];
            $phone_number = 0;

            if($phone_numbers !== null){
                foreach($phone_numbers as $pn){
                    if($pn['Type'] == 'Primary') $phone_number = $pn['AreaCode'] . $pn['Number'];
                }
            }
            
            $pres_data = array(
                "name"      => $prescriber['Prescriber'][0]['Name']['FirstName'] . " " . $prescriber['Prescriber'][0]['Name']['LastName'],
                "address"   => $prescriberAddress != null ? $prescriberAddress['AddressLine'] : '',
                "state"     => $prescriberAddress != null ? $prescriberAddress['StateCode'] : '',
                "status"    => "Non-Premium",
                "npi"       => $prescriberNPI,
                "uuid"      => $prescriberUUID,
                "dob"       => substr($prescriberNPI, -6),
                "role"      => "prescriber",
                "phone"     => $phone_number
            );

            $user = User::create($pres_data);
            $pres_data['user_id'] = $user->id;
            $pres = Prescriber::create($pres_data);
            $pres_id = $user->id;
        }

        $provider = Provider::where('name', 'like', "%{$pharmacyName}%")->first();

        if($provider) {
            $data = array(
                'patient_id'    => $user->id,
                'provider_id'   => $provider->user_id,
                'prescriber_id' => $pres_id,
                'order_id'      => $order->id,
            );
            $ppp = PatientProviderPrescriber::create($data);
        }else{

            $dataPhar['avatar'] = "https://api.adorable.io/avatars/285/{$pharmacy['Email']}";
            $dataPhar['uuid'] = $pharmacy['Identification']['PharmacyPioneerRxID'];
            $dataPhar['role'] = 'provider';
            $dataPhar['name'] = $pharmacy['PharmacyName'];
            $dataPhar['email'] = $pharmacy['Email'];

            $pn = isset($pharmacy['PhoneNumbers']['PhoneNumber'][0]) && $pharmacy['PhoneNumbers']['PhoneNumber'][0] !==null ? $pharmacy['PhoneNumbers']['PhoneNumber'][0] : null;
            $dataPhar['phone'] = $pn !== null ? $pn['AreaCode'] . $pn['Number'] : null;

            $dataPhar['pharmacy_pioneer_rx_id'] = $dataPhar['uuid'];
            $dataPhar['web_address'] = $pharmacy['WebAddress'];

            $add = isset($pharmacy['Addresses']['Address'][0]) && $pharmacy['Addresses']['Address'][0] !== null ? $pharmacy['Addresses']['Address'][0] : null;
            $dataPhar['address'] = $add !== null ? $add['AddressLine'] : null;
            $dataPhar['city'] = $add !== null ? $add['City'] : null;
            $dataPhar['state'] = $add !== null ? $add['StateCode'] : null;
            $dataPhar['zipcode'] = $add !== null ? $add['ZipCode'] : null;

            $dataPhar['ncpdp'] = $pharmacy['Identification']['NCPDP'];
            $dataPhar['npi'] = $pharmacy['Identification']['NPI'];
            $dataPhar['dea'] = $pharmacy['Identification']['DEA'];
            $dataPhar['dob'] = substr($dataPhar['npi'], -6);

            $create = User::create($dataPhar);

            $dataPhar['user_id'] = $create->id;

            $provider = Provider::create($dataPhar);

            $dataPPP = array(
                'patient_id'    => $user->id,
                'provider_id'   => $create->id,
                'prescriber_id' => 0,
                'order_id'      => $order->id,
            );
            $ppp = PatientProviderPrescriber::create($dataPPP);
        }

        if($currentTransactionStatus == "Waiting for Print"){

            $invoice = Invoice::where('number', $number)->first();

            if ($invoice) {
                $orders = $invoice->orders ?? [];

                if (!in_array($order->id, $orders)) {
                    $orders[] = $order->id;
                }

                $invoice->orders = $orders;
                $invoice->amount += $totalPricePaid;
                $invoice->save();
            } else {

                $invoice = Invoice::create([
                    'user_id'       => $user->id,
                    'amount'        => $totalPricePaid,
                    'orders'        => [$order->id],
                    "serial_number" => $serialNumber,
                    'number'        => $number,
                ]);

            }
            
            // $user->notify(new AvailablePrescription($invoice));
            return $invoice;
        }
    }

}
