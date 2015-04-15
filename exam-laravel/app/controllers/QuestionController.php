<?php

class QuestionController extends BaseController {

	public function getEditinfo($question_id){
		$user = User::find(Session::get('userid'));
		if(!$user){
			return Response::error(401,'Please Login First!');
		}
		$question = Question::find($question_id);
		$course_id = $question->course->id;
		$course = $user->courses()->where('courses.id','=',$course_id)->first();
		if(!$course){
			return Response::error(403,'Page not available!');
		}else if($course->pivot->role_id != ADMIN){
			return Response::error(403,'You are unauthorized to view this page!');
		}
		if($question->type->id == MCQ || $question->type->id == MRQ){
			$question->options = $question->options()->get();
		}
		return Response::success($question);
	}

	public function postEdit($question_id)
	{
		$user = User::find(Session::get('userid'));
		if(!$user){
			return Response::error(401,'Please Login First!');
		}

		$question = Question::find($question_id);
		$course_id = $question->course->id;
		$course = $user->courses()->where('courses.id','=',$course_id)->first();
		if(!$course){
			return Response::error(403,'Page not available!');
		}else if($course->pivot->role_id != ADMIN){
			return Response::error(403,'You are unauthorized to view this page!');
		}else{
			$updated = new Question(array(
				'questiontype_id' => Input::get('questiontype_id',0),
				'title' => Input::get('title',NULL),
				'content' => Input::get('content',NULL),
				'compiler_enable' => Input::get('compiler_enable',False),
				'marking_scheme' => Input::get('marking_scheme',NULL),
				'full_marks' => Input::get('full_marks',0),
			));		
			if(Input::has('options')){
				$updated['options'] = Input::get('options');
			}
			$question = $question->updateQuestion($updated);

			return Response::success($question);
		}
	}

}
