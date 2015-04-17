<?php

class Question extends Eloquent {

	protected $fillable = array('questiontype_id','title','content','course_id','language','compiler_enable','marking_scheme','full_marks','suggested_answer','general_feedback');
    protected $touches = ['course'];

	public function type()
    {
        return $this->belongsTo('Questiontype','questiontype_id');
    }

    public function exams()
    {
    	return $this->belongsToMany('Exam')->withPivot('index');;
    }

    public function course(){
        return $this->belongsTo('Course');
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
        $this->questiontype_id = $updated['questiontype_id'];
        if (isset($updated['title'])){
            $this->title = $updated['title'];
        }
        if (isset($updated['content'])){
            $this->content = $updated['content'];
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
        $this->save();

       // $course->questions()->save($this);
        if (isset($updated['options'])){
            $this->options = $this->populateOptions($updated['options']);
        }
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
        $this->exams()->detach();
        $this->options()->delete();
        $this->delete();
    }

}
