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
        Log::info($updated);

        $this->index = $updated['index'];

        if (isset($updated['subindex'])){
            $this->subindex = $updated['subindex'];
        }
        $this->questiontype_id = $updated['questiontype_id'];
        if (isset($updated['title'])){
            $this->title = $updated['title'];
        }
        if (isset($updated['content'])){
            $this->content = $updated['content'];
        }
        if (isset($updated['coding_qn'])){
            $this->coding_qn = $updated['coding_qn'];
        }
        if (isset($updated['compiler_enable'])){
            $this->compiler_enable = $updated['compiler_enable'];
        }
        if (isset($updated['marking_scheme'])){
            $this->marking_scheme = $updated['marking_scheme'];
        }
        if (isset($updated['full_marks'])){
            $this->full_marks = $updated['full_marks'];
        }

        $exam->questions()->save($this);
        if (isset($updated['options'])){
            $this->options = $this->populateOptions($updated['options']);
        }

        Log::info($this);
        return $this;
    }

    public function populateOptions($inputOptions)
    {
        foreach ($inputOptions as $option) {
            if(array_key_exists('id', $option)){
                $old_option = Option::find($option['id']);
                $old_option->content = $option['content'];
                $old_option->correctOption = $option['correctOption'];
                $old_option->save();
            }else{
                $newOption = new Option(array(
                    'content' => $option['content'],
                    'correctOption' => $option['correctOption']
                ));
                $this->options()->save($newOption);
            }
        }
        $options = $this->options()->get();
        return $options;
    }

    public function deleteQuestion(){
        $this->options()->delete();
        $this->delete();
    }

}
