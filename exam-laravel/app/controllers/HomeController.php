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

	public function newExamSubmission(){
		$exam_id = Input::get('exam_id');
		$exam = Exam::findOrFail($exam_id);

		$exam_submisson = new ExamSubmission(array(
			'user_id' => Input::get('user_id');
		));

		$exam->submissions()->save($exam_submisson);
		return Response::success($exam_submission);
	}

}
