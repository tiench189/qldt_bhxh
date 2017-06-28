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

Route::get('/', 'CourseController@index');
Route::get('/cas', 'CasController@login');
Route::get('/logout', 'CasController@logout');
Route::post('/caslogout', 'CasController@caslogout');

Route::group(['prefix' => 'course'], function () {
    Route::get('/', 'CourseController@index');
    Route::get('/result', 'CourseController@allResult');
    Route::get('/class', 'CourseController@classindex');
    Route::get('/export', 'CourseController@export');
    Route::get('/update', 'CourseController@edit')->name('course-update');
    Route::post('/update', 'CourseController@update')->name('course-update');
});
Route::group(['prefix' => 'hocvien'], function () {
    Route::get('/', 'StudentController@index');
    Route::get('/histories', 'StudentController@histories');
});

Route::group(['middleware' => 'cas_auth'], function () {
    Route::group(['prefix' => 'tracuu'], function () {
        Route::get('/', 'TraCuuController@index');
    });
});
