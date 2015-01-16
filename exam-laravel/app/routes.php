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

Route::get('/user', function()
{
  if(Input::has('id'))
        $token = Input::get('id');

	return $token;
});


Route::get('/test2',function()
{
    if(Input::has('token'))
        $token = Input::get('token');
	return $token;
});

Route::get('/validate',function()
{
    if(Input::has('token'))
        $token = Input::get('token');

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
	
	return Redirect::to('/home');
});


Route::get('/get-courses',function()
{

	$courses = Course::whereHas('students', function($q)
	{
		//select all courses taken by user
		$id = Session::get('user_id');
	    $q->where('nus_id', 'like', $id);

	})->get();

	return $courses;

});



Route::get('/home', function() {
	return View::make('home');
});



Route::get('/test', function() {

	$client = new Client();
	$response = $client->get('https://ivle.nus.edu.sg/api/Lapi.svc/UserName_Get?APIKey=6TfFzkSWBlHOT4ExcqFpY&Token=C7768A0DBD4066693EFB2F389E5817B9BCF3D931E45FC560AB17018866540F63A1C24676DD1D6B3EC14D43B8BA6A77A207C693517501567E0CFB8C7FF4AFA14AD2194078815E215ABE2A5E84B7E754240A10BDAF0AB5D33E0740A0688B607CCFA5E8482B217DBB94CDA95639BAB16F271083EA4B585A30587A07DFC738426500BCB7614D35DC29433A329ED4CD554BFE2B5EB42840E30AAF0CFB91C8A6E4CA98A99839750A4B212A46EA59422E1137CC81DBB45AD911273320578730A083FF81EFBD9DA32638BF837B3148555CEE96E6&Duration=0&IncludeAllInfo=True');

	// $username = Input::get('username');
	// $password = Input::get('password');

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







