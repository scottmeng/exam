<?php
use GuzzleHttp\Client;
use \adLDAP;
require_once(realpath(__DIR__ . "/../vendor/adldap/adldap/lib/adLDAP/adLDAP.php"));
// require_once (dirname(dirname(__FILE__)) . "/vendor/adLDAP/adLDAP.php");


Route::get('/', 'LoginController@init');
Route::post('/login', 'LoginController@validateLogin');

//send default page back when 404
App::missing(function($exception) {
    return View::make('home');
});

Route::get('/api/get-courses','HomeController@getCourses');
Route::get('/api/get-qn-types','HomeController@getQnTypes');
Route::get('/api/logout', 'LoginController@logout');

Route::post('/api/create-exam','HomeController@newExam');
Route::controller('/api/exam/{exam_id}','ExamController');
Route::controller('/api/submission/{submission_id}','SubmissionController');













Route::post('/test',


	function() {

	// if (Auth::attempt(array('username' => $username, 'password' => $password)))
	// {
 //    	return 'log in success!';
	// // }
	// // return 'FAIL';

	// // //DB::insert('insert into Users (Name,Description) values (?,?)',array('testInsert','Description'));
	// // $courses = Course::find(1);
	// // //$count = User::where('id', '<', 100)->count();
	// // //$courses = User::firstOrCreate(array('name' => 'Lingyi','description' => 'test user'));
	// // //$courses = Course::with('students','>',0)->get();
	// // //$user = Course::all()->get();
	// // //$test = DB::statement('select * from students;');
	// // //$student = Student::where('name','=', 'Livia')->get();
	// // echo $courses->students()->first()->name;

 	 if(Input::has('username'))
    		$username = Input::get('username');

 	 if(Input::has('password'))
    		$password = Input::get('password');
    	

	if ($username != NULL && $password != NULL){
		//include the class and create a connection
        try {
		    $adldap = new adLDAP(array(
		    	'account_suffix'=>'nus.edu.sg',
		    	'domain_controllers'=>array('ldapstf.nus.edu.sg'),
		    	'use_ssl'=>false
		    ));
		   // // $adldap->connect();
		   //  echo "Username '{$username}' login failed: ".$adldap->getLastError();

        }
        catch (adLDAPException $e) {
            echo $e; 
            exit();   
        }
		
		//authenticate the user
        echo("\r\nserver: nus.edu.sg:");
		var_dump($username,$password);

		$result = $adldap->authenticate($username, $password);
		var_dump($result);
		echo("\r\n");

		if ($result == False){
	        try {
			    $adldap = new adLDAP(array(
			    	'account_suffix'=>'u.nus.edu',
			    	'domain_controllers'=>array('ldapstf.nus.edu.sg'),
			    	'use_ssl'=>false
			    ));
			    // $adldap->connect();
			    // echo "Username '{$username}' login failed: ".$adldap->getLastError();

	        }
	        catch (adLDAPException $e) {
	            echo $e; 
	            exit();   
	        }
	        echo('server:u.nus.edu:');
			var_dump($username,$password);

			$result = $adldap->authenticate($username, $password);
			var_dump($result);
		}
	}
// 	return	Question::destroy(10);



});
