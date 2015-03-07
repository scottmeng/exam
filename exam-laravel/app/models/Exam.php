<?php

class Exam extends Eloquent{

    protected $fillable = array('name', 'course_id', 'examstate_id','description','duration_in_min','full_marks','total_qn', 'start_time');

    public function course(){
		return $this->belongsTo('Course');
    }

    public function state(){
    	return $this->belongsTo('ExamState');
    }

    public function questions(){
    	return $this->hasMany('Question');
    }

    public function submissions(){
        return $this->hasMany('ExamSubmission');
    }

    public function checkState(){

        $draft_state = ExamState::where('name','like','draft')->first()->id;
        $active_state = ExamState::where('name','like','active')->first()->id;
        $published_state = ExamState::where('name','like','published')->first()->id;

        if($this->examstate_id == $draft_state){
            return 'draft';
        }
        else if($this->examstate_id == $active_state){
            return 'active';
        }
        else if($this->examstate_id == $published_state){
            return 'published';
        }

        return 'undefined';
    }

}
