<?php

class QuestionSubmission extends Eloquent{

    protected $fillable = array('answer', 'question_id', 'examsubmission_id', 'choice','marks_obtained','comment');

    public function question(){
		return $this->belongsTo('Question');
    }

    public function examsubmission(){
    	return $this->belongsTo('ExamSubmission','examsubmission_id');
    }

    public function option(){
    	return $this->belongsTo('Option','choice');
    }

}
