<?php
use Carbon\Carbon;

class User extends Eloquent{

    protected $fillable = array('nus_id', 'name', 'comment');

    public function courses(){
    	return $this->belongsToMany('Course')->withPivot('role_id');
    }

    public function examsubmissions(){
    	return $this->hasMany('ExamSubmission', 'user_id', 'id');
	}

	public function getCourses(){
		
		$courses = $this->courses()->get();
		foreach($courses as $course){
			$course = $course->getExams();
		}
		return $courses;
	}

	public function getAdminCourses(){
		$courses = $this->courses()->whereRaw('course_user.role_id = ?',array(ADMIN))->get();
		foreach($courses as $key => $course){
			$course= $course->getExams();
		}
		return $courses;
	}

}	
