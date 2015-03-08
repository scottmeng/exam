<?php

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
			$now = Carbon::now();
			$starttime = new Carbon($exam->starttime);

			if($now->lt($starttime->subMinutes(15))){
				if($this->pivot->role_id != STUDENT){
					$status = STATUS_NOT_STARTED;
				}
			}
			else if($now->gt($starttime->addMinutes($exam->duration))){	
				if($this->pivot->role_id != STUDENT){
					$status = STATUS_FINISHED;
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
		$this->user_role = ROLE::find($this->pivot->role_id)->name;
		$this->exams = $exams;
		return $this;
	}

}
