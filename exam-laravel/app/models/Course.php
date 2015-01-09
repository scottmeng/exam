<?php

class Course extends Eloquent {

	protected $fillable = array('nus_id','name','description','admin');

	public function facilitators()
    {
        return $this->morphedByMany('Facilitator', 'Enroluser');
    }

    public function students()
    {
        return $this->morphedByMany('Student', 'Enroluser');
    }

    public function exams()
    {
        return $this->hasMany('Exam');
    }

    public function user()
    {
        return $this->morphTo();
    }

}
