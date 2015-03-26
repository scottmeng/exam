<?php

class SubmissionController extends BaseController {

	public function getExamsubmission($submission_id)
	{
		$submission = ExamSubmission::findOrFail($submission_id);
		$submission = $submission->getQnSubmissions();
		$submission->student = $submission->user->nus_id;
		return Response::success($submission);
	}

	public function getFinish($submission_id){
		$exam_submission = ExamSubmission::find($submission_id);
		$grading = SubmissionState::where('name','like','graded')->first();
		$grading->examsubmissions()->save($exam_submission);
		return Response::success($exam_submission);
	}

	public function getNextsubmission($submission_id){
		$exam = ExamSubmission::findOrFail($submission_id)->exam()->first();
		$submissions = $exam->submissions()->where(function ($query) {
		    $query->where('submissionstate_id','=',SUBMITTED)
		          ->orWhere('submissionstate_id','=',GRADING);
		})->whereNotIn( 'id', [$submission_id])->get();

		if($submissions->count()>0){
			$rand = rand(0, $submissions->count()-1);
			$next_submission = $submissions[$rand];

			return Response::success($next_submission);
		}else{
			return Response::error('no other submissions found');
		}
	}

	public function postStartqnmarking($submission_id){
		if(Input::has('id')){
			$question_submission = QuestionSubmission::find(Input::get('id'));
			$grading = SubmissionState::where('name','like','grading')->first();
			$grading->questionsubmissions()->save($question_submission);
			return Response::success($question_submission);
		}
		else{
		 return Response::error(404,'question submission not found');
		}
	}

	public function getStartgrading($submission_id){
		$exam_submission = ExamSubmission::find($submission_id);
		$grading = SubmissionState::where('name','like','grading')->first();
		$grading->examsubmissions()->save($exam_submission);
		return Response::success($exam_submission);
	}

	public function putQnmarking($submssion_id){
		if(Input::has('id')){
			$graded_status = SubmissionState::where('name','like','graded')->first();

			$question_submission = QuestionSubmission::find(Input::get('id'));
			$question_submission->marks_obtained = Input::get('marks_obtained');
			$question_submission->comment = Input::get('comment');

			$graded_status->questionsubmissions()->save($question_submission);

			return Response::success($question_submission);
		}
		else{
		 return Response::error(404,'question submission not found');
		}
	}

	public function postQuestionsubmission($submission_id)
	{
		$question = Question::findOrFail(Input::get('question_id'));

		$question_submission = new QuestionSubmission(array(
			'answer' => Input::get('answer',NULL),
			'examsubmission_id' => $submission_id,
		));

		$question->submissions()->save($question_submission);

		if(Input::has('choices')){//if is MRQ
			$choices = Input::get('choices');
			foreach($choices as $choice){
				$selected_option = new SelectedOption(array(
					'option_id' => $choice,
				));
				$question_submission->choices()->save($selected_option);
			}
			$question_submission->choices = $choices;
		}else if(Input::has('choice')){//if is MCQ
			$selected_option = new SelectedOption(array(
				'option_id' => intval(Input::get('choice')),
			));
			$question_submission->choices()->save($selected_option);
			$question_submission->choice = intval(Input::get('choice'));
		}
		return Response::success($question_submission);
	}

	public function putQuestionsubmission($submission_id)
	{
		$id = Input::get('id');
		$question_submission = QuestionSubmission::findOrFail($id);

		$question_submission->answer = Input::get('answer',NULL);		
		$question_submission->save();
		$question_submission->choices()->delete();

		if(Input::has('choices')){//if is MRQ
			$choices = Input::get('choices');
			foreach($choices as $choice){
				$selected_option = new SelectedOption(array(
					'option_id' => $choice,
				));
				$question_submission->choices()->save($selected_option);
			}
			$question_submission->choices = $choices;
		}else if(Input::has('choice')){//if is MCQ
			$selected_option = new SelectedOption(array(
				'option_id' => intval(Input::get('choice')),
			));
			$question_submission->choices()->save($selected_option);
			$question_submission->choice = intval(Input::get('choice'));
		}			
		return Response::success($question_submission);
	}

}
