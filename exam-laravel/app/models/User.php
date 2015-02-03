<?php

class User extends Eloquent{

    protected $fillable = array('nus_id', 'name', 'comment');

    public function courses(){
    	return $this->belongsToMany('Course')->withPivot('role_id');
    }
}
