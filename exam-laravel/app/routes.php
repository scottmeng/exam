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

// send default page back when 404
App::missing(function($exception) {
    return View::make('home');
});
