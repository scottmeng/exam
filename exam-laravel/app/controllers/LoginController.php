<?php
use GuzzleHttp\Client;

class LoginController extends BaseController {

	public function init()
	{
		return View::make('home');
	}

 	public function validateLogin()
    {
	
	 	 if(Input::has('username'))
	    		$username = Input::get('username');

	 	 if(Input::has('password'))
	    		$password = Input::get('password');
	    	

		if ($username != NULL && $password != NULL){
				
			//ldap login


			//varify user role
			$user = User::where('nus_id','like',$username)->first();
			if(!$user){
				return Response::error(404,'user not found');
			}else{
				Session::put('userid',$user->id);
				return Response::success($user->name);
			}
		}
    }

	public function logout()
	{
		Session::flush();

		return Response::success('logout sucessful');
	}


}
