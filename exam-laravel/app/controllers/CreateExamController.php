<?php
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CreateExamController extends BaseController {

	public function newExam()
	{
	 // protected $fillable = array('name', 'course_id', 'examstate_id','description','duration_in_min','full_marks','total_qn', 'start_time');

		$course_id = Input::get('course');
		$name = Input::get('title');

	 	$exam = new Exam(array('name'=>$name));
		$course = Course::where('nus_id','like',$course_id)->first();
		$exam = $course->exams()->save($exam);	

		App::error(function(ModelNotFoundException $e)
		{
		    return Response::make('Not Found', 404);
		});
	}

}
