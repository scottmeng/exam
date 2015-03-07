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

    public function checkAccess(){
		
		$admin = Role::where('name','like','admin')->first();
		$facilitator = Role::where('name','like','facilitator')->first();

		if ($this->pivot->role_id == $admin->id){
			return 'admin';
		}
		else if($this->pivot->role_id == $facilitator->id){
			return 'facilitator';
		}
		else{
			return 'student';
		}

		return 'undefined';
	}

}
