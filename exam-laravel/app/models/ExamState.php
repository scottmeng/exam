<?php

class ExamState extends Eloquent{

    protected $fillable = array('name', 'description');
    protected $table = 'examstates';

    public function exams(){
		return $this->hasMany('Exam');
    }
}
