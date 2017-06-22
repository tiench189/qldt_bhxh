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

Route::get('/', 'IndexController@index');

Route::get('/student', 'StudentController@index');
Route::group(['prefix' => 'course'], function () {
    Route::get('/', 'CourseController@index');
    Route::get('/result', 'CourseController@allResult');
});
