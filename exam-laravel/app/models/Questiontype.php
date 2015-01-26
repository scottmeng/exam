<?php

class Questiontype extends Eloquent {

	protected $fillable = array('name','description');

	public function questions()
    {
        return $this->hasMany('Question');
    }

}
