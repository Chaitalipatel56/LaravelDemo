<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class StudentModelServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        \App\Student::observe(\App\Observers\StudentObserver::class);
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
