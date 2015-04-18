<?php
use Carbon\Carbon;

class CourseController extends BaseController {

	/******************* Admin Actions *******************/
	//create new exam
	public function postNewexam($course_id){
		$course = Course::find($course_id);
		if(!$course){
			Response::error('404','Exam Not Found');
		}
		if($this->isAdmin($course_id)){
			$title = Input::get('title');
			//check if exam with the same title under the same course already exists
			$valid_exam = Exam::whereRaw('course_id = ? and title = ?',array($course_id,$title))->get()->isEmpty();
			if($valid_exam){
			 	$exam = new Exam();
				$exam->title=$title;	
				$exam->starttime=Carbon::now('GMT');//default time now
				$course->exams()->save($exam);
				return Response::success($exam);
			}
			else{
			    return Response::unavailable('Exam already exists!');
			}
		}
	}
	//update course description
	public function putCourse($course_id){
		$course = Course::find($course_id);
		if(!$course){
			Response::error('404','Exam Not Found');
		}
		if($this->isAdmin($course_id)){
			$course->description = Input::get('description');
			$course->save();
			return Response::success($course);
		}
	}
	//add new question
	public function postCreateqn($course_id){
		$course = Course::find($course_id);
		if(!$course){
			Response::error('404','Exam Not Found');
		}
		if($this->isAdmin($course_id)){
			$question = new Question(array(
				'questiontype_id' => Input::get('questiontype_id',0),
				'title' => Input::get('title',NULL),
				'content' => Input::get('content',NULL),
				'compiler_enable' => Input::get('compiler_enable',False),
				'marking_scheme' => Input::get('marking_scheme',NULL),
				'full_marks' => Input::get('full_marks',0),
			));			
			$course->questions()->save($question);
			if(Input::has('options')){
				$question['options'] = $question->populateOptions(Input::get('options'));
			}
			return Response::success($question);
		}
	}
	//delete question
	public function postDeleteqn($course_id){
		$course = Course::find($course_id);
		if(!$course){
			Response::error('404','Exam Not Found');
		}
		if($this->isAdmin($course_id)){
			$question=Question::find(Input::get('id'));
			$question->deleteQuestion();
			return Response::success('deleted');
		}
	}
	/******************* End of Admin Actions *******************/

	/******************* Admin/TA Actions *******************/
	//get course information - exams, exam submissions
	//information about TA will be passed to admin too
	public function getCourse($course_id)
	{
		$course = Course::find($course_id);
		if(!$course){
			return Response::error(404,'Course not found');			
		}
		if($this->isFacilitator($course_id)){
			$course = $course->getExamsWithSubmissions(User::find(Session::get('userid')));				
			if($this->checkUser($course_id) == ADMIN){
				foreach($course->exams as $exam){
					$exam = $exam->getGrader();
				}
				$course->facilitators = $course->users()->where('course_user.role_id','=',FACILITATOR)->count();
			}
			$course->questions = $course->questions()->get();
			$course->user_role = Role::find($this->checkUser($course_id))->name;
			return Response::success($course);
		}
	}
	/******************* End of Admin/TA Actions *******************/

	/******************* Helper Actions *******************/
	private function isAdmin($course_id){
		$user = User::find(Session::get('userid'));
		if(!$user){
			Response::error(401,'not log in');
			return false;
		}
		$course = $user->courses()->where('courses.id', '=', $course_id)->first();
        if(!$course || $course->pivot->role_id != ADMIN){
  			Response::error(403,'unauthorized');          
            return false;
        }
        return true;
	}
	private function isFacilitator($course_id){
		$user = User::find(Session::get('userid'));
		if(!$user){
			Response::error(401,'not log in');
			return false;
		}
		$course = $user->courses()->where('courses.id', '=', $course_id)->first();
		// Log::info($course->pivot->role_id != FACILITATOR);
		// Log::info(!$course || ($course->pivot->role_id != ADMIN && $course->pivot->role_id != FACILITATOR));
        if(!$course || ($course->pivot->role_id != ADMIN && $course->pivot->role_id != FACILITATOR)){
			Log::info("I was here");
  			Response::error(403,'unauthorized');          
            return false;
        }
		return true;		
	}
	private function checkUser($course_id){
		$user = User::find(Session::get('userid'));
		if(!$user){
			Response::error(401,'not log in');
			return;
		}
        $course = $user->courses()->where('courses.id', '=', $course_id)->first();
        if(!$course){
            return UNKNOWN;
        }
        return $course->pivot->role_id;
	}

}
