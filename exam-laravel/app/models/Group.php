<?php

class Group extends Eloquent {

	protected $fillable = array('name','course_id','ta_id');

    public function course()
    {
        return $this->belongsTo('Course');
    }

    public function ta(){
    	return $this->belongsTo('User','ta_id');
    }

    public function students(){
    	return $this->belongsToMany('User');
    }

}
