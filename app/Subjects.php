<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Subjects extends Model
{	
    protected $primaryKey = 'subject_id';

    public function student() {
    	return $this->hasMany('App\Student_subject_relationship', 'subject_id');
    }

}
