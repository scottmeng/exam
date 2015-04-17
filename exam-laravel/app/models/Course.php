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
			$visibletime = (new Carbon($exam->starttime,'GMT'))->subMinutes($exam->grace_period);

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
		$exams = $this->exams()->orderBy('updated_at','desc')->get();
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

	public function isFacilitator(){
		if ($this->pivot->role_id === ADMIN || $this->pivot->role_id === FACILITATOR){
			return true;
		}
		return false;		
	}

	public function getExamsWithSubmissions($user){
		$exams = $this->exams()->orderBy('updated_at','desc')->get();
		foreach($exams as $key => $exam){
			$status = $this->getExamStatus($exam);
			if ($status == STATUS_UNAVAILABLE){
				unset($exams[$key]);
			}else if($status == STATUS_FINISHED || $status == STATUS_PUBLISHED){
				if($this->isAdmin()){
					// $exam->submissions = $this->submissions()
					$exam = $exam->getAllSubmissions(false, false);
				}else{
					$exam = $exam->getSubmissions($user->id,false, false);
				}
			}else{
				$exam->questions = $exam->questions()->select('questions.id','title')->get();
			}
			$exam->status = $status; 
		}
		$this->user_role = Role::find($this->pivot->role_id)->name;
		$this->exams = $exams;
		return $this;
	}
}
