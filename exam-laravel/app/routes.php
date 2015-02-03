<?php
use GuzzleHttp\Client;
use adldap\adLDAP;
require_once (dirname(__FILE__) . "/../vendor/adldap/adLDAP/lib/adLDAP/adLDAP.php");


Route::get('/', 'LoginValidateController@init');

Route::post('/login', 'LoginValidateController@validateLogin');
// {
// 	// return Redirect::to('https://ivle.nus.edu.sg/api/login/?apikey=6TfFzkSWBlHOT4ExcqFpY&url=http://localhost:8000/test');

// 	return Redirect::to('https://ivle.nus.edu.sg/api/login/?apikey=6TfFzkSWBlHOT4ExcqFpY&url=http://localhost:8000/validate');
// });

Route::get('/get-courses','HomeController@getCourses');
Route::get('/get-qn-types','HomeController@getQnTypes');

Route::get('/home', 'HomeController@getHome'); 
Route::get('create-exam','HomeController@getHome');

Route::post('/create-exam','ExamController@newExam');

Route::controller('/exam/{exam_id}','ExamController');















Route::get('/test', function() {

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

 // 	 if(Input::has('username'))
 //    		$username = Input::get('username');

 // 	 if(Input::has('password'))
 //    		$password = Input::get('password');
    	

	// if ($username != NULL && $password != NULL){
	// 	//include the class and create a connection
 //        try {
	// 	    $adldap = new adLDAP(array(
	// 	    	'account_suffix'=>'nus.edu.sg',
	// 	    	'domain_controllers'=>array('ldapstf.nus.edu.sg'),
	// 	    	'use_ssl'=>false
	// 	    ));
	// 	   // $adldap->connect();
	// 	    echo "Username '{$username}' login failed: ".$adldap->getLastError();

 //        }
 //        catch (adLDAPException $e) {
 //            echo $e; 
 //            exit();   
 //        }
		
	// 	//authenticate the user
 //        echo("\r\nserver: nus.edu.sg:");
	// 	var_dump($username,$password);

	// 	$result = $adldap->authenticate($username, $password);
	// 	var_dump($result);
	// 	echo("\r\n");

	// 	if ($result == False){
	//         try {
	// 		    $adldap = new adLDAP(array(
	// 		    	'account_suffix'=>'u.nus.edu',
	// 		    	'domain_controllers'=>array('ldapstf.nus.edu.sg'),
	// 		    	'use_ssl'=>false
	// 		    ));
	// 		    $adldap->connect();
	// 		    echo "Username '{$username}' login failed: ".$adldap->getLastError();

	//         }
	//         catch (adLDAPException $e) {
	//             echo $e; 
	//             exit();   
	//         }
	//         echo('server:u.nus.edu:');
	// 		var_dump($username,$password);

	// 		$result = $adldap->authenticate($username, $password);
	// 		var_dump($result);
	// 	}       
	// }
		$exam = Exam::whereRaw('course_id = ? and name = ?',array(1,'test'))->get();

		if($exam->isEmpty())
			return 'success';
		else
			return 'fail';




});







