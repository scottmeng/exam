<?php

class EditExamController extends BaseController {

	public function putEditexam($exam_id)
	{
		$exam = Exam::findOrFail($exam_id);

		$exam->title = Input::get('title');
		$exam->description = Input::get('description');
		$exam->duration = Input::get('duration');
		$exam->fullmarks = Input::get('fullmarks');
		$exam->totalqn = Input::get('totalqn');
		$exam->starttime = Input::get('starttime');

		$exam->save();
		return Response::success($exam);
	}

	public function getExaminfo($exam_id)
	{
		$exam = Exam::find($exam_id);
		$exam['questions'] = $this->retrieveQuestions($exam);	
		return Response::success($exam);
	}

	public function postQuestion($exam_id)
	{
		$exam = Exam::findOrFail($exam_id);

		$question = new Question(array(
			'index'=>Input::get('index',-1),
			'subindex' => Input::get('subindex',-1),
			'questiontype_id' => Input::get('questiontype_id',-1),
			'title' => Input::get('title',NULL),
			'content' => Input::get('content',NULL),
			'coding_qn' => Input::get('coding_qn',False),
			'compiler_enable' => Input::get('compiler_enable',False),
			'marking_scheme' => Input::get('marking_scheme',NULL),
			'full_marks' => Input::get('full_marks',0)
		));

		$exam->questions()->save($question);
		$question['options'] = $this->populateOptions($question,Input::get('options'));
		return Response::success($question);
	}

	public function putQuestion($exam_id)
	{
		$question_id = Input::get('id');
		$question = Question::findOrFail($question_id);

		Log::info(Input::get('options'));

		$question->index = Input::get('index',-1);
		$question->subindex = Input::get('subindex',-1);
		$question->questiontype_id = Input::get('questiontype_id',-1);
		$question->title = Input::get('title',NULL);
		$question->content = Input::get('content',NULL);
		$question->coding_qn = Input::get('coding_qn',False);
		$question->compiler_enable = Input::get('compiler_enable',False);
		$question->marking_scheme = Input::get('marking_scheme',NULL);
		$question->full_marks = Input::get('full_marks',0);

		$question->save();
		$question->options()->delete();
		$question['options'] = $this->populateOptions($question,Input::get('options'));
		return Response::success($question);
	}

	public function postDeletequestion($exam_id)
	{
		$qn_id = Input::get('id');

		$question = Question::find($qn_id);
		$question->options()->delete();
		$question->delete(); 

		return Response::success($question);
	}

	public function putPublish($exam_id)
	{
		$exam = Exam::findOrFail($exam_id);
		$publish_state = ExamState::whereRaw('name = ?',array('active'))->first();
		$publish_state->exams()->save($exam);

		return Response::success($exam);
	}

	public function putUnpublish($exam_id)
	{
		$exam = Exam::findOrFail($exam_id);
		$draft_state = ExamState::whereRaw('name = ?',array('draft'))->first();
		$draft_state->exams()->save($exam);

		return Response::success($exam);
	}

	private function retrieveQuestions($exam)
	{
		$questions = $exam->questions()->get();

		foreach($questions as $question){
			$question['options']=$question->options()->get();
		}

		Log::info('test');
		Log::info($questions);

		return $questions;
	}

	private function populateOptions($question, $inputOptions)
	{
        foreach ($inputOptions as $option) {

        	Log::info($option);

			$newOption = new Option(array(
				'content' => $option['content'],
				'correctOption' => $option['correctOption']
			));

			$question->options()->save($newOption);
		}
		$options = $question->options()->get();
		return $options;
	}

}
