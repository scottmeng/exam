<?php

class Question extends Eloquent {

	protected $fillable = array('index','subindex','questiontype_id','title','content','exam','marking_scheme','full_marks');

	public function type()
    {
        return $this->belongsTo('Questiontype');
    }

    public function exam()
    {
    	return $this->belongsTo('Exam');
    }

    public function options()
    {
    	return $this->hasMany('Option');
    }

    public function submissions(){
        return $this->hasMany('QuestionSubmission');
    }

    public function updateQuestion($updated, Exam $exam)
    {
        Log::info('updated quetsion:');
        Log::info($updated);
        $this->index = $updated['index'];
        if (array_key_exists('subindex', $updated)){
            $this->subindex = $updated['subindex'];
        }
        $this->questiontype_id = $updated['questiontype_id'];
        if (array_key_exists('title', $updated)){
            $this->title = $updated['title'];
        }
        if (array_key_exists('content', $updated)){
            $this->content = $updated['content'];
        }
        if (array_key_exists('coding_qn', $updated)){
            $this->coding_qn = $updated['coding_qn'];
        }
        if (array_key_exists('compiler_enable', $updated)){
            $this->compiler_enable = $updated['compiler_enable'];
        }
        if (array_key_exists('marking_scheme', $updated)){
            $this->marking_scheme = $updated['marking_scheme'];
        }
        if (array_key_exists('full_marks', $updated)){
            $this->full_marks = $updated['full_marks'];
        }

        $exam->questions()->save($this);
        $this->options()->delete();
        if (array_key_exists('options', $updated)){
            $this->options = $this->populateOptions($updated['options']);
        }

        return $this;
    }

    public function populateOptions($inputOptions)
    {
        foreach ($inputOptions as $option) {

            $newOption = new Option(array(
                'content' => $option['content'],
                'correctOption' => $option['correctOption']
            ));

            $this->options()->save($newOption);
        }
        $options = $this->options()->get();
        return $options;
    }

}
