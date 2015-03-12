<?php

class Exam extends Eloquent{

    protected $fillable = array('name', 'course_id', 'examstate_id','description','duration_in_min','full_marks','total_qn', 'start_time');

    public function course(){
		return $this->belongsTo('Course');
    }

    public function state(){
    	return $this->belongsTo('ExamState','examstate_id');
    }

    public function questions(){
    	return $this->hasMany('Question');
    }

    public function submissions(){
        return $this->hasMany('ExamSubmission');
    }

    public function publish(){
        if($this->state->id == DRAFT){
            $active_state = ExamState::find(ACTIVE);
            $active_state->exams()->save($this);
        }else if($this->state->id == ACTIVE){
            $published_state = ExamState::find(PUBLISHED);
            $published_state->exams()->save($this);
        }

        return $this;
    }

    public function unpublish(){
        if($this->state->id === ACTIVE){
            $draft_state = ExamState::find(DRAFT);
            $draft_state->exams()->save($this);
        }
        return $this;
    }

    public function getAllExamSubmissions(){
        $submissions = $this->submissions()->get();
        foreach($submissions as $exam_submission){
            $exam_submission = $exam_submission->getQnSubmissions();
        }
        $this->submissions = $submissions;
        return $this;
    }

    public function getExamSubmissions($grader_id){
        $grader = User::findOrFail($grader_id);
        $submissions = $this->submissions()->where('grader_id','=',$user->id)->get();
        if($submissions){
            foreach($submissions as $submission){
                $submission = $submission->getQnSubmissions();
            }
            $this->submissions = $submissions;
        }
        return $this;
    }
}
