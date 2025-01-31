<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Session;
use Config;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
	
	public function _sendSMS($mobile, $sms,$templateID=null){
		ini_set('memory_limit', '-1');
		ini_set('max_execution_time', '0'); 
		// echo Configure::read("Message.application_sendsms");die;
		// if(Configure::read("Message.application_sendsms") == 1){
		// $mobile = 8946919241;
		if($mobile == "" || $sms == ""){
			return false;
		}
		$curl = curl_init();
		$client_id = 'e6bc53b8-14c4-4501-b8f7-1abd83faf77e';
		$CURLOPT_POSTFIELDS = array();
		$CURLOPT_POSTFIELDS['UniqueID'] = 'HGHTCH_EDU_SMS';
		$CURLOPT_POSTFIELDS['username'] = 'HighEduSms';
		$CURLOPT_POSTFIELDS['password'] = 'Ed#MsmDt_0o1';
		$CURLOPT_POSTFIELDS['serviceName'] = 'eSanchar Send SMS Request';
		$CURLOPT_POSTFIELDS['language'] = 'HIN';
		$CURLOPT_POSTFIELDS['message'] = $sms;
		$CURLOPT_POSTFIELDS['mobileNo'] = array();
		$CURLOPT_POSTFIELDS['mobileNo'][] = $mobile;
		if($templateID != ""){
			$CURLOPT_POSTFIELDS['templateID'] = $templateID;
		}
		//echo json_encode($CURLOPT_POSTFIELDS); exit;
		curl_setopt_array($curl, array(
			// CURLOPT_URL => "https://api.sewadwaar.rajasthan.gov.in/app/live/eSanchar/Prod/Service/api/OBD/CreateSMS/Request?client_id=$client_id",
			CURLOPT_URL => "https://api.sewadwaar.rajasthan.gov.in/app/live/eSanchar/Prod/Service/api/OBD/CreateOTP/Request?client_id=$client_id",
			//CURLOPT_URL => "https://api.sewadwaar.rajasthan.gov.in/app/live/eSanchar/Prod/",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => json_encode($CURLOPT_POSTFIELDS),
			CURLOPT_HTTPHEADER => array(
				"accept: application/json",
				"content-type: application/json",
				"username: HighEduSms",
				"password: Ed#MsmDt_0o1"
			),
		));
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		$response = curl_exec($curl);
		
		$err = curl_error($curl); 

		curl_close($curl);
		
		if ($err) {
			// "cURL Error #:" . $err;
		} else {
			// $response;
		}
		// }
		return true;

	}
	
	public function _checkIsValidSql($query=null){
		$status = false;
		$errors = null;
		if(!empty($query)){
			// Get connection object and set the charset
			$host = env('DB_HOST'); 
			$user = env('DB_USERNAME');
			$pass = env('DB_PASSWORD');
			$name = env('DB_DATABASE');
			$conn = mysqli_connect( $host, $user, $pass, $name);

			$result = mysqli_query($conn, $query);
			if (isset($result) && !empty($result)) {
				
			}else{
				$status = false;
				$errors = mysqli_error($conn);
			}
			
		}
		$response = array("status" => $status,'errors' => $errors);
	    return $response;
	}


	public function master($masterName){
		$master = array(); 
		$finalarray = array();
		$master['active']=['1'=>'Active','2'=>"InAcitve"]; 
		$master['role']=['admin'=>'Admin','employee'=>"Employee"]; 
		if(@$masterName){
			if(in_array($masterName,array_keys($master))){
			$finalarray = $master[@$masterName];
			}
		}
		return $finalarray;
	}
}
