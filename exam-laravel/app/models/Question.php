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

    public function updateQuestion($updated)
    {
        $this->index = $updated['index'];
        $this->subindex = $updated['subindex'];
        $this->questiontype_id = $updated['questiontype_id'];
        $this->title = $updated['title'];
        $this->content = $updated['content'];
        $this->coding_qn = $updated['coding_qn'];
        $this->compiler_enable = $updated['compiler_enable'];
        $this->marking_scheme = $updated['marking_scheme'];
        $this->full_marks = $updated['full_marks'];

        $this->save();
        $this->options()->delete();
        $this->options = $this->populateOptions($updated['options']);

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
