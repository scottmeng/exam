<?php

class SubmissionState extends Eloquent{

    protected $fillable = array('name', 'description');
    protected $table = 'submissionstates';

    public function questionsubmissions(){
		return $this->hasMany('QuestionSubmission');
    }

    public function examsubmissions(){
		return $this->hasMany('ExamSubmission');
    }
}
