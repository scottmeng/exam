<?php

class Exam extends Eloquent{

    protected $fillable = array('name', 'course_id', 'examstate_id','description','duration_in_min','full_marks','total_qn', 'start_time');
    protected $touches = ['course'];

    public function course(){
		return $this->belongsTo('Course');
    }

    public function state(){
    	return $this->belongsTo('ExamState','examstate_id');
    }

    public function questions(){
    	return $this->belongsToMany('Question')->withPivot('index');;
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


    public function getAllSubmissions($withQn, $returnGroup){
        $submissions = $this->submissions()->get();
        $graded = $this->submissions()->where('submissionstate_id','=',GRADED)->get()->count();
        $grading = $this->submissions()->where('submissionstate_id','=',GRADING)->get()->count();
        $not_graded = $this->submissions()->where('submissionstate_id','=',SUBMITTED)->get()->count();
        $graded_submissions = array();
        $grading_submissions = array();
        $not_graded_submissions = array();

        $total_submissions = $submissions->count();

        foreach($submissions as $exam_submission){
            if($withQn == true){
                $exam_submission = $exam_submission->getQnSubmissions();
            }
            $student = $exam_submission->user_id;
            $exam_submission->user = User::findOrFail($student)->nus_id;
            $exam_submission->status = SubmissionState::findOrFail($exam_submission->submissionstate_id)->description;
            
            if($returnGroup){
               switch ($exam_submission->submissionstate_id) {
                    case GRADED:
                        array_push($graded_submissions, $exam_submission);
                        break;
                    case GRADING:
                         array_push($grading_submissions, $exam_submission);
                        break;
                    case SUBMITTED:
                         array_push($not_graded_submissions, $exam_submission);
                        break;
                    default:;
                };  
            }
        }

        $this->submissions = $submissions;
        if($returnGroup){
            $this->graded_submissions = $graded_submissions;
            $this->grading_submissions = $grading_submissions;
            $this->not_graded_submissions = $not_graded_submissions;
        }
        $this->submission_status = array("graded"=>$graded, "grading"=>$grading, "not_graded"=>$not_graded, "total"=>$total_submissions);
        return $this;
    }

    public function getSubmissions($grader_id,$withQn,$returnGroup){
        $submissions = $this->submissions()->where('grader_id','=',$grader_id)->get();
        $graded = $this->submissions()->where('grader_id','=',$grader_id)->where('submissionstate_id','=',GRADED)->get()->count();
        $grading = $this->submissions()->where('grader_id','=',$grader_id)->where('submissionstate_id','=',GRADING)->get()->count();
        $not_graded = $this->submissions()->where('grader_id','=',$grader_id)->where('submissionstate_id','=',SUBMITTED)->get()->count();
        $graded_submissions = array();
        $grading_submissions = array();
        $not_graded_submissions = array();

        $total_submissions = $submissions->count();

        if($submissions){
            foreach($submissions as $submission){
                if($withQn == true){
                    $submission = $submission->getQnSubmissions();
                }      
                $submission->user = User::findOrFail($submission->user_id)->nus_id;
                $submission->status = SubmissionState::findOrFail($submission->submissionstate_id)->description;

               if($returnGroup){
                   switch ($exam_submission.submissionstate_id) {
                        case GRADED:
                            array_push($graded_submissions, $exam_submission);
                            break;
                        case GRADING:
                             array_push($grading_submissions, $exam_submission);
                            break;
                        case SUBMITTED:
                             array_push($not_graded_submissions, $exam_submission);
                            break;
                        default:;
                    };  
                }
            }
            $this->submissions = $submissions;
            if($returnGroup){
                $this->graded_submissions = $graded_submissions;
                $this->grading_submissions = $grading_submissions;
                $this->not_graded_submissions = $not_graded_submissions;
            }
            $this->submission_status = array("graded"=>$graded, "grading"=>$grading, "not_graded"=>$not_graded, "total"=>$total_submissions);
        }
        return $this;
    }

    public function deleteExamWithQns(){
        $questions = $this->questions()->get();
        foreach($questions as $question){
            $question->deleteQuestion();
        }
        $this->delete();
    }

    public function addQuestion($question_id, $index){
        if(!$this->questions->contains($question_id)){
            $this->questions()->attach(Question::find($question_id),array('index',$index));
            $this->updateFullmarks();
        }else{
            $this->questions()->updateExistingPivot($question_id,array('index',$index));
        }
    }

    public function updateQuestion($question_id,$index){

    }

    public function getRandomSubmission(){
        
        $submissions = ExamSubmission::where(function ($query) {
            $query->where('submissionstate_id','=',SUBMITTED)
                  ->orWhere('submissionstate_id','=',GRADING);
        })->whereNotIn( 'id', [$submission_id])->get();
                
        $rand = rand(0, $submissions->count()-1);
        $next_submission = $submissions[$rand];

        return Response::success($next_submission);
    }

    public function updateFullmarks (){
        $this->fullmarks = $this->questions->sum('full_marks');
        $this->save();
    }
}
