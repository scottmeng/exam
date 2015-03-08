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

}
