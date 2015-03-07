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
			$exams = $course->exams()->get();

			foreach($exams as $key => $exam){
				$status = $this->getExamStatus($exam, $course);
				if($status == 'unavailable'){
					unset($exams[$key]);
				}
				$exam->status = $status;
			}

			$course->user_role = $course->checkAccess();
			$course->exams = $exams;
		}
		return $courses;
	}

	public function getExamStatus($exam, $course){

		$access = $course->checkAccess();
		$status = 'unavailable';

		if($exam->checkState() == 'draft')
		{
			if(($access == 'admin')){
				$status = 'not_available';
			}
		}
		else if($exam->checkState() == 'active')
		{
			$now = Carbon::now();
			$starttime = new Carbon($exam->starttime);

			if($now->lt($starttime->subMinutes(15))){
				if($access != 'student'){
					$status = 'not_started';
				}
			}
			else if($now->gt($starttime->addMinutes($exam->duration))){	
				if($access != 'student'){
					$status = 'finished';
				}
			}	
			else{
				$status = 'in_exam';
			}
		}
		else if($exam->checkState() == 'published')
		{
			$status = 'published';
		}

		return $status;
	}

}	
