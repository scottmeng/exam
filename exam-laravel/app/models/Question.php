<?php

class Question extends Eloquent {

	protected $fillable = array('index','subindex','questiontype_id','title','content','exam');

	public function type()
    {
        return $this->belongsTo('Questiontype');
    }

    public function exam()
    {
    	return $this->belongsTo('Exam');
    }

    public function options()
    {
    	return $this->hasMany('Option');
    }

    public function submissions(){
        return $this->hasMany('QuestionSubmission');
    }

}
