<?php
// use GuzzleHttp\Client;

class HomeController extends BaseController {

	public function getHome()
	{
		return View::make('home');
	}

	public function getCourses()
	{
		$user = User::find(Session::get('userid'));
		if(!$user){
			return Response::error(401,'unauthorized');
		}
		$courses = $user->getCourses();

		return Response::success($courses);
	}

	public function getAdminCourses()
	{
		$user = User::find(Session::get('userid'));
		if(!$user){
			return Response::error(401,'unauthorized');
		}
		$courses = $user->getAdminCourses();

		return Response::success($courses);
	}

	public function getQnTypes()
	{
		return Response::success(Questiontype::all());
	}

	public function newExam()
	{
		$user = User::find(Session::get('userid'));
		if(!$user){
			return Response::error(401,'Please Login First!');
		}

		$course_id = Input::get('course_id');
		$course = $user->courses()->where('courses.id','=',$course_id)->first();
		if(!$course){
			return Response::error(401,'Page not available!');
		}else if($course->pivot->role_id != ADMIN){
			return Response::error(401,'You are unauthorized to view this page!');
		}

		$title = Input::get('title');

		//check if exam with the same title under the same course already exists
		$valid_exam = Exam::whereRaw('course_id = ? and title = ?',array($course_id,$title))->get()->isEmpty();

		if($valid_exam == True){

		 	$exam = new Exam();
			$exam->title=$title;	
			$course->exams()->save($exam);

			return Response::success($exam);
		}
		else{
		    return Response::error(406,'Exam already exists!');
		}
	}

	public function deleteExamWithQns()
	{
		$user = User::find(Session::get('userid'));
		if(!$user){
			return Response::error(401,'Please Login First!');
		}

		$exam_id = Input::get('id');
		$exam = Exam::find($exam_id);

		$course_id = $exam->course->id;
		$course = $user->courses()->where('courses.id','=',$course_id)->first();
		if(!$course){
			return Response::error(401,'Page not available!');
		}else if($course->pivot->role_id != ADMIN){
			return Response::error(401,'You are unauthorized to view this page!');
		}

		$exam->deleteExamWithQns();

		return Response::success('deleted');
	}

	public function deleteExam(){

		$user = User::find(Session::get('userid'));
		if(!$user){
			return Response::error(401,'Please Login First!');
		}

		$exam_id = Input::get('id');
		$exam = Exam::find($exam_id);

		$course_id = $exam->course->id;
		$course = $user->courses()->where('courses.id','=',$course_id)->first();
		if(!$course){
			return Response::error(401,'Page not available!');
		}else if($course->pivot->role_id != ADMIN){
			return Response::error(401,'You are unauthorized to view this page!');
		}

		DB::statement('SET FOREIGN_KEY_CHECKS = 0');
		Exam::destroy($exam_id);
		DB::statement('SET FOREIGN_KEY_CHECKS = 1');

		return Response::success('deleted');
	}

	// reformat code
	// store code snippet in designated directory
	private function saveCode($file_name, $code, $extension) {
		// reformat code string to better suit file input
		if (!is_dir('code')) {
			// dir doesn't exist, make it
			mkdir('code');
		}
		$result = file_put_contents('code/' . $file_name . $extension, $code);
		if ($result === false) {
			return false;
		}
		return 'code/' . $file_name;
	}

	// generate well-formatted results
	private function generateResult($status, $compilation = null, $execution = null) {
		$result = array(
			'status' => $status,
			'compilation' => $compilation,
			'execution' => $execution
		);
		return $result;
	}

	private function getExtension($lang) {
		switch ($lang) {
			case 'c':
				return '.c';
			case 'c++':
				return '.cpp';
			case 'java':
				return '.java';
			default:
				return false;
		}
	}

	private function compileCode($code_name, $file_name, $lang) {
		switch ($lang) {
			case 'c':
				$command = 'gcc ' . $code_name . ' -o ' . $file_name . ' 2>&1 | cut -d: -f2-';
				break;
			case 'c++':
				$command = 'g++ ' . $code_name . ' -o ' . $file_name . ' 2>&1 | cut -d: -f2-';
				break;
			case 'java':
				$command = 'javac ' . $code_name . ' 2>&1 | cut -d: -f2-';
				break;
			default:
				return 'unknown language';
		}

		// remove executable if exists
		if (file_exists($file_name)) {
			unlink($file_name);
		}

		$output = exec($command, $details);
		return $details;
	}

	private function runCode($file_name, $lang) {
		switch ($lang) {
			case 'c':
			case 'c++':
				$command = './' . $file_name . ' 2>&1';
				break;
			case 'java':
				$command = 'java ' . $file_name . ' 2>&1';
				break;
			default:
				return 'unknown language';		
		}
		exec($command, $details);
		return $details;
	}

	private function generateFileName($code, $lang) {
		$hash = hash('sha256', $code);
		$base32 = base64_encode($hash);
		return $base32 . '_' . $lang;
	}

	public function testCode() {
		$code = Input::get('code');
		Log::info($code);
		$lang = Input::get('lang');
		$extension = $this->getExtension($lang);

		$code = "#include <stdio.h> \nint main() {\nprintf(" . '"' . "Hello world" . '")' . ";\nreturn 0; }";
		if ($extension === false) {
			return Response::error(400, 'language not recognized');
		}
		$file_name = $this->generateFileName($code, $lang);

		// 1. create file
		$file_name = $this->saveCode($file_name, $code, $extension);
		if ($file_name === false) {
			return Response::error(500, 'cannot create file');
		}
		$code_file_name = $file_name . $extension;

		// 2. compile code
		$compilation = $this->compileCode($code_file_name, $file_name, $lang);
		Log::info($compilation);
		if (!file_exists($file_name)) {
			Log::info('compilation error');
			$result = $this->generateResult(2, $compilation);
			return Response::success($result);
		}

		// 3. run code
		$execution = $this->runCode($file_name, $lang);
		$result = $this->generateResult(0, $compilation, $execution);
		return Response::success($result);
	}
}
