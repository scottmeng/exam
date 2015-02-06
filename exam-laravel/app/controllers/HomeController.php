<?php
// use GuzzleHttp\Client;

class HomeController extends BaseController {

	public function getHome()
	{
		return View::make('home');
	}

	public function getCourses()
	{
		$id = Session::get('userid');
		$user = User::find($id);

		$courses = $user->courses()->get();

		foreach($courses as $course){
			$course->exams = $course->exams()->get();
		}

		return Response::make(array('courses'=>($courses)));
	}

	public function getQnTypes()
	{
		return Response::make(array('types'=>(QuestionType::all())));
	}

}
