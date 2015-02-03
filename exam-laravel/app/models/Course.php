<?php

class Course extends Eloquent {

	protected $fillable = array('nus_id','name','description');


    public function exams()
    {
        return $this->hasMany('Exam');
    }

    public function users()
    {
        return $this->belongsToMany('User')->withPivot('role_id');
    }

}
