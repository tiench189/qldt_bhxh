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


Route::get('/cas', 'CasController@login')->name('login');
Route::get('/logout', 'CasController@logout')->name('logout');
Route::post('/caslogout', 'CasController@caslogout');

Route::get('/errpermission', function () {
    return view('errpermission');
});

Route::group(['middleware' => 'cas_auth'], function () {
    Route::group(['middleware' => 'check_role'], function () {
        Route::get('/', 'CourseController@index')->name('index');
        Route::group(['prefix' => 'course'], function () {
            Route::get('/result', 'CourseController@allResult')->name('course-result');
            Route::get('/class', 'CourseController@classindex')->name('course-classes');
            Route::get('/export', 'CourseController@export');
            Route::get('/update', 'CourseController@edit')->name('course-update');
            Route::post('/update', 'CourseController@update')->name('course-update');
            Route::post('/removestudent', 'CourseController@removestudent')->name('student-remove');
            Route::post('/removecourse', 'CourseController@removeCourse')->name('course-remove');
            Route::post('/addstudent', 'CourseController@addstudent')->name('student-add');
            Route::get('dshocvien', 'CourseController@dshocvien')->name('course-dshocvien');
            Route::get('getContents', 'CourseController@getContents')->name('course-getContents');
            Route::post('createCourse', 'CourseController@createCourse')->name('course-createCourse');
            Route::get('createCourse', 'CourseController@createCourse')->name('course-createCourse');
        });
        Route::group(['prefix' => 'hocvien'], function () {
            Route::get('/', 'StudentController@index')->name('hocvien-index');
            Route::get('/histories', 'StudentController@histories')->name('hocvien-histories');
        });
        Route::group(['prefix' => 'tracuu'], function () {
            Route::get('/', 'TraCuuController@index')->name('tracuu');
            Route::post('/', 'TraCuuController@index')->name('tracuu');
        });

        Route::group(['prefix' => 'teacher'], function () {
            Route::get('/', 'TeacherController@index')->name('teacher-index');
            Route::get('danhsach', 'TeacherController@danhsach')->name('teacher-danhsach');
            Route::get('/update', 'TeacherController@edit')->name('teacher-update');
            Route::post('/update', 'TeacherController@update')->name('teacher-update');
        });

        Route::group(['prefix' => 'class'], function () {
            Route::get('/', 'ClassController@index')->name('class-index');
            Route::get('/xeploaihv', 'ClassController@xeploaihv')->name('class-xeploaihv');
            Route::post('/capnhathocvien', 'ClassController@capnhathocvien')->name('class-capnhathocvien');
            Route::get('/danhsach', 'ClassController@danhsach')->name('class-danhsach');
            Route::get('/edit', 'ClassController@edit')->name('class-edit');
            Route::post('/edit', 'ClassController@update')->name('class-edit');
        });

        Route::group(['prefix' => 'baocao'], function () {
            Route::get('/tonghop', 'ReportController@tonghop')->name('baocao-tonghop');
            Route::get('/download_tonghop', 'ReportController@downloadTonghop')->name('download-tonghop');
        });

        Route::group(['prefix' => 'role'], function () {
            Route::get('/', 'RolesController@index')->name('role-index');
            Route::get('/assign', 'RolesController@assignRole')->name('role-assign');
            Route::post('/assign', 'RolesController@submitRole')->name('role-assign');
            Route::get('/create', 'RolesController@createRole')->name('role-create');
            Route::post('/create', 'RolesController@createRole')->name('role-create');
            Route::post('/delete', 'RolesController@deleteRole')->name('role-delete');
        });
    });
});
