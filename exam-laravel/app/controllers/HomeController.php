<?php

class HomeController extends BaseController {

	public function getCourses()
	{
		return Course::whereHas('students', function($q)
		{
			//select all courses taken by user
			$id = Session::get('user_id');
		    $q->where('nus_id', 'like', $id);

		})->get();
	}

	public function getHome()
	{
		return View::make('home');
	}

}
