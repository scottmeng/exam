<?php

class QuestionSubmission extends Eloquent{

    protected $fillable = array('answer', 'question_id', 'examsubmission_id','submissionstate_id','marks_obtained','comment');
    protected $table="questionsubmissions";

    public function question(){
		return $this->belongsTo('Question');
    }

    public function examsubmission(){
    	return $this->belongsTo('ExamSubmission','examsubmission_id');
    }

    public function choices(){
        return $this->hasMany('SelectedOption');
    }

    public function status(){
        return $this->belongsTo('SubmissionState');
    }

}
