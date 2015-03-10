<?php

class SelectedOption extends Eloquent {

	protected $fillable = array('option_id','qnsubmission_id');
	protected $table="selected_options";

    public function submission()
    {
        return $this->belongsTo('QuestionSubmission');
    }

    public function option(){
    	return $this->belongsTo('Option');
    }

}
