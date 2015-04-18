<?php
use Carbon\Carbon;

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
            $this->questions()->attach($question_id,array('index'=>$index));
            $this->updateFullmarks();
        }else{
            $this->questions()->updateExistingPivot($question_id,array('index'=>$index));
        }
    }

    public function getGrader(){
        $graders = User::whereIn('id',$this->submissions()->select('grader_id')->distinct()->get()->toArray())
                        ->get(); 
        $graders_info=array();
        foreach($graders as $grader){
            $grading_info = array(
                'id'=>$grader->nus_id,
                'name'=>$grader->name,
                'assigned'=>$grader->assignedsubmissions()->where('exam_id','=',$this->id)->count(),
                'graded'=>$grader->assignedsubmissions()->where('submissionstate_id', '=', GRADED)->where('exam_id','=',$this->id)->count(),
                'grading'=>$grader->assignedsubmissions()->where('submissionstate_id', '=', GRADING)->where('exam_id','=',$this->id)->count(),
                'average'=>$grader->assignedsubmissions()->where('submissionstate_id', '=', GRADED)->where('exam_id','=',$this->id)->avg('total_marks')
            );
            array_push($graders_info,$grading_info);
        }
        $this->graders = $graders_info;
        return $this;
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

    public function updateTotalQn(){
        $this->totalqn = $this->questions->count();
        $this->save();       
    }

    public function isAdmin($user){
        $course_id = $this->course->id;
        $course = $user->courses()->where('courses.id', '=', $course_id)->first();
        if(!$course || $course->pivot->role_id != ADMIN){
            return false;
        }
        return true;
    }

    public function isFacilitator($user){
        Log::info($user);
        $course_id = $this->course->id;
        $course = $user->courses()->where('courses.id', '=', $course_id)->first();
        if(!$course || ($course->pivot->role_id != ADMIN && $course->pivot->role_id != FACILITATOR)){
            return false;
        }
        return true;
    }

    public function checkRole($user){
        $course_id = $this->course->id;
        $course = $user->courses()->where('courses.id', '=', $course_id)->first();
        if(!$course){
            return UNKNOWN;
        }
        return $course->pivot->role_id;
    }

    public function getStatus($user){
        $status = STATUS_UNAVAILABLE;
        if($this->examstate_id == DRAFT && $this->isAdmin($user)){
                $status = STATUS_DRAFT;
        }
        else if($this->examstate_id == ACTIVE){
            $now = Carbon::now('Asia/Singapore');
            $starttime = new Carbon($this->starttime,'GMT');
            $endtime = (new Carbon($this->starttime,'GMT'))->addMinutes($this->duration);
            $visibletime = (new Carbon($this->starttime,'GMT'))->subMinutes($this->grace_period);

            if($this->isFacilitator($user)){
                if($now->lt($visibletime)){
                    $status = STATUS_NOT_STARTED;
                }else if($now->gt($endtime)){    
                    $status = STATUS_FINISHED;
                }
            }  
            if($now->between($visibletime,$endtime)){
                $status = STATUS_IN_EXAM;
            }
        }else if($this->examstate_id == PUBLISHED){
            $status = STATUS_PUBLISHED;
        }
        return $status;
    }

}
