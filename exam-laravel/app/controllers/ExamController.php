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
		$exam->grace_period = Input::get('grace_period');

		$exam->save();
		$questions = Input::get('questions');
		if(count($questions)>0){
			foreach($questions as $question){
				if (array_key_exists('id', $question)) {
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

	public function getRandomsubmission($exam_id){

		$exam = Exam::findOrFail($exam_id);

		$submissions = $exam->submissions()->where(function ($query) {
		    $query->where('submissionstate_id','=',SUBMITTED)
		          ->orWhere('submissionstate_id','=',GRADING);
		})->get();
				
		if($submissions->count()>0){
			$rand = rand(0, $submissions->count()-1);
			$next_submission = $submissions[$rand];

			return Response::success($next_submission);
		}else{
			return Response::error('no other submissions found');
		}
	}

	public function getQncount($exam_id)
	{	
		$exam = Exam::findOrFail($exam_id);
		$count = $exam->questions()->get()->count();
		$exam->totalqn = $count;
		$exam->save();
		return Response::success($count);
	}

	//get exam with status
	//no submission info is returned
	public function getExaminfo($exam_id)
	{
		//1.user role + exam status
		//error when not accessable
		$user = User::find(Session::get('userid'));
		if(!$user){
			return Response::error(401,'Please Login First!');
		}
		$exam = Exam::find($exam_id);

		$course_id = $exam->course->id;
		$course = $user->courses()->where('courses.id', '=', $course_id)->first();

		$status = $course->getExamStatus($exam);

		// stop user from receiving any information about this exam
		if ($status == 'unavailable') {
			return Response::error(401, 'You are unauthorized to view this page!');
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
		$exam->user_role = Role::find($course->pivot->role_id)->name;
		return Response::success($exam);
	}

	public function getExamsubmissions($exam_id){
		$user = User::find(Session::get('userid'));
		if(!$user){
			return Response::error(401,'Please Login First!');
		}
		$exam = Exam::find($exam_id);

		$course_id = $exam->course->id;
		$course = $user->courses()->where('courses.id', '=', $course_id)->first();

		$status = $course->getExamStatus($exam);

		// stop user from receiving any information about this exam
		if ($status == STATUS_UNAVAILABLE) {
			return Response::error(401, 'You are unauthorized to view this page!');
		}else if ($status == STATUS_DRAFT || $status == STATUS_NOT_STARTED){
			return Response::error(404,'The requested page is not available!');
		}else{
			if($course->isAdmin()){
				$exam = $exam->getAllSubmissions(true, false);
			}else{
				$exam = $exam->getSubmissions($user->id, true, false);
			}	
		}
		$exam->status = $status; 
		return Response::success($exam);
	}

	public function getMarkmcq($exam_id){
		$mcq_qns = Exam::findOrFail($exam_id)->questions()->where('questiontype_id','=',MCQ)->get();

		foreach($mcq_qns as $qn){
			$correctOption = $qn->options()->where('correctOption','=',1)->first()->id;
			$qn_submissions = $qn->submissions()->get();

			foreach($qn_submissions as $submission){
				$selected_option = $submission->choices()->first();
				// Log::info($selected_option);
				if($selected_option['option_id'] === $correctOption){
					$submission->marks_obtained = $qn->full_marks;
				}else{
					$submission->marks_obtained = 0;
				}
				$submission->comment = "system automatic grading";
				SubmissionState::find(GRADED)->questionsubmissions()->save($submission);
			}
		}
		
		return Response::success('marked');
	}

	public function getPublish($exam_id){
		$exam = Exam::findOrFail($exam_id);
		$exam->publish();

		return Response::success($exam);
	}

	public function getUnpublish($exam_id){
		$exam = Exam::findOrFail($exam_id);
		$exam->unpublish();

		return Response::success($exam);
	}

	public function getSubmission($exam_id){
		$exam = Exam::findOrFail($exam_id);
		$user = User::find(Session::get('userid'));
		if(!$user){
			return Response::error(401,'Please Login First!');
		}
		$exam_submission = ExamSubmission::whereRaw('user_id = ? and exam_id = ?', array($user->id,$exam_id))->first();	
		if(!$exam_submission){
			//create exam submission
			$exam_submission = $this->newSubmission($exam,$user);
		}else{
			$exam_submission = $exam_submission->getQnSubmissions();
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
		if(Input::has('options')){
			$question['options'] = $question->populateOptions(Input::get('options'));
		}
		return Response::success($question);
	}

	public function postDeletequestion($exam_id)
	{
		$qn_id = Input::get('id');

		$question = Question::find($qn_id);
		$question->deleteQuestion();

		return Response::success('deleted');
	}

	public function getGriddata($exam_id){

		$exam = Exam::find($exam_id);
		if(!$exam){
			Response::error('404','Exam Not Found');
		}

		$allSubmissionData = array();
		$gradedSubmissionData = array();
		$gradingSubmissionData = array();
		$notGradedSubmissionData = array();

		$submissions = $exam->submissions()->get();

		foreach($submissions as $submission){
			$submission_entry = array(
				"student"=> $submission->user->nus_id,
				"submission_id"=> $submission->id,
				"total_marks"=>$submission->total_marks,
				"status"=>$submission->status->description
			);
			for($index = 1; $index < $exam->totalqn + 1; $index++ ){
				// $column = "Qn " + $index;
				$marks = $submission->questionsubmissions()->whereIn('question_id',
					$exam->questions()->where('index','=',$index)->select('id')
					->get()->toArray())->select('marks_obtained')->first();
			    if(!$marks || !$marks->marks_obtained){
			    	$submission_entry[$index] = 0;
			    }else{
			    	$submission_entry[$index] = $marks->marks_obtained;
			    }
			}

			if($submission->status->id === GRADED){
                array_push($gradedSubmissionData, $submission_entry);
			}else if($submission->status->id === GRADING){
                array_push($gradingSubmissionData, $submission_entry);
			}else{
				array_push($notGradedSubmissionData, $submission_entry);
			}
            array_push($allSubmissionData, $submission_entry);
		}

		$gridData = array(
            	'all'=>$allSubmissionData,
            	'graded'=>$gradedSubmissionData,
            	'grading'=>$gradingSubmissionData,
            	'notGraded'=>$notGradedSubmissionData
        );

        return Response::success($gridData);
	}

	public function getGraphdata($exam_id){

		$exam = Exam::find($exam_id);
		if(!$exam){
			Response::error('404','Exam Not Found');
		}
		$graphLabels=array();
		$dataWrapper=array();
		$graphData=array();
		$lowest_mark = $exam->submissions()->min('total_marks');
		$highest_mark = $exam->submissions()->max('total_marks');

		$graph_step =ceil(floatval($highest_mark - $lowest_mark)/GRAPH_LEVEL);
		$starting_range = $exam->fullmarks-$graph_step*GRAPH_LEVEL;
		if($starting_range>0){
			array_push($graphLabels,'[0,'.$starting_range.')');
			array_push($graphData, ExamSubmission::whereRaw('total_marks >= ? and total_marks < ?',
											array(0,$starting_range))->count());	
		}else{$starting_range=0;}


		for($index=0; $index<GRAPH_LEVEL; $index++){
			if($starting_range+$graph_step<$highest_mark){
				array_push($graphLabels,'['.$starting_range.', '.($starting_range+$graph_step).')');
				array_push($graphData, ExamSubmission::whereRaw('total_marks >= ? and total_marks < ?',
										array($starting_range,$starting_range+$graph_step))->count());

			}else{
				array_push($graphLabels,'['.$starting_range.', '.$highest_mark.')');
				array_push($graphData, ExamSubmission::whereRaw('total_marks >= ? and total_marks < ?',
										array($starting_range,$highest_mark))->count());
				array_push($graphLabels,strval($highest_mark));	
				array_push($graphData, ExamSubmission::where('total_marks','=',$highest_mark)->count());
				break;			
			}
			$starting_range += $graph_step;
		}
		array_push($dataWrapper, $graphData);
		$graphStats = array(
			'graphLabels'=>$graphLabels,
			'graphData'=>$dataWrapper
		);

		return Response::success($graphStats);
	}

	private function retrieveQuestions($exam,$isEditing)
	{
		if($isEditing == False){
			$questions = $exam->questions()->get();
			foreach($questions as $question){
				$question['options']=$question->options()->select('id', 'content')->get();
				unset($question->marking_scheme);
				unset($question->suggested_answer);
				unset($question->general_feedback);
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

	private function newSubmission($exam,$user){
		$exam_submission = new ExamSubmission(array(
				'user_id' => $user->id
			));
		$exam->submissions()->save($exam_submission);
		$qnsubmissions = [];
		$questions = $exam->questions()->get();
		foreach($questions as $question){
			$question_submission = new questionSubmission(array(
				'examsubmission_id' => $exam_submission->id
			));	
			$question->submissions->save($question_submission);	
			array_push($qnsubmissions,$question_submission);
		}
		$exam_submission->questions = $qnsubmissions;
		return $exam_submission;
	}

}
