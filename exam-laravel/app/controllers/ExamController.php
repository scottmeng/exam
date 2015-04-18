<?php

class ExamController extends BaseController {

	/******************* Admin Actions *******************/
	//edit exam
	public function putEditexam($exam_id)
	{
		$exam = Exam::find($exam_id);
		if(!$exam){
			Response::error('404','Exam Not Found');
		}
		if($this->isAdmin($exam)){
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
						$old_qn = Question::find($question['id']);
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
	}
	//delete exam and questions
	public function postDeletewithqn($exam_id)
	{
		$exam = Exam::find($exam_id);
		if(!$exam){
			Response::error('404','Exam Not Found');
		}
		if($this->isAdmin($exam)){
			$exam->deleteExamWithQns();
			return Response::success('deleted');
		}
	}
	//delete exam only
	public function postDelete($exam_id){
		Log::info('i was here');
		$exam = Exam::find($exam_id);
		if(!$exam){
			Response::error('404','Exam Not Found');
		}
		if($this->isAdmin($exam)){
			DB::statement('SET FOREIGN_KEY_CHECKS = 0');
			Exam::destroy($exam_id);
			DB::statement('SET FOREIGN_KEY_CHECKS = 1');
			return Response::success('deleted');
		}
	}
	//get available existing questions
	public function getAvailableqns($exam_id){
		$exam = Exam::find($exam_id);
		if(!$exam){
			Response::error('404','Exam Not Found');
		}		
		if($this->isAdmin($exam)){
			$questions = $exam->course->questions()
					->whereNotIn('questions.id',Question::whereHas('exams',function($query) use($exam_id) {
	    					$query->whereRaw('exams.id = ?',array($exam_id));
	    				})->select('questions.id')->get()->toArray())
					->get();
			foreach($questions as $question){
				if($question->type->id == MCQ || $question->type->id == MRQ){
					$question->options = $question->options()->get();
				}
			}
			return Response::success($questions);
		}
	}
	//add existing question
	public function postAddqn($exam_id){
		$exam = Exam::find($exam_id);
		if(!$exam){
			Response::error('404','Exam Not Found');
		}		
		if($this->isAdmin($exam)){
			$exam->addQuestion(Input::get('id'),Input::get('index'));
			return Response::success($question);
		}
	}
	//add list of existing questions
	public function postAddqns($exam_id){
		$exam = Exam::find($exam_id);
		if(!$exam){
			Response::error('404','Exam Not Found');
		}		
		if($this->isAdmin($exam)){
			$questions = Input::all();
			foreach($questions as $question){
				$exam->addQuestion($question['id'],$question['index']);
			}
			
			return Response::success($questions);
		}
	}
	//add new question
	public function postQuestion($exam_id)
	{
		$exam = Exam::find($exam_id);
		if(!$exam){
			Response::error('404','Exam Not Found');
		}		
		if($this->isAdmin($exam)){
			$qn_index = Input::get('index');
			$question = new Question(array(
				'questiontype_id' => Input::get('questiontype_id',0),
				'title' => Input::get('title',NULL),
				'content' => Input::get('content',NULL),
				'compiler_enable' => Input::get('compiler_enable',False),
				'marking_scheme' => Input::get('marking_scheme',NULL),
				'full_marks' => Input::get('full_marks',0),
			));

			$exam->course()->first()->questions()->save($question);
			$exam->addQuestion($question->id,$qn_index);
			if(Input::has('options')){
				$question['options'] = $question->populateOptions(Input::get('options'));
			}
			return Response::success($question);
		}
	}
	//update question
	public function putQuestion($exam_id)
	{
		$exam = Exam::find($exam_id);
		if(!$exam){
			Response::error('404','Exam Not Found');
		}		
		if($this->isAdmin($exam)){
			$question_id = Input::get('id');
			$question = Question::find($question_id);
			$new_index = Input::get('index');
			$updated = new Question();

			$updated->questiontype_id = Input::get('questiontype_id',-1);
			$updated->title = Input::get('title',NULL);
			$updated->content = Input::get('content',NULL);
			$updated->compiler_enable = Input::get('compiler_enable',False);
			$updated->marking_scheme = Input::get('marking_scheme',NULL);
			$updated->full_marks = Input::get('full_marks',0);
			if(Input::has('options')){
				$updated['options'] = Input::get('options');
			}
			$question = $question->updateQuestion($updated);

			$exam->addQuestion($question_id,$new_index);
			$exam->updateFullmarks();
			return Response::success($question);
		}
	}
	//delete question from db
	public function postDeletequestion($exam_id)
	{
		$exam = Exam::find($exam_id);
		if(!$exam){
			Response::error('404','Exam Not Found');
		}		
		if($this->isAdmin($exam)){
			$qn_id = Input::get('id');
			$question = Question::find($qn_id);
			$question->deleteQuestion();
			return Response::success('deleted');
		}
	}
	//remove linked question
	public function postRemovequestion($exam_id){
		$exam = Exam::find($exam_id);
		if(!$exam){
			Response::error('404','Exam Not Found');
		}		
		if($this->isAdmin($exam)){
			$qn_id = Input::get('id');
			$question = Question::find($qn_id);
			$exam = Exam::find($exam_id);
			$exam->questions()->detach($question);

			return Response::success('removed');
		}
	}
	//delete question option
	public function postDeleteoption($exam_id){
		$exam=Exam::find($exam_id);
		if(!$exam){
			Response::error('404','Exam Not Found');
		}		
		if($this->isAdmin($exam)){
			Option::destroy(Input::get('id'));
		}		
	}
	//publish exam
	public function getPublish($exam_id){
		$exam = Exam::find($exam_id);
		if(!$exam){
			Response::error('404','Exam Not Found');
		}
		if($this->isAdmin($exam)){
			$exam->publish();
			return Response::success($exam);			
		}
	}
	//unpublish exam
	public function getUnpublish($exam_id){
		$exam = Exam::find($exam_id);
		if(!$exam){
			Response::error('404','Exam Not Found');
		}
		if($this->isAdmin($exam)){
			$exam->unpublish();
			return Response::success($exam);
		}
	}
	//distribute paper for grading
	public function getDistributepaper($exam_id){
		$exam = Exam::find($exam_id);
		if(!$exam){
			Response::error('404','Exam Not Found');
		}
		if($this->isAdmin($exam)){
			$facilitators = $exam->course->users()->where('course_user.role_id','=',FACILITATOR)->get();
			$submissions = $exam->submissions()->get();

			$k = 0;
			for($i = 0; $i < $submissions->count(); $i++){
				$submissions[$i]->grader()->associate($facilitators[$k])->save();
				$k = ($k+1)%($facilitators->count());
			}

			return Response::success('distributed');
		}
	}
	/******************* End of Admin Actions *******************/



	/******************* Admin/TA Actions *******************/
	//get a paper for marking
	public function getRandomsubmission($exam_id){
		$exam = Exam::find($exam_id);
		if(!$exam){
			Response::error('404','Exam Not Found');
		}		
		if($this->isFacilitator($exam)){
			if($this->isAdmin($exam)){
				$submissions = $exam->submissions()->where(function ($query) {
				    $query->where('submissionstate_id','=',SUBMITTED)
				          ->orWhere('submissionstate_id','=',GRADING);
				})->get();
			}else{
				$submissions = $exam->submissions()->where('grader_id','=',$user['id'])->where(function ($query) {
				    $query->where('submissionstate_id','=',SUBMITTED)
				          ->orWhere('submissionstate_id','=',GRADING);
				})->get();
			}	
			if($submissions->count()>0){
				$rand = rand(0, $submissions->count()-1);
				$next_submission = $submissions[$rand];

				return Response::success($next_submission);
			}
		}
	}
	//get exam statistics
	public function getExamsubmissions($exam_id){
		$exam = Exam::find($exam_id);
		if(!$exam){
			Response::error('404','Exam Not Found');
		}
		if($this->isFacilitator($exam)){
			$exam->updateTotalQn();
			$exam->updateFullmarks();
			$status = $exam->getStatus(User::find(Session::get('userid')));
			// stop user from receiving any information if data is not ready
			if ($status == STATUS_UNAVAILABLE) {
				return Response::error(403, 'You are unauthorized to view this page!');
			}else if ($status == STATUS_DRAFT || $status == STATUS_NOT_STARTED){
				return Response::error(403,'The requested page is not available!');
			}else{
				if($this->isAdmin($exam)){
					$exam = $exam->getAllSubmissions(true, false);
				}else{
					$exam = $exam->getSubmissions($user->id, true, false);
				}	
			}
			$exam->status = $status; 
			return Response::success($exam);
		}
	}
	//ask system to mark MCQ questions
	public function getMarkmcq($exam_id){
		$exam = Exam::find($exam_id);
		if(!$exam){
			Response::error('404','Exam Not Found');
		}	
		if($this->isFacilitator($exam)){
			$mcq_qns = Exam::find($exam_id)->questions()->where('questiontype_id','=',MCQ)->get();
			foreach($mcq_qns as $qn){
				$correctOption = $qn->options()->where('correctOption','=',1)->first()->id;
				$qn_submissions = $qn->submissions()->get();
				foreach($qn_submissions as $submission){
					$selected_option = $submission->choices()->first();
					if($selected_option['option_id'] === $correctOption){
						$submission->marks_obtained = $qn->full_marks;
					}else{
						$submission->marks_obtained = 0;
					}
					$submission->comment = "system automatic grading";
					$submission->examsubmission->updateStatus();
					SubmissionState::find(GRADED)->questionsubmissions()->save($submission);
				}
			}
			return Response::success('marked');
		}
	}
	//get statistics - grid
	public function getGriddata($exam_id){
		$exam = Exam::find($exam_id);
		if(!$exam){
			Response::error('404','Exam Not Found');
		}
		if($this->isFacilitator($exam)){
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
					$column = "Qn " + $index;

					$marks = $submission->questionsubmissions()->whereIn('question_id',Question::whereHas('exams', 
							function($query) use($exam_id, $index){
								$query->whereRaw('exams.id = ? and exam_question.index = ?',array($exam_id,$index));
							})->select('questions.id')->get()->toArray())->select('marks_obtained')->first();

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
	}
	//get statistics - graph
	public function getGraphdata($exam_id){
		$exam = Exam::find($exam_id);
		if(!$exam){
			Response::error('404','Exam Not Found');
		}
		if($this->isFacilitator($exam)){
			$graphLabels=array();
			$dataWrapper=array();
			$graphData=array();

			$lowest_mark = $exam->submissions()->where('submissionstate_id','=',GRADED)->min('total_marks');
			$highest_mark = $exam->submissions()->where('submissionstate_id','=',GRADED)->max('total_marks');
			$graph_step =ceil(floatval($highest_mark - $lowest_mark)/GRAPH_LEVEL);
			$starting_range = $highest_mark-$graph_step*GRAPH_LEVEL;
			if($starting_range>0){
				array_push($graphLabels,'[0,'.$starting_range.')');
				array_push($graphData, $exam->submissions()->where('submissionstate_id','=',GRADED)->whereRaw('total_marks >= ? and total_marks < ?',
												array(0,$starting_range))->count());	
			}else{$starting_range=0;}

			if($graph_step!=0){
				for($index=0; $index<GRAPH_LEVEL; $index++){
					if($starting_range+$graph_step<$highest_mark){
						array_push($graphLabels,'['.$starting_range.', '.($starting_range+$graph_step).')');
						array_push($graphData, $exam->submissions()->where('submissionstate_id','=',GRADED)->whereRaw('total_marks >= ? and total_marks < ?',
												array($starting_range,$starting_range+$graph_step))->count());

					}else{
						array_push($graphLabels,'['.$starting_range.', '.$highest_mark.')');
						array_push($graphData, $exam->submissions()->where('submissionstate_id','=',GRADED)->whereRaw('total_marks >= ? and total_marks < ?',
												array($starting_range,$highest_mark))->count());
						array_push($graphLabels,strval($highest_mark));	
						array_push($graphData, $exam->submissions()->where('submissionstate_id','=',GRADED)->where('total_marks','=',$highest_mark)->count());
						break;			
					}
					$starting_range += $graph_step;
				}
			}else{
				array_push($graphLabels,strval($highest_mark));	
				array_push($graphData, ExamSubmission::where('submissionstate_id','=',GRADED)->where('total_marks','=',$highest_mark)->count());
			}
			array_push($dataWrapper, $graphData);
			$graphStats = array(
				'graphLabels'=>$graphLabels,
				'graphData'=>$dataWrapper
			);

			return Response::success($graphStats);
		}
	}
	/******************* End of Admin/TA Actions *******************/


	/******************* Common Actions *******************/
	//take exam - create/load exam submission
	public function getSubmission($exam_id){
		$exam = Exam::find($exam_id);
		if(!$exam){
			Response::error('404','Exam Not Found');
		}
		$user = User::find(Session::get('userid'));
		if(!$user){
			return Response::error(401,'Please Login First!');
		}
		$exam_submission = ExamSubmission::whereRaw('user_id = ? and exam_id = ?', array($user->id,$exam_id))->first();	
		if(!$exam_submission){
			$exam_submission = $this->newSubmission($exam,$user);
		}else{
			$exam_submission = $exam_submission->getQnSubmissions();
		}
		return Response::success($exam_submission);
	}
	//get and update total question count
	public function getQncount($exam_id)
	{	
		$exam = Exam::find($exam_id);
		if(!$exam){
			Response::error('404','Exam Not Found');
		}	
		$user = User::find(Session::get('userid'));
		if(!$user){
			return Response::error(401,'Please Login First!');
		}	
		$count = $exam->questions()->get()->count();
		$exam->totalqn = $count;
		$exam->save();
		return Response::success($count);
	}
	//get exam info
	public function getExaminfo($exam_id)
	{
		//1.user role + exam status
		//error when not accessable
		$exam = Exam::find($exam_id);
		if(!$exam){
			return Response::error(406,'Page Not Found!');
		}
		$status = $exam->getStatus(User::find(Session::get('userid')));
		if ($status == STATUS_UNAVAILABLE) {
			return Response::error(403, 'You are unauthorized to view this page!');
		}
		if(!$this->isFacilitator($exam) && $status == 'in_exam'){
			$exam->questions = $this->retrieveQuestions($exam,False);
		}else if($status != STATUS_UNAVAILABLE){
			$exam->questions = $this->retrieveQuestions($exam,True);
		}
		else{
			$exam->questions = null;
		}
		$exam->status = $status;
		$exam->fullmarks = $exam->questions->sum('full_marks');
		$exam->user_role = $this->checkRole($exam);
		return Response::success($exam);
	}
	/******************* End of Common Actions *******************/


	/******************* Helper Functions *******************/
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
		Log::info($questions);
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
			$question->submissions()->save($question_submission);	
			array_push($qnsubmissions,$question_submission);
		}
		$exam_submission->questions = $qnsubmissions;
		return $exam_submission;
	}
	private function isAdmin($exam){
		$user = User::find(Session::get('userid'));
		if(!$user){
			Response::error(401,'not log in');
			return false;
		}
		if(!$exam->isAdmin($user)){
			Response::error(403,'unauthorized');
			return false;
		}
		return true;	
	}
	private function isFacilitator($exam){
		$user = User::find(Session::get('userid'));
		if(!$user){
			Response::error(401,'not log in');
			return false;
		}
		if(!$exam->isFacilitator($user)){
			Response::error(403,'unauthorized');
			return false;
		}
		return true;		
	}
	private function checkRole($exam){
		$user = User::find(Session::get('userid'));
		if(!$user){
			Response::error(401,'not log in');
			return;
		}
		return Role::find($exam->checkRole($user))->name;
	}
}
