<?php
use GuzzleHttp\Client;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

//protecting routes
/*
Route::get('profile', array('before' => 'auth', function()
{
    // Only authenticated users may enter...
}));
*/

Route::get('/', function()
{
	return Redirect::to('https://ivle.nus.edu.sg/api/login/?apikey=6TfFzkSWBlHOT4ExcqFpY&url=http://localhost:8000/validate');
});


Route::get('/validate',function()
{
    if(Input::has('token'))
        $token = Input::get('token');

	App::make('LoginValidateController')->validateLogin($token);

	return Redirect::to('/home');
});

Route::get('/get-courses','HomeController@getCourses');
// {

// 	$courses = Course::whereHas('students', function($q)
// 	{
// 		//select all courses taken by user
// 		$id = Session::get('user_id');
// 	    $q->where('nus_id', 'like', $id);

// 	})->get();

// 	return $courses;

// });

Route::get('/home', 'HomeController@getHome'); 
// {
// 	return View::make('home');
// });



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

	return $response->getBody();
});







