<?php

class CourseController extends BaseController {

	//return course info, facilitators, exams(with access)
	public function getCourse($course_id)
	{
		$course = Course::findOrFail($course_id);
		$course = $course->getExams();
		
		return Response::success($course);
	}

}
