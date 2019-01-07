<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/students', 'StudentController@index');
Route::post('/students', 'StudentController@store');
Route::put('/students/{id}', 'StudentController@update');
Route::delete('/students/{id}', 'StudentController@destroy');
Route::get('/students/{id}', 'StudentController@show_student_details');

Route::post('/classes', 'ClassesController@store');
Route::get('/classes', 'ClassesController@index');
Route::put('/classes/{id}/', 'ClassesController@update');
Route::delete('/classes/{id}', 'ClassesController@destroy');

Route::post('/subjects', 'SubjectsController@store');
Route::get('/subjects', 'SubjectsController@index');
Route::put('/subjects/{id}/', 'SubjectsController@update');
Route::delete('/subjects/{id}', 'SubjectsController@destroy');

Route::get('/subjects/{id}', 'SubjectsController@show_students');