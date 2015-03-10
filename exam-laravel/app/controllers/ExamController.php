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
		$questions = Input::get('questions');
		Log::info($questions);
		if(count($questions)>0){
			foreach($questions as $question){
				if (array_key_exists('id', $question)) {
					Log::info($question);
					$old_qn = Question::findOrFail($question['id']);
					$question = $old_qn->updateQuestion($question,$exam);
				}else{
					$new_qn = New Question();
					$question = $new_qn->updateQuestion($question,$exam);
				}	
			}
		}
		$exam->questions = $questions;
		return Response::success($exam);
	}

	public function getQncount($exam_id)
	{	
		$exam = Exam::findOrFail($exam_id);
		$count = $exam->questions()->get()->count();
		$exam->totalqn = $count;
		$exam->save();
		return Response::success($count);
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
		$course = $user->courses()->where('courses.id', '=', $course_id)->first();

		$status = $course->getExamStatus($exam);

		// stop user from receiving any information about this exam
		if ($status == 'unavailable') {
			return Response::error(401, 'unauthorized');
		}

		if($course->pivot->role_id != ADMIN && $course->pivot->role_id != FACILITATOR && $status == 'in_exam'){
			$exam->questions = $this->retrieveQuestions($exam,False);
		}
		else if($status != 'unavailable'){
			$exam->questions = $this->retrieveQuestions($exam,True);
		}
		else{
			$exam->questions = null;
		}
		$exam->status = $status;
		$exam->totalqn = $exam->questions()->get()->count();
		return Response::success($exam);
	}


	public function getSubmission($exam_id){
		$exam = Exam::findOrFail($exam_id);
		$user = User::find(Session::get('userid'));
		if(!$user){
			return Response::error(401,'unauthorized');
		}
		$exam_submission = ExamSubmission::whereRaw('user_id = ? and exam_id = ?', array($user->id,$exam_id))->first();	
		if(!$exam_submission){
			//create exam submission
			$exam_submission = new ExamSubmission(array(
				'user_id' => $user->id
			));
			$exam->submissions()->save($exam_submission);
			// //create corresponding question submissions
			// $questions = $exam->questions()->get();
			// foreach($questions as $question ){
			// 	$questionsubmission = new QuestionSubmission();
			// 	$questionsubmission->examsubmission_id = $exam_submission->id;
			// 	$question->submissions()->save($questionsubmission);
			// }
			$exam_submission->questions = [];
		}else{

			$exam_submission->questions = $exam_submission->questionsubmissions()->get();
		}
			
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
		if(Input::has('options')){
			$question['options'] = $question->populateOptions(Input::get('options'));
		}
		return Response::success($question);
	}

	public function putQuestion($exam_id)
	{
		$exam = Exam::findOrFail($exam_id);

		$question_id = Input::get('id');
		$question = Question::findOrFail($question_id);
		$updated = new Question();

		$updated->index = Input::get('index',-1);
		$updated->subindex = Input::get('subindex',-1);
		$updated->questiontype_id = Input::get('questiontype_id',-1);
		$updated->title = Input::get('title',NULL);
		$updated->content = Input::get('content',NULL);
		$updated->coding_qn = Input::get('coding_qn',False);
		$updated->compiler_enable = Input::get('compiler_enable',False);
		$updated->marking_scheme = Input::get('marking_scheme',NULL);
		$updated->full_marks = Input::get('full_marks',0);

		$question = $question->updateQuestion($updated,$exam);
		$question->options()->delete();
		if(Input::has('options')){
			$question['options'] = $question->populateOptions(Input::get('options'));
		}
		// $question['options'] = $this->populateOptions($question,Input::get('options'));
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

	// private function populateOptions($question, $inputOptions)
	// {
 //        foreach ($inputOptions as $option) {

 //        	Log::info($option);

	// 		$newOption = new Option(array(
	// 			'content' => $option['content'],
	// 			'correctOption' => $option['correctOption']
	// 		));

	// 		$question->options()->save($newOption);
	// 	}
	// 	$options = $question->options()->get();
	// 	return $options;
	// }

}
