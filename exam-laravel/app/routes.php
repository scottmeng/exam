<?php
use GuzzleHttp\Client;

Route::get('/', function()
{
	// return Redirect::to('https://ivle.nus.edu.sg/api/login/?apikey=6TfFzkSWBlHOT4ExcqFpY&url=http://localhost:8000/test');

	return Redirect::to('https://ivle.nus.edu.sg/api/login/?apikey=6TfFzkSWBlHOT4ExcqFpY&url=http://localhost:8000/validate');
});


Route::get('/validate','LoginValidateController@validateLogin');

Route::get('/get-courses','HomeController@getCourses');

Route::get('/get-modules','HomeController@getModules');

Route::get('/home', 'HomeController@getHome'); 

Route::post('/create-exam','CreateExamController@newExam');

















Route::get('/test', function() {

	// if (Auth::attempt(array('username' => $username, 'password' => $password)))
	// {
 //    	return 'log in success!';
	// }
	// return 'FAIL';

	// //DB::insert('insert into Users (Name,Description) values (?,?)',array('testInsert','Description'));
	// $courses = Course::find(1);
	// //$count = User::where('id', '<', 100)->count();
	// //$courses = User::firstOrCreate(array('name' => 'Lingyi','description' => 'test user'));
	// //$courses = Course::with('students','>',0)->get();
	// //$user = Course::all()->get();
	// //$test = DB::statement('select * from students;');
	// //$student = Student::where('name','=', 'Livia')->get();
	// echo $courses->students()->first()->name;

    $data = Session::get('test');

	return $data;
});







