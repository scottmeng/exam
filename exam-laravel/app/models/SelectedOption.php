<?php

class Option extends Eloquent {

	protected $fillable = array('index','content','question_id','correctOption');

    public function submission()
    {
        return $this->belongsTo('QuestionSubmission');
    }

    public function option(){
    	return $this->belongsTo('Option');
    }

}
