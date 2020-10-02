<?php

namespace App\Http\Controllers\Api;

use App\IntakeQ;
use App\User;
use App\Patient;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IntakeQController extends Controller
{
    public function index(Request $request) {

        $response = $this->getIntakeIDData($request);
        
        $statusCode = $response->getStatusCode();
        $content = $response->getBody()->getContents();
        $data = json_decode($content, true);

        if($statusCode == 200 & $data['Status'] == 'Completed') {

            $intakeq = new IntakeQ;
            $intakeq->data = $content;

            $client_id = $data['ClientId'];

            $patient_request = $this->getPatientData($client_id);
            $statusCodeP = $patient_request->getStatusCode();

            if($statusCodeP == 200){
                $patient_content = $patient_request->getBody()->getContents();
                $patient = json_decode($patient_content, true);

                $p_data['first_name'] = $patient[0]['FirstName'];
                $p_data['last_name'] = $patient[0]['LastName'];
                $p_data['phone_num'] = $patient[0]['Phone'];
                $birthData = $patient[0]['DateOfBirth'];
                $p_data['dob'] = date("mdy", $birthData);
                $p_data['address'] = $patient[0]['Address'];
                $p_data['city'] = $patient[0]['City'];
                $p_data['state'] = $patient[0]['State'];
                $p_data['postal_code'] = $patient[0]['PostalCode'];

                $user_data = User::where('role', 'patient')
                            ->where('name', 'like', '%' . $p_data['first_name'] . '%')
                            ->Where('name', 'like', '%' . $p_data['last_name'] . '%')
                            ->with(['patient']);

                $score = 0;
                $mismatches = [];
                $matches = [];
                $match_type = "New Data";

                if($user_data->count() > 0) {
                    $score = 2;
                    $matches = ['First name', 'Last name'];
                    $user = $user_data->first();

                    // Compare phone number
                    if($p_data['phone_num'] == $user->phone){
                        $score ++;
                        array_push($matches, 'Phone number');
                    }else{
                        array_push($mismatches, 'Phone number');
                    }

                    // Compare Date of birth
                    if($p_data['dob'] == $user->dob){
                        $score ++;
                        array_push($matches, 'Date of Birth');
                    }else{
                        array_push($mismatches, 'Date of Birth');
                    }

                    // Compare address
                    if($p_data['address'] == $user->patient->address){
                        $score ++;
                        array_push($matches, 'Address');
                    }else{
                        array_push($mismatches, 'Address');
                    }

                    // Compare City
                    if($p_data['city'] == $user->patient->city){
                        $score ++;
                        array_push($matches, 'City');
                    }else{
                        array_push($mismatches, 'City');
                    }

                    // Compare State
                    if($p_data['state'] == $user->patient->state){
                        $score ++;
                        array_push($matches, 'State');
                    }else{
                        array_push($mismatches, 'State');
                    }

                    // Compare address
                    if($p_data['postal_code'] == $user->patient->zip_code){
                        $score ++;
                        array_push($matches, 'Zip code');
                    }else{
                        array_push($mismatches, 'Zip code');
                    }

                    if($score == 8) {
                        $match_type = "100% match";
                    }elseif($score < 8 && $score > 0) {
                        $match_type = 'Partial';
                    }

                } else {
                    $user = User::create([
                        "uuid"  => "",
                        "name"  => $patient[0]['FirstName'] . " " . $patient[0]['LastName'],
                        "email" => $patient[0]['Email'],
                        "phone" => $patient[0]['Phone'],
                        "role"  => 'patient',
                        "dob"   => $p_data['dob'],
                    ]);

                    $new_patient = Patient::updateOrCreate([
                        "address"       => empty($p_data['address']) ? 'N/A' : $p_data['address'],
                        "city"          => empty($p_data['city']) ? 'N/A' : $p_data['city'],
                        "state"         => empty($p_data['state']) ? 'N/A' : $p_data['adstatedress'],
                        "zip_code"      => empty($p_data['postal_code']) ? 'N/A' : $p_data['postal_code'],
                        "serial_number" => "",
                        "category"      => null,
                        "user_id"       => $user->id,
                    ]);
                }

                $intakeq->name = $patient[0]['FirstName'] . " " . $patient[0]['LastName'];
                $intakeq->match_type = $match_type;
                $intakeq->matches = json_encode($matches);
                $intakeq->mismatches = json_encode($mismatches);
                $intakeq->save();

                return $patient;
            }
        }

        return true;
    }

    public function getPatientData($id) {
        $endpoint = "https://intakeq.com/api/v1/clients?search=" . $id . "&includeProfile=true";
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', $endpoint, [
            'headers' => [
                'Accept'     => 'application/json',
                'x-auth-key'     => env("INTAKEQ_KEY")
            ]
        ]);

        return $response;
    }

    public function getIntakeIDData($request) {
        $intakeID = $request->IntakeId;
        $endpoint = "https://intakeq.com/api/v1/intakes/".$intakeID;
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', $endpoint, [
            'headers' => [
                'Accept'     => 'application/json',
                'x-auth-key'     => env("INTAKEQ_KEY")
            ]
        ]);

        return $response;
    }

    public function getAll(Request $request, $type) {
        $record = IntakeQ::query();
        $record->where("match_type", $type);
        $res =  $record->orderBy('created_at', 'desc')->paginate(10);
        return response()->json($res);
    }


}
