<?php

class SubmissionController extends BaseController {

	public function getExamsubmission($submission_id)
	{
		$submission = ExamSubmission::findOrFail($submission_id);
		$submission = $submission->getQnSubmissions();

		return Response::success($submission);
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
		else return Response::error(404,'question submission not found');
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
