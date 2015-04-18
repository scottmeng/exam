<?php
use GuzzleHttp\Client;
use \adLDAP;
require_once(realpath(__DIR__ . "/../vendor/adldap/adldap/lib/adLDAP/adLDAP.php"));
// require_once (dirname(dirname(__FILE__)) . "/vendor/adLDAP/adLDAP.php");


Route::get('/', 'LoginController@init');
Route::post('/login', 'LoginController@validateLogin');
Route::get('/logout', 'LoginController@logout');

//send default page back when 404
App::missing(function($exception) {
    return View::make('home');
});

Route::get('/api/profile', 'LoginController@getProfile');
Route::get('/api/get-courses','HomeController@getCourses');
Route::get('/api/get-admin-courses','HomeController@getAdminCourses');
Route::get('/api/get-qn-types','HomeController@getQnTypes');
Route::get('/api/logout', 'LoginController@logout');
Route::post('/api/test-code', 'HomeController@testCode');

Route::controller('/api/exam/{exam_id}','ExamController');
Route::controller('/api/submission/{submission_id}','SubmissionController');
Route::controller('api/course/{course_id}','CourseController');
Route::controller('api/question/{question_id}','QuestionController');



