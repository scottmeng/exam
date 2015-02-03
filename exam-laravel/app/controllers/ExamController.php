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

			return Response::success($exam);
		}
		else{
		    return Response::error(200,'Exam already exists!');
		}

		App::error(function(ModelNotFoundException $e)
		{
		    return Response::error(404,'Course not found!');
		});
	}


	public function postQuestion($exam_id)
	{
		$question = Input::all();

		$index = $question->index;
		$subindex = $question->subindex;
		$question_type = $question->type;
		$title = $question->title;
		$content = htmlentities($question->content);
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

		return Response::success($question);
	}

	public function putQuestion($exam_id)
	{
		$question = Input::all();
	
		$id = $question->id;
		$index = $question->index;
		$subindex = $question->subindex;
		$question_type = $question->type;
		$title = $question->title;
		$content = htmlentities($question->content);
		$coding_qn = $question->coding_qn;
		$compiler_enable = $question->compiler_enable;
		$marking_scheme = $question->marking_scheme;
		$full_marks = $question->full_marks;

		$question = Question::findOrFail($id);
		$question->index = $index;
		$question->subindex = $subindex;
		$question->questiontype = $question_type;
		$question->title = $title;
		$question->content = $content;
		$question->coding_qn = $coding_qn;
		$question->compiler_enable = $compiler_enable;
		$question->marking_scheme = $marking_scheme;
		$question->full_marks = $full_marks;

		$question->save();

		return Response::success($question);
	}


	public function postDeletequestion($exam_id)
	{
		$qn_id = Input::get('id');

		$question = Question::find($qn_id);
		$question->delete(); 

		return Response::success($question);
	}

 

}
