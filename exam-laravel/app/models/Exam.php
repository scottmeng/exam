<?php

class Exam extends Eloquent{

    protected $fillable = array('name', 'course_id', 'examstate_id','description','duration_in_min','full_marks','total_qn', 'start_time');

    public function courses(){
		return $this->belongsTo('Course');
    }

    public function states(){
    	return $this->belongsTo('ExamState');
    }

}
