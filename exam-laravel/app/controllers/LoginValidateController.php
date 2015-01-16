<?php
use GuzzleHttp\Client;

class LoginValidateController extends BaseController {

 	public function validateLogin($token)
    {
		$client = new Client(['base_url' => 'https://ivle.nus.edu.sg']);


		$name = $client->get('/api/Lapi.svc/UserName_Get', [
		    'query' => ['APIKey' => '6TfFzkSWBlHOT4ExcqFpY','Token' => $token]
		])->getBody();

		$id = $client->get('/api/Lapi.svc/UserID_Get',[
			'query' => ['APIKey' => '6TfFzkSWBlHOT4ExcqFpY','Token' => $token]
		])->getBody();

		$user_name = strtoupper(str_replace('"', "", $name));
		$user_id = strtoupper( str_replace('"', "", $id));


		$user = Student::firstOrCreate(array('name' => $user_name,'nus_id' => $user_id));
		
		Session::put('user_type','student');
		Session::put('user_id',$user->nus_id);
		
    }

}
