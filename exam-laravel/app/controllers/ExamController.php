<?php

class ExamController extends BaseController {

	public function newExam()
	{
	 // protected $fillable = array('name', 'course_id', 'examstate_id','description','duration_in_min','full_marks','total_qn', 'start_time');

		$course_id = Input::get('course');
		$name = Input::get('title');

		// $exams = Exam::whereRaw('course_id = ? and name = ?',array($course_id,$name))->get();
		// $valid = $exams->isEmpty();


		// return $valid?'True':'False';

		// $course = Course::where('nus_id','like',$course_id)->firstorFail();
		$valid_exam = Exam::whereRaw('course_id = ? and name = ?',array($course_id,$name))->get()->isEmpty();

		if($valid_exam == True){

		 	$exam = new Exam(array('name'=>$name));
			$exam = $course->exams()->save($exam);

			return Response::success($exam);
		}
		else{
		    return Response::error(406,'Exam already exists!');
		}


	}

	public function putEditexam()
	{
	 // protected $fillable = array('name', 'course_id', 'examstate_id','description','duration_in_min','full_marks','total_qn', 'start_time');

		$id = Input::get('id');
		$exam = Exam::find($id);

		$exam->name = Input::get('title');
		$exam->course_id = Input::get('course');
		$exam->description = Input::get('description');
		$exam->duration_in_min = Input::get('duration');
		$exam->full_marks = Input::get('fullmarks');
		$exam->total_qn = Input::get('totalqn');
		$exam->start_time = Input::get('starttime');

		$exam->save();
		return Response::success($exam);
	}


	public function postQuestion($exam_id)
	{
		$question = Input::all();

		$question = new Question(array(
			'index'=>Input::get('index'),
			'subindex' => Input::get('subindex'),
			'questiontype' => Input::get('question_type'),
			'title' => Input::get('title'),
			'content' => Input::get('content'),
			'coding_qn' => Input::get('coding_qn'),
			'compiler_enable' => Input::get('compiler_enable'),
			'marking_scheme' => Input::get('marking_scheme'),
			'full_marks' => Input::get('full_marks'),
			'exam' => Input::get('exam_id')
		));

		$question->save();
		return Response::success($question);
	}

	public function putQuestion($exam_id)
	{
		$id = Input::get('id');
		$question = Question::findOrFail($id);

		$question->index = Input::get('index');
		$question->subindex = Input::get('subindex');
		$question->questiontype = Input::get('question_type');
		$question->title = Input::get('title');
		$question->content = Input::get('content');
		$question->coding_qn = Input::get('coding_qn');
		$question->compiler_enable = Input::get('compiler_enable');
		$question->marking_scheme = Input::get('marking_scheme');
		$question->full_marks = Input::get('full_marks');

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
