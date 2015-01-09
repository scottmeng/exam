<?php

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
	return View::make('home');
});

Route::get('/test', function() {

	//DB::insert('insert into Users (Name,Description) values (?,?)',array('testInsert','Description'));
	//$result = User::find(1);
	//$count = User::where('id', '<', 100)->count();
	//$user = User::firstOrCreate(array('name' => 'Lingyi','description' => 'test user'));
	$user = Student::has('courses', '>=', 0)->get();
	//$user = Course::all()->get();
	return $user;
});







