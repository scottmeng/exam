<?php

class HomeController extends BaseController {
	/******************* Common Actions *******************/
	public function getHome()
	{
		return View::make('home');
	}
	//get course information for home
	public function getCourses()
	{
		$user = User::find(Session::get('userid'));
		if(!$user){
			return Response::error(401,'unauthorized');
		}
		$courses = $user->getCourses();

		return Response::success($courses);
	}
	//get list of admin courses
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

	public function testCode() {
		$code = Input::get('code');
		$lang = Input::get('lang');
		$extension = $this->getExtension($lang);

		//$code = "#include <stdio.h> \nint main() {\nprintf(" . '"' . "Hello world" . '")' . ";\nreturn 0; }";
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
		if (!file_exists($file_name)) {
			$result = $this->generateResult(2, $compilation);
			return Response::success($result);
		}

		// 3. run code
		$execution = $this->runCode($file_name, $lang);
		$result = $this->generateResult(0, $compilation, $execution);
		return Response::success($result);
	}
	/******************* End of Common Actions *******************/
	
	/******************* Helper Actions *******************/
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
				$command = './timeout.sh -t 5 ./' . $file_name . ' 2>&1';
				break;
			case 'java':
				$command = './timeout.sh -t 5 java ' . $file_name . ' 2>&1';
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

// <<<<<<< HEAD
// 	public function testCode() {
// 		$code = Input::get('code');
// 		Log::info($code);
// 		$lang = Input::get('lang');
// 		$extension = $this->getExtension($lang);

// 		$code = "#include <stdio.h> \nint main() {\n sleep(1); printf(" . '"' . "Hello world" . '")' . ";\nreturn 0; }";
// 		if ($extension === false) {
// 			return Response::error(400, 'language not recognized');
// =======
// 	private function isAdmin($course_id){
// 		$user = User::find(Session::get('userid'));
// 		if(!$user){
// 			Response::error(401,'Please Login First!');
// 			return false;
// >>>>>>> master
// 		}
// 		$course = $user->courses()->where('courses.id','=',$course_id)->first();
// 		if(!$course){
// 			Response::error(403,'unauthorized');
// 			return false;
// 		}else if(!$course->isAdmin()){
// 			return false;
// 		}
// <<<<<<< HEAD
// 		$code_file_name = $file_name . $extension;

// 		// 2. compile code
// 		$compilation = $this->compileCode($code_file_name, $file_name, $lang);
// 		if (!file_exists($file_name)) {
// 			Log::info('compilation error');
// 			$result = $this->generateResult(2, $compilation);
// 			return Response::success($result);
// 		}

// 		// 3. run code
// 		Log::info($file_name);
// 		$execution = $this->runCode($file_name, $lang);
// 		$result = $this->generateResult(0, $compilation, $execution);
// 		return Response::success($result);
// =======
// 		return true;
// 	}
// 	private function isFacilitator($course_id){
// 		$user = User::find(Session::get('userid'));
// 		if(!$user){
// 			Response::error(401,'Please Login First!');
// 			return false;
// 		}
// 		$course = $user->courses()->where('courses.id','=',$course_id)->first();
// 		if(!$course){
// 			Response::error(403,'unauthorized');
// 			return false;
// 		}else if(!$course->isFacilitator()){
// 			return false;
// 		}
// 		return true;
// >>>>>>> master
// 	}
}
