<?php

class QuestionSubmission extends Eloquent{

    protected $fillable = array('answer', 'question_id', 'examsubmission_id','submissionstate_id','marks_obtained','comment');
    protected $table="questionsubmissions";
    protected $touches = ['examsubmission'];

    public function question(){
		return $this->belongsTo('Question');
    }

    public function examsubmission(){
    	return $this->belongsTo('ExamSubmission','examsubmission_id');
    }

    public function choices(){
        return $this->hasMany('SelectedOption','qnsubmission_id');
    }

    public function status(){
        return $this->belongsTo('SubmissionState','submissionstate_id');
    }

    public function getChoices($isMRQ){
        if($isMRQ == True){
            $choices = [];
            $selected_options = $this->choices()->get();
                if($selected_options){
                foreach($selected_options as $option){
                    array_push($choices, $option->option_id);
                }
            }
            $this->choices = $choices;
        }else{
            $selected_option = $this->choices()->first();
            $this->choice = $selected_option == null? null : $selected_option->option_id;
        }
        return $this;
    }

}
