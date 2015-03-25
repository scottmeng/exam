<?php
use Carbon\Carbon;

class Course extends Eloquent {

	protected $fillable = array('nus_id','name','description');


    public function exams()
    {
        return $this->hasMany('Exam');
    }

    public function users()
    {
        return $this->belongsToMany('User')->withPivot('role_id');
    }

    public function groups(){
    	return $this->hasMany('Group');
    }

    public function getExamStatus($exam){

		$status = STATUS_UNAVAILABLE;

		if($exam->examstate_id == DRAFT)
		{
			if(($this->pivot->role_id == ADMIN)){
				$status = STATUS_DRAFT;
			}
		}
		else if($exam->examstate_id == ACTIVE)
		{
			$now = Carbon::now('Asia/Singapore');
			$starttime = new Carbon($exam->starttime,'GMT');
			$endtime = (new Carbon($exam->starttime,'GMT'))->addMinutes($exam->duration);
			$visibletime = (new Carbon($exam->starttime,'GMT'))->subMinutes(15);

			if($now->lt($visibletime)){
				if($this->pivot->role_id != STUDENT){
					$status = STATUS_NOT_STARTED;
				}
			}
			else if($now->gt($endtime)){	
				if($this->pivot->role_id != STUDENT){
					$status = STATUS_FINISHED;
				}else{
					$status = STATUS_UNAVAILABLE;
				}
			}	
			else{
				$status = STATUS_IN_EXAM;
			}
		}
		else if($exam->examstate_id == PUBLISHED)
		{
			$status = STATUS_PUBLISHED;
		}

		return $status;
	}


	public function getExams(){
		$exams = $this->exams()->get();
		foreach($exams as $key => $exam){
			$status = $this->getExamStatus($exam);
			if ($status == STATUS_UNAVAILABLE){
				unset($exams[$key]);
			}
			$exam->status = $status; 
		}
		$this->user_role = Role::find($this->pivot->role_id)->name;
		$this->exams = $exams;
		return $this;
	}

	public function isAdmin(){
		if ($this->pivot->role_id === ADMIN){
			return true;
		}
		return false;
	}

	public function getExamsWithSubmissions($user){
		$exams = $this->exams()->get();
		foreach($exams as $key => $exam){
			$status = $this->getExamStatus($exam);
			if ($status == STATUS_UNAVAILABLE){
				unset($exams[$key]);
			}else if($status == STATUS_FINISHED || $status == STATUS_PUBLISHED){
				if($this->isAdmin()){
					$exam = $exam->getAllExamSubmissions();
					$this->groups = $this->groups()->get();
				}else{
					$exam = $exam->getExamSubmissions($user->id);
				}
			}
			$exam->status = $status; 
		}
		$this->user_role = Role::find($this->pivot->role_id)->name;
		$this->exams = $exams;
		return $this;
	}
}
