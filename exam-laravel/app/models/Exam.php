<?php

class Exam extends Eloquent{

    protected $fillable = array('name', 'course_id', 'examstate_id','description','duration_in_min','full_marks','total_qn', 'start_time');

    public function course(){
		return $this->belongsTo('Course');
    }

    public function state(){
    	return $this->belongsTo('ExamState','examstate_id');
    }

    public function questions(){
    	return $this->hasMany('Question');
    }

    public function submissions(){
        return $this->hasMany('ExamSubmission');
    }

    public function publish(){
        if($this->state->id == DRAFT){
            $active_state = ExamState::find(ACTIVE);
            $active_state->exams()->save($this);
        }else if($this->state->id == ACTIVE){
            $published_state = ExamState::find(PUBLISHED);
            $published_state->exams()->save($this);
        }

        return $this;
    }

    public function unpublish(){
        if($this->state->id === ACTIVE){
            $draft_state = ExamState::find(DRAFT);
            $draft_state->exams()->save($this);
        }
        return $this;
    }

    public function getAllExamSubmissions(){
        $submissions = $this->submissions()->get();
        $total_submissions = $submissions->count();
        $graded = 0;
        $grading = 0;
        $not_graded = 0;
        foreach($submissions as $exam_submission){
            if($exam_submission->status->id == GRADING){
                $grading += 1;
            }else if($exam_submission->status->id == GRADED){
                $graded += 1;
            }else{
                $not_graded += 1;
            }
            $exam_submission = $exam_submission->getQnSubmissions();
            $student = $exam_submission->user_id;
            $exam_submission->user = User::findOrFail($student)->nus_id;
            $exam_submission->group = User::findOrFail($student)->group()->first();
        }
        $this->submissions = $submissions;
        $this->submission_status = array("graded"=>$graded, "grading"=>$grading, "not_graded"=>$not_graded, "total"=>$total_submissions);
        return $this;
    }

    public function getExamSubmissions($grader_id){
        $grader = User::findOrFail($grader_id);
        $submissions = $this->submissions()->where('grader_id','=',$user->id)->get();
        if($submissions){
            foreach($submissions as $submission){
                $submission = $submission->getQnSubmissions();
                $submission->user = User::findOrFail($submission->user_id)->nus_id;
                $exam_submission->group = User::findOrFail($submission->user_id)->group()->first();
            }
            $this->submissions = $submissions;
        }
        return $this;
    }
}
