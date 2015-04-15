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
	    	
	    Log::info('user login');

		if ($username != NULL && $password != NULL){
				
			//ldap login


			//varify user role
			$user = User::where('nus_id','like',$username)->first();
			Log::info($user);
			if(!$user){
				return Response::error(405,'user not found');
			}else{
				Session::put('userid',$user->id);
				return Response::success($user->name);
			}
		}
    }

    public function getProfile()
	{
		$user = User::find(Session::get('userid'));
		if(!$user){
			return Response::error(401, 'unauthorized');
		}
		return Response::success($user);
	}

	public function logout()
	{
		Session::flush();

		return Response::success('logout sucessful');
	}
}
