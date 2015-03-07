<?php

class SubmissionController extends BaseController {

	public function postQuestionsubmission($question_id)
	{
		$question = Question::findOrFail($question_id);

		$question_submission = new QuestionSubmission(array(
			'answer' => Input::get('answer',NULL),
			'examsubmission_id' => Input::get('examsubmission_id',0),
			'choice' => Input::get('choice',False),
		));

		$question->submissions()->save($question_submission);
		return Response::success($question_submission);
	}

	public function putQuestionsubmission($question_id)
	{
		$id = Input::get('id');
		$question_submission = QuestionSubmission::findOrFail($id);
		
		$question_submission->answer = Input::get('answer',NULL);
		$question_submission->examsubmission_id = Input::get('examsubmission_id',0);
		$question_submission->choice == Input::get('choice',False);
		
		$question_submission->save();
		return Response::success($question_submission);
	}

}
