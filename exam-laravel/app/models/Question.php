<?php

class Question extends Eloquent {

	protected $fillable = array('index','subindex','questiontype_id','title','content','exam');

	public function type()
    {
        return $this->belongTo('Questiontype');
    }

}
