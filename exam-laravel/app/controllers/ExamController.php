<?php

class ExamController extends BaseController {

	public function putEditexam($exam_id)
	{
		$exam = Exam::findOrFail($exam_id);

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
		//1.user role + exam status
		//error when not accessable
		$user = User::find(Session::get('userid'));
		if(!$user){
			return Response::error(401,'unauthorized');
		}
		$exam = Exam::find($exam_id);

		$course_id = $exam->course->id;
		$course = $user->courses()->whereRaw('courses.id = ?', array($course_id))->first();

		$access = $course->checkAccess();
		$status = $user->getExamStatus($exam,$course);

		if($access!= 'admin' && $access!='facilitator' && $status == 'in_exam'){
			$exam->questions = $this->retrieveQuestions($exam,False);
		}
		else if($status != 'unavailable'){
			$exam->questions = $this->retrieveQuestions($exam,True);
		}
		else{
			$exam->questions = null;
		}
		$exam->status = $status;
		return Response::success($exam);
	}


	public function getSubmission(){
		$exam_id = Input::get('exam_id');
		$exam = Exam::findOrFail($exam_id);

		$exam_submisson = new ExamSubmission(array(
			'user_id' => Input::get('user_id')
		));

		$exam->submissions()->save($exam_submisson);
		return Response::success($exam_submission);
	}

	public function postQuestion($exam_id)
	{
		$exam = Exam::findOrFail($exam_id);

		$question = new Question(array(
			'index'=>Input::get('index',-1),
			'subindex' => Input::get('subindex',0),
			'questiontype_id' => Input::get('questiontype_id',0),
			'title' => Input::get('title',NULL),
			'content' => Input::get('content',NULL),
			'coding_qn' => Input::get('coding_qn',False),
			'compiler_enable' => Input::get('compiler_enable',False),
			'marking_scheme' => Input::get('marking_scheme',NULL),
			'full_marks' => Input::get('full_marks',0)
		));

		$exam->questions()->save($question);
		$question['options'] = $this->populateOptions($question,Input::get('options'));
		return Response::success($question);
	}

	public function putQuestion($exam_id)
	{
		$question_id = Input::get('id');
		$question = Question::findOrFail($question_id);

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
		$question['options'] = $this->populateOptions($question,Input::get('options'));
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

	public function putPublish($exam_id)
	{
		$exam = Exam::findOrFail($exam_id);
		$publish_state = ExamState::whereRaw('name = ?',array('active'))->first();
		$publish_state->exams()->save($exam);

		return Response::success($exam);
	}

	public function putUnpublish($exam_id)
	{
		$exam = Exam::findOrFail($exam_id);
		$draft_state = ExamState::whereRaw('name = ?',array('draft'))->first();
		$draft_state->exams()->save($exam);

		return Response::success($exam);
	}

	private function retrieveQuestions($exam,$isEditing)
	{
		if($isEditing == False){
			$questions = $exam->questions()->get();
			foreach($questions as $question){
				$question['options']=$question->options()->select('id', 'content')->get();
				unset($question->marking_scheme);
			}
		}
		else{
			$questions = $exam->questions()->get();
			foreach($questions as $question){
				$question['options']=$question->options()->get();
			}
		}

		return $questions;
	}

	private function populateOptions($question, $inputOptions)
	{
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
