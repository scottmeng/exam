<?php

class SubmissionController extends BaseController {

	public function postQuestionsubmission($submission_id)
	{
		$question = Question::findOrFail(Input::get('question_id'));

		$question_submission = new QuestionSubmission(array(
			'answer' => Input::get('answer',NULL),
			'examsubmission_id' => $submission_id,
		));

		$question->submissions()->save($question_submission);
		return Response::success($question_submission);
	}

	public function putQuestionsubmission($submission_id)
	{
		$id = Input::get('id');
		$question_submission = QuestionSubmission::findOrFail($id);
		
		$question_submission->answer = Input::get('answer',NULL);
		// $question_submission->examsubmission_id = Input::get('examsubmission_id',0);
		
		$question_submission->save();
		return Response::success($question_submission);
	}

}
