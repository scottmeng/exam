<?php

class Option extends Eloquent {

	protected $fillable = array('content','question_id','correctOption');
	protected $touches = ['question'];

    public function question()
    {
        return $this->belongsTo('Question');
    }

    public function selections(){
    	return $this->hasMany('SelectedOption');
    }

    public function deleteOption(){
    	$this->selections()->delete();
    	$this->delete();
    }

}
