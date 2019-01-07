<?php

namespace App\Observers;

use App\Student;

class StudentObserver
{
    /**
     * Handle the student "created" event.
     *
     * @param  \App\student  $student
     * @return void
     */
    public function creating(Student $student)
    {
      $student->name = strtoupper($student->name);
      $student->address = strtoupper($student->address); 
      echo 'Record insert using observer creating method';
    }

    public function created(student $student)
    {
        //
    }

    /**
     * Handle the student "updated" event.
     *
     * @param  \App\student  $student
     * @return void
     */
    public function updated(student $student)
    {
        //
    }

    /**
     * Handle the student "deleted" event.
     *
     * @param  \App\student  $student
     * @return void
     */
    public function deleted(student $student)
    {
        echo 'Record deleted using observer method';
    }

    /**
     * Handle the student "restored" event.
     *
     * @param  \App\student  $student
     * @return void
     */
    public function restored(student $student)
    {
        //
    }

    /**
     * Handle the student "force deleted" event.
     *
     * @param  \App\student  $student
     * @return void
     */
    public function forceDeleted(student $student)
    {
        //
    }
}