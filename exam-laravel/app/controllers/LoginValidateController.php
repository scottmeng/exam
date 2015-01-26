<?php
use GuzzleHttp\Client;

class LoginValidateController extends BaseController {

 	public function validateLogin()
    {

	   if(Input::has('token'))
    		$token = Input::get('token');

	    $encryptToken = Crypt::encrypt($token);
	    Session::put('token', $encryptToken);

    	// $token = Crypt::decrypt(Session::get('token'));

		$client = new Client(['base_url' => 'https://ivle.nus.edu.sg']);

		$message = json_decode(($client->get('/api/Lapi.svc/Validate', [
	    'query' => ['APIKey' => '6TfFzkSWBlHOT4ExcqFpY','Token' => $token]
		])->getbody()),true);
		
		if ($message['Success']){

			$user = json_decode(($client->get('/api/Lapi.svc/Profile_View', [
			    'query' => ['APIKey' => '6TfFzkSWBlHOT4ExcqFpY','AuthToken' => $token]
			])->getBody()),true);

			$user_name = $user['Results'][0]['Name'];
			$user_id = $user['Results'][0]['UserID'];
			$user_name = strtoupper(str_replace('"', "", $user_name));
			$user_id = strtoupper( str_replace('"', "", $user_id));

			//$user = Student::firstOrCreate(array('name' => $user_name,'nus_id' => $user_id));
			
			//Session::put('user_type','student');
			Session::put('user_id',$user_id);
			Session::put('status','login successful');

			return Redirect::to('/#/home');

		}
		else{
			echo 'invalid login token';
		}
    }

}
