<?php

class ExamController extends BaseController {

	public function newExam()
	{
	 // protected $fillable = array('name', 'course_id', 'examstate_id','description','duration_in_min','full_marks','total_qn', 'start_time');

		$course_id = Input::get('course');
		$name = Input::get('title');

		$course = Course::where('nus_id','like',$course_id)->firstorFail();
		$valid_exam = Exam::whereRaw('course_id = ? and name = ?',array($course_id,$name))->get()->isEmpty();

		if($valid_exam == True){
		 	$exam = new Exam(array('name'=>$name));
			$exam = $course->exams()->save($exam);	
			return 'success';
		}
		else{
			return 'fail';
		}

		App::error(function(ModelNotFoundException $e)
		{
		    return Response::make('Not Found', 404);
		});
	}

	public function postAddquestions($exam_id)
	{
		$questions = Input::all();
		foreach ($questions as $question)
		{
			$index = $question->index;
			$subindex = $question->subindex;
			$question_type = $question->type;
			$title = $question->title;
			$content = $question->content;
			$coding_qn = $question->coding_qn;
			$compiler_enable = $question->compiler_enable;
			$marking_scheme = $question->marking_scheme;
			$full_marks = $question->full_marks;

			$question = new Question(array(
				'index'=>$index,
				'subindex' => $subindex,
				'questiontype' => $question_type,
				'title' => $title,
				'content' => $content,
				'coding_qn' => $coding_qn,
				'compiler_enable' => $compiler_enable,
				'marking_scheme' => $marking_scheme,
				'full_marks' => $full_marks,
				'exam' => $exam_id
			));
			$question->save();
		}

		return $questions;
	}

	public function getNewquestion($exam_id)
	{
		return $exam_id;
	}

 

}
