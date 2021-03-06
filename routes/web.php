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
Auth::routes();


//Route::get('/cas', 'CasController@login')->name('login');
//Route::get('/logout', 'CasController@logout')->name('logout');
//Route::post('/caslogout', 'CasController@caslogout');

Route::get('/errpermission', function () {
    return view('errpermission');
});

Route::group(['middleware' => 'auth'], function () {
    Route::group(['prefix' => 'course'], function () {
        Route::get('getContents', 'CourseController@getContents')->name('course-getContents');
        Route::post('checkStudentCategory', 'CourseController@checkStudentCategory')->name('course-checkStudentCategory');
        Route::post('/importstudentsubmit', 'CourseController@importstudentsubmit')->name('student-import-submit');
        Route::post('/importstudent', 'CourseController@importstudent')->name('student-import');

    });
    Route::group(['prefix' => 'teacher'], function () {
        Route::get('/ds-mot-lop', 'TeacherController@listTeacherOfClass')->name('teacher-class-list');
        Route::get('/profile', 'TeacherController@profile')->name('teacher-profile');
    });

    Route::group(['middleware' => 'check_role'], function () {
        Route::get('/', 'CategoryController@index')->name('index');
        Route::group(['prefix' => 'course'], function () {
            Route::get('/', 'CourseController@index')->name('course-index');
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
            Route::post('checkStudentCategory', 'CourseController@checkStudentCategory')->name('course-checkStudentCategory');

        });
        Route::group(['prefix' => 'category'], function () {
            Route::post('create', 'CategoryController@create')->name('category-create');
            Route::get('create', 'CategoryController@create')->name('category-create');
            Route::post('/remove', 'CategoryController@remove')->name('category-remove');
            Route::get('/update', 'CategoryController@update')->name('category-update');
            Route::post('/update', 'CategoryController@update')->name('category-update');
            Route::get('/dshv', 'CategoryController@danhsachhocvien')->name('category-dshv');
        });
        Route::group(['prefix' => 'hocvien'], function () {
            Route::get('/', 'StudentController@index')->name('hocvien-index');
            Route::get('/histories', 'StudentController@histories')->name('hocvien-histories');
            Route::get('/add', 'StudentController@add')->name('hocvien-add');
            Route::post('/add', 'StudentController@add')->name('hocvien-add');
            Route::get('/update', 'StudentController@update')->name('hocvien-update');
            Route::post('/update', 'StudentController@update')->name('hocvien-update');
            Route::post('/remove', 'StudentController@remove')->name('hocvien-remove');
        });
        Route::group(['prefix' => 'tracuu'], function () {
            Route::get('/', 'TraCuuController@index')->name('tracuu');
            Route::get('/donvi', 'TraCuuController@donvi')->name('tracuu-donvi');
            Route::post('/donvi', 'TraCuuController@donvi')->name('tracuu-donvi');
            Route::get('/hocvien', 'TraCuuController@hocvien')->name('tracuu-hocvien');
            Route::post('/hocvien', 'TraCuuController@hocvien')->name('tracuu-hocvien');
        });

        Route::group(['prefix' => 'teacher'], function () {
            Route::get('/', 'TeacherController@index')->name('teacher-index');
            Route::get('/add', 'TeacherController@add')->name('teacher-add');
            Route::post('/add', 'TeacherController@add')->name('teacher-add');
            Route::get('/update', 'TeacherController@edit')->name('teacher-update');
            Route::post('/update', 'TeacherController@update')->name('teacher-update');
            Route::post('/remove', 'TeacherController@remove')->name('teacher-remove');
            Route::post('/add-to-class', 'TeacherController@addTeacherToClass')->name('add-to-class');

        });

        Route::group(['prefix' => 'class'], function () {
            Route::get('/', 'ClassController@index')->name('class-index');
            Route::get('/capnhathocvien', 'ClassController@xeploaihv')->name('class-capnhathocvien');
            Route::post('/capnhathocvien', 'ClassController@capnhathocvien')->name('class-capnhathocvien');
            Route::get('/danhsach', 'ClassController@danhsach')->name('class-danhsach');
            Route::get('/edit', 'ClassController@edit')->name('class-edit');
            Route::post('/edit', 'ClassController@update')->name('class-edit');
            Route::post('/remove', 'ClassController@remove')->name('class-remove');
        });

        Route::group(['prefix' => 'baocao'], function () {
            Route::get('/tonghop', 'ReportController@tonghop')->name('baocao-tonghop');
            Route::get('/download_tonghop', 'ReportController@downloadTonghop')->name('download-tonghop');
        });

        Route::group(['prefix' => 'user'], function () {
            Route::get('/', 'UserController@index')->name('user-index');
            Route::get('/updaterole', 'UserController@update')->name('user-update-role');
            Route::post('/updaterole', 'UserController@update')->name('user-update-role');
            Route::get('/role', 'UserController@roles')->name('role-index');
            Route::get('/assignrole', 'UserController@assignRole')->name('role-assign');
            Route::post('/assignrole', 'UserController@submitRole')->name('role-assign');
            Route::get('/createrole', 'UserController@createRole')->name('role-create');
            Route::post('/createrole', 'UserController@createRole')->name('role-create');
            Route::post('/deleterole', 'UserController@deleteRole')->name('role-delete');
            Route::get('/add', 'UserController@add')->name('user-add');
            Route::post('/add', 'UserController@add')->name('user-add');
            Route::get('/update', 'UserController@updateuser')->name('user-update');
            Route::post('/update', 'UserController@updateuser')->name('user-update');
            Route::post('/delete', 'UserController@deleteUser')->name('user-remove');
        });
        Route::group(['prefix' => 'donvi'], function () {
            Route::get('/', 'DonviController@index')->name('donvi-index');
            Route::get('/update', 'DonviController@update')->name('donvi-update');
            Route::post('/update', 'DonviController@update')->name('donvi-update');
            Route::get('/add', 'DonviController@add')->name('donvi-add');
            Route::post('/add', 'DonviController@add')->name('donvi-add');
            Route::post('/remove', 'DonviController@remove')->name('donvi-remove');
        });
    });
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
