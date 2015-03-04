<?php

class ExamController extends BaseController {

	public function newExam()
	{
		$course_id = Input::get('course_id');
		$title = Input::get('title');

		$course = Course::find($course_id);
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

	public function putEditexam($exam_id)
	{
	 // protected $fillable = array('name', 'course_id', 'examstate_id','description','duration_in_min','full_marks','total_qn', 'start_time');

		$exam = Exam::find($exam_id);
		Log::info($exam);

		$exam->title = Input::get('title');
		$exam->description = Input::get('description');
		$exam->duration = Input::get('duration');
		$exam->fullmarks = Input::get('fullmarks');
		$exam->totalqn = Input::get('totalqn');
		$exam->starttime = Input::get('starttime');

		$exam->save();
		return Response::success($exam);
	}

	public function getExaminfo($exam_id)
	{
		$exam = Exam::find($exam_id);
		$exam['questions'] = $this->retrieveQuestions($exam);	
		return Response::success($exam);
	}

	public function postQuestion($exam_id)
	{
		$exam = Exam::find($exam_id);

		$question = new Question(array(
			'index'=>Input::get('index',-1),
			'subindex' => Input::get('subindex',-1),
			'questiontype_id' => Input::get('questiontype_id',-1),
			'title' => Input::get('title',NULL),
			'content' => Input::get('content',NULL),
			'coding_qn' => Input::get('coding_qn',False),
			'compiler_enable' => Input::get('compiler_enable',False),
			'marking_scheme' => Input::get('marking_scheme',NULL),
			'full_marks' => Input::get('full_marks',0)
		));

		$exam->questions()->save($question);
		$question['options'] = $this->populateOptions($question->id,Input::get('options'));
		return Response::success($question);
	}

	public function putQuestion($exam_id)
	{
		$id = Input::get('id');
		$question = Question::findOrFail($id);

		Log::info(Input::get('options'));

		$question->index = Input::get('index',-1);
		$question->subindex = Input::get('subindex',-1);
		$question->questiontype_id = Input::get('questiontype_id',-1);
		$question->title = Input::get('title',NULL);
		$question->content = Input::get('content',NULL);
		$question->coding_qn = Input::get('coding_qn',False);
		$question->compiler_enable = Input::get('compiler_enable',False);
		$question->marking_scheme = Input::get('marking_scheme',NULL);
		$question->full_marks = Input::get('full_marks',0);

		$question->save();
		$question->options()->delete();
		$question['options'] = $this->populateOptions($question->id,Input::get('options'));
		return Response::success($question);
	}

	public function postDeletequestion($exam_id)
	{
		$qn_id = Input::get('id');

		$question = Question::find($qn_id);
		$question->options()->delete();
		$question->delete(); 

		return Response::success($question);
	}

	private function retrieveQuestions($exam)
	{
		// $exam = Exam::find($exam_id);
		$questions = $exam->questions()->get();

		foreach($questions as $question){
			$question['options']=$question->options()->get();
		}

		Log::info('test');
		Log::info($questions);

		return $questions;
	}

	private function populateOptions($question_id, $inputOptions)
	{
		$question = Question::find($question_id);

        foreach ($inputOptions as $option) {

        	Log::info($option);

			$newOption = new Option(array(
				'content' => $option['content'],
				'correctOption' => $option['correctOption']
			));

			$question->options()->save($newOption);
		}
		$options = $question->options()->get();
		return $options;
	}

}
