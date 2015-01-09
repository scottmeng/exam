<?php

class Facilitator extends Eloquent{

    protected $fillable = array('nus_id', 'name', 'comment');

    public function courses(){
		return $this->morphToMany('Course', 'Enroluser');
    }

}
