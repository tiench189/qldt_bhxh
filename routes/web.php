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
Route::get('/student', 'StudentController@index');

Route::group(['prefix' => 'course'], function () {
    Route::get('/', 'CourseController@index');
    Route::get('/result', 'CourseController@allResult');
    Route::get('/update', 'CourseController@edit')->name('course-update');
    Route::post('/update', 'CourseController@update')->name('course-update');
    Route::get( 'dshocvien','CourseController@dshocvien' )->name('type-dshocvien');
});
Route::group(['prefix' => 'hocvien'], function () {
    Route::get('/', 'StudentController@index');
    Route::get('/histories', 'StudentController@histories');
});

Route::group(['prefix' => 'teacher'], function () {
    Route::get( '/','TeacherController@index' )->name('type-index');
    Route::get( 'danhsach','TeacherController@danhsach' )->name('type-danhsach');
});
