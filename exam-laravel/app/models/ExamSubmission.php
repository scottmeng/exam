<?php

class ExamSubmission extends Eloquent{

    protected $fillable = array('name', 'user_id', 'exam_id', 'grader_id','submissionstate_id','total_marks','comment');
    protected $table="examsubmissions";

    public function user(){
		return $this->belongsTo('User','user_id');
    }

    public function questionsubmissions(){
    	return $this->hasMany('QuestionSubmission','examsubmission_id');
    }

    public function grader(){
    	return $this->belongsTo('User','grader_id');
    }

    public function exam(){
        return $this->belongsTo('Exam');
    }

    public function status(){
        return $this->belongsTo('SubmissionState');
    }

    public function getQnSubmissions(){
        $questions = $this->questionsubmissions()->get();
        foreach($questions as $question){
            if($question->question()->first()->questiontype_id===MRQ){
                $question = $question->getChoices(True);
            }else if($question->question()->first()->questiontype_id===MCQ){
                $question = $question->getChoices(False);
            }
        }
        $this->questions = $questions;
        return $this;
    }

}
