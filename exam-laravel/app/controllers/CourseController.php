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
			return Response::error(401,'Page not available!');
		}else{
			if($course->pivot->role_id == STUDENT){
				return Response::error(401,'You are unauthorized to view this page!');
			}
			else{
				$course = $course->getExamsWithSubmissions($user);
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
			return Response::error(401,'Page not available!');
		}else{
			if($course->pivot->role_id != ADMIN){
				return Response::error(401,'You are unauthorized to view this page!');
			}
			else{
				$course->description = Input::get('description');
				$course->save();
				return Response::success($course);
			}
		}
	}

}
