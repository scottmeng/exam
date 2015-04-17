<?php

class CourseController extends BaseController {

	//return course info, facilitators, exams(with access)
	public function getCourse($course_id)
	{
		$user = User::find(Session::get('userid'));
		if(!$user){
			return Response::error(401,'Please Login First!');
		}
		$course = $user->courses()->where('courses.id','=',$course_id)->first();
		if(!$course){
			return Response::error(403,'Page not available!');
		}else{
			if($course->pivot->role_id == STUDENT){
				return Response::error(403,'You are unauthorized to view this page!');
			}
			else{
				$course = $course->getExamsWithSubmissions($user);
				$course->questions = $course->questions()->get();
				if($course->pivot->role_id == ADMIN){
					foreach($course->exams as $exam){
						$exam = $exam->getGrader();
					}
				}
				$course->facilitators = $course->users()->where('course_user.role_id','=',FACILITATOR)->count();
				return Response::success($course);
			}
		}
	}

	public function putCourse($course_id){
		$user = User::find(Session::get('userid'));
		if(!$user){
			return Response::error(401,'Please Login First!');
		}
		$course = $user->courses()->where('courses.id','=',$course_id)->first();
		if(!$course){
			return Response::error(403,'Page not available!');
		}else{
			if($course->pivot->role_id != ADMIN){
				return Response::error(403,'You are unauthorized to view this page!');
			}
			else{
				$course->description = Input::get('description');
				$course->save();
				return Response::success($course);
			}
		}
	}

	public function postCreateqn($course_id)
	{
		$user = User::find(Session::get('userid'));
		if(!$user){
			return Response::error(401,'Please Login First!');
		}
		$course = $user->courses()->where('courses.id','=',$course_id)->first();
		
		if(!$course){
			return Response::error(403,'Page not available!');
		}else if($course->pivot->role_id != ADMIN){
			return Response::error(403,'You are unauthorized to view this page!');
		}else{
			$question = new Question(array(
				'questiontype_id' => Input::get('questiontype_id',0),
				'title' => Input::get('title',NULL),
				'content' => Input::get('content',NULL),
				'compiler_enable' => Input::get('compiler_enable',False),
				'marking_scheme' => Input::get('marking_scheme',NULL),
				'full_marks' => Input::get('full_marks',0),
			));			
			$course->questions()->save($question);
			if(Input::has('options')){
				$question['options'] = $question->populateOptions(Input::get('options'));
			}
			return Response::success($question);
		}
	}

	public function postDeleteqn($course_id)
	{
		$user = User::find(Session::get('userid'));
		if(!$user){
			return Response::error(401,'Please Login First!');
		}
		$course = $user->courses()->where('courses.id','=',$course_id)->first();
		if(!$course){
			return Response::error(403,'Page not available!');
		}else if($course->pivot->role_id != ADMIN){
			return Response::error(403,'You are unauthorized to view this page!');
		}else{
			$question=Question::find(Input::get('id'));
			$question->deleteQuestion();
			return Response::success('deleted');
		}
	}

}
