<?php
use GuzzleHttp\Client;

class HomeController extends BaseController {

	public function getHome()
	{
		return View::make('home');
	}

	public function getCourses()
	{
    	// $token = Crypt::decrypt(Session::get('token'));
		// return Course::whereHas('students', function($q)
		// {
		// 	//select all courses taken by user
		// 	$id = Session::get('user_id');
		//     $q->where('nus_id', 'like', $id);

		// })->get();

		// $client = new Client(['base_url' => 'https://ivle.nus.edu.sg']);

		// $data = json_decode(($client->get('/api/Lapi.svc/Modules', [
	 //    'query' => ['APIKey' => '6TfFzkSWBlHOT4ExcqFpY','AuthToken' => $token]
		// ])->getbody()),true);

		// return $data['Results'];
		$id = Session::get('userid');
		$user = User::find($id);

		return Response::make(array('courses'=>($user->courses()->get())));
	}
	public function getQnTypes()
	{
		return Response::make(array('types'=>(QuestionType::all())));
	}

}
