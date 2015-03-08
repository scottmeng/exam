<?php
// use GuzzleHttp\Client;

class HomeController extends BaseController {

	public function getHome()
	{
		return View::make('home');
	}

	public function getCourses()
	{
		$user = User::find(Session::get('userid'));
		if(!$user){
			return Response::error(401,'unauthorized');
		}
		$courses = $user->getCourses();

		return Response::success($courses);
	}

	public function getAdminCourses()
	{
		$user = User::find(Session::get('userid'));
		if(!$user){
			return Response::error(401,'unauthorized');
		}
		$courses = $user->getAdminCourses();

		return Response::success($courses);
	}

	public function getQnTypes()
	{
		return Response::success(QuestionType::all());
	}

	public function newExam()
	{
		$course_id = Input::get('course_id');
		$title = Input::get('title');

		$course = Course::find($course_id);
		//check if exam with the same title under the same course already exists
		$valid_exam = Exam::whereRaw('course_id = ? and title = ?',array($course_id,$title))->get()->isEmpty();

		if($valid_exam == True){

		 	$exam = new Exam();
			$exam->title=$title;	
			$course->exams()->save($exam);

			return Response::success($exam);
		}
		else{
		    return Response::error(406,'Exam already exists!');
		}
	}

}
