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
        return $this->belongsTo('SubmissionState','submissionstate_id');
    }

    public function getQnSubmissions(){
        $questions = $this->questionsubmissions()->get();
        $total_marks = 0;
        foreach($questions as $question_submission){
            if($question_submission->question->questiontype_id===MRQ){
                $question_submission = $question_submission->getChoices(True);
            }else if($question_submission->question->questiontype_id===MCQ){
                $question_submission = $question_submission->getChoices(False);
            }
            $total_marks += $question_submission->marks_obtained;
        }
        $this->questions = $questions;
        $this->total_marks = $total_marks;
        return $this;
    }

}
