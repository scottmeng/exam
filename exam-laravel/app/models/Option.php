<?php

class Option extends Eloquent {

	protected $fillable = array('index','content','question_id','correctOption');

    public function question()
    {
        return $this->belongsTo('Question');
    }

    public function selections(){
    	return $this->hasMany('QuestionSubmission','choice');
    }

}
