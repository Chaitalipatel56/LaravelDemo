<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
	public function students(){
		return $this->belongsToMany('App\Subjects','Student_subject_relationship','student_id','subject_id');
    }
}
