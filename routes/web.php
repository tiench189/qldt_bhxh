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

Route::group(['prefix' => 'course'], function () {
    Route::get('/', 'CourseController@index');
    Route::get('/result', 'CourseController@allResult');
    Route::get('/class', 'CourseController@classindex');
    Route::get('/export', 'CourseController@export');
    Route::get('/update', 'CourseController@edit')->name('course-update');
    Route::post('/update', 'CourseController@update')->name('course-update');
    Route::get( 'dshocvien','CourseController@dshocvien' )->name('course-dshocvien');
});
Route::group(['prefix' => 'hocvien'], function () {
    Route::get('/', 'StudentController@index');
    Route::get('/histories', 'StudentController@histories');
});
Route::group(['prefix' => 'tracuu'], function () {
    Route::get('/', 'TraCuuController@index');
});

Route::group(['prefix' => 'teacher'], function () {
    Route::get( '/','TeacherController@index' )->name('teacher-index');
    Route::get( 'danhsach','TeacherController@danhsach' )->name('teacher-danhsach');
    Route::get('/update', 'TeacherController@edit')->name('teacher-update');
    Route::post('/update', 'TeacherController@update')->name('teacher-update');
});

Route::group(['prefix' => 'class'], function () {
    Route::get( '/','ClassController@index' )->name('class-index');
    Route::get('/xeploaihv', 'ClassController@xeploaihv')->name('class-xeploaihv');
    Route::post('/capnhathocvien', 'ClassController@capnhathocvien')->name('class-capnhathocvien');
    Route::get('/danhsach', 'ClassController@danhsach')->name('class-danhsach');
});