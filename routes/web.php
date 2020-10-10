<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', 'Controller@index');

Auth::routes();

Route::get('/admin','HomeController@adminPage')->name('admin');
Route::get('/admin/syllabus','HomeController@syllabusPage');
Route::get('/admin/syllabus/deleteTopic/{topic}','HomeController@deleteTopic');
Route::get('/admin/syllabus/deleteUnit/{topic}/{unit}','HomeController@deleteUnit');
Route::get('/admin/syllabus/deleteLesson/{id}','HomeController@deleteLesson');
Route::get('/admin/syllabus/{topic}','HomeController@unitPage');
Route::get('/admin/syllabus/{topic}/{unit}','HomeController@stepPhasePage');
Route::get('/admin/syllabus/{id}/{phase}/steps','HomeController@stepPage');

Route::get('/home', 'TeacherController@index')->name('home');
Route::get('/addclasspage','TeacherController@addClassPage');
Route::get('/class/{user_id}/{class_id}','TeacherController@classPage');
Route::get('/get/{selection}/{data}/{class_id}','TeacherController@getData');
Route::get('/class/{user_id}/{class_id}/steps/{step_id}','TeacherController@stepPage');
Route::get('/class/{user_id}/{class_id}/steps/{step_id}/{where}','TeacherController@stepPageNav');
Route::get('/class/{user_id}/{class_id}/redirect','TeacherController@redirectEnd');
Route::get('/class/{user_id}/{class_id}/redirect/{syllabus_id}/{where}','TeacherController@redirectPath');

Route::post('/admin/syllabus/addtopic','HomeController@addTopic');
Route::post('/admin/syllabus/addunit','HomeController@addUnit');
Route::post('/admin/syllabus/addlesson','HomeController@addLesson');
Route::post('/admin/syllabus/addstep','HomeController@addStep');
