<?php
use Carbon\Carbon;

class Course extends Eloquent {

	protected $fillable = array('nus_id','name','description');


    public function exams()
    {
        return $this->hasMany('Exam');
    }

    public function questions(){
    	return $this->hasMany('Question');
    }

    public function users()
    {
        return $this->belongsToMany('User')->withPivot('role_id');
    }
	public function getExams($user){
		$exams = $this->exams()->orderBy('updated_at','desc')->get();
		foreach($exams as $key => $exam){
			$exam->updateTotalQn();
			$exam->updateFullmarks();
			$status = $exam->getStatus($user);
			if ($status == STATUS_UNAVAILABLE){
				unset($exams[$key]);
			}
			$exam->status = $status; 
		}
		$this->user_role = Role::find($this->pivot->role_id)->name;
		$this->exams = $exams;
		return $this;
	}
	public function getExamsWithSubmissions($user){
		$exams = $this->exams()->orderBy('updated_at','desc')->get();
		foreach($exams as $key => $exam){
			$exam->updateTotalQn();
			$exam->updateFullmarks();
			$status = $exam->getStatus($user);
			if ($status == STATUS_UNAVAILABLE){
				unset($exams[$key]);
			}else if($status == STATUS_FINISHED || $status == STATUS_PUBLISHED){
				if($this->checkRole($user)===ADMIN){
					$exam = $exam->getAllSubmissions(false, false);
				}else{
					$exam = $exam->getSubmissions($user->id,false, false);
				}
			}else{
				$exam->questions = $exam->questions()->select('questions.id','title')->get();
			}
			$exam->status = $status; 
		}
		$this->exams = $exams;
		return $this;
	}

	public function isAdmin(){
		if ($this->pivot->role_id === ADMIN){
			return true;
		}
		return false;
	}

	public function isFacilitator(){
		if ($this->pivot->role_id === ADMIN || $this->pivot->role_id === FACILITATOR){
			return true;
		}
		return false;		
	}

	public function checkRole($user){
		$course = $user->courses()->where('course_id','=',$this->id)->first();
		if(!$course){
			return UNKNOWN;
		}else{
			return $course->pivot->role_id;
		}
	}
}
