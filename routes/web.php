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

Route::get('/', 'CourseController@index')->name('index');
Route::get('/cas', 'CasController@login')->name('login');
Route::get('/logout', 'CasController@logout')->name('logout');
Route::post('/caslogout', 'CasController@caslogout');

Route::get('/errpermission', function () {
    return view('errpermission');
});

Route::group(['prefix' => 'course'], function () {
    Route::get('/', 'CourseController@index')->name('course-index');
    Route::get('/result', 'CourseController@allResult')->name('course-result');
    Route::get('/class', 'CourseController@classindex')->name('course-classes');
    Route::get('/export', 'CourseController@export');
    Route::get('/update', 'CourseController@edit')->name('course-update');
    Route::post('/update', 'CourseController@update')->name('course-update');
    Route::post('/removestudent', 'CourseController@removestudent')->name('student-remove');
    Route::post('/addstudent', 'CourseController@addstudent')->name('student-add');
    Route::get( 'dshocvien','CourseController@dshocvien' )->name('course-dshocvien');
});
Route::group(['prefix' => 'hocvien'], function () {
    Route::get('/', 'StudentController@index')->name('hocvien-index');
    Route::get('/histories', 'StudentController@histories')->name('hocvien-histories');
});
Route::group(['middleware' => 'cas_auth'], function () {
    Route::group(['middleware' => 'check_role'], function () {
      Route::group(['prefix' => 'tracuu'], function () {
          Route::get('/', 'TraCuuController@index')->name('tracuu');
          Route::post('/', 'TraCuuController@index')->name('tracuu');
      });
    });
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