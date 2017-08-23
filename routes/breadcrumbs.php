<?php

// Home
Breadcrumbs::register('index', function ($breadcrumbs = [], $catinfo = []) {
    $breadcrumbs->push('Nội dung đào tạo', route('index'));

    if (!empty($catinfo)) {
        $breadcrumbs->push($catinfo->name, route('index', ["c" => $catinfo->id]));
        $breadcrumbs->push('Danh sách');
    }
});

//Category
Breadcrumbs::register('category', function ($breadcrumbs, $sub = '') {
    $breadcrumbs->push('Nội dung đào tạo', route('index'));
    $breadcrumbs->push($sub);
});

// Index > Course
Breadcrumbs::register('course', function ($breadcrumbs, $nddt = [], $category = []) {
    if (!empty($nddt))
        $breadcrumbs->push($nddt->name, route('index', ["c" => $nddt->id]));
    else
        $breadcrumbs->push('Danh sách khóa Đào tạo', route('course-index'));

    if (!empty($category)) $breadcrumbs->push($category->name, route('course-index', ["c" => $category->id]));

    $breadcrumbs->push('Danh sách khóa học');
});


// Index > Class
Breadcrumbs::register('course-class', function ($breadcrumbs, $category, $course, $class) {
    if (!empty($category))
        $breadcrumbs->push($category->name, route('course-index', ["c" => $category->id]));

    if (!empty($course))
        $breadcrumbs->push($course->fullname, route('course-classes', ["c" => $course->id]));
    $breadcrumbs->push("Danh sách lớp");
});


// Index > Hoc Vien
Breadcrumbs::register('course-result', function ($breadcrumbs, $category = [], $course = [], $class = []) {
    if (!empty($category))
        $breadcrumbs->push($category->name, route('course-index', ["c" => $category->id]));

    if (!empty($course))
        $breadcrumbs->push($course->fullname, route('course-classes', ["c" => $course->id]));

    if (!empty($class))
        $breadcrumbs->push($class->ten_lop, route('course-result', ["class" => $class->id]));

    $breadcrumbs->push("Kết quả đào tạo");
});

Breadcrumbs::register('class-list-teacher', function ($breadcrumbs, $course = [], $class = []) {
    if (!empty($course))
        $breadcrumbs->push($course->fullname, route('course-classes', ["c" => $course->id]));

    if (!empty($class))
        $breadcrumbs->push($class->ten_lop, route('course-result', ["class" => $class->id]));

    $breadcrumbs->push("Danh sách Giảng viên");
});


// Index > Hoc Vien
Breadcrumbs::register('hocvien', function ($breadcrumbs, $text = "", $student = []) {
    $breadcrumbs->push("Học viên", route('hocvien-index'));

    if (!empty($student)) {
        $breadcrumbs->push($text);

        $breadcrumbs->push($student->firstname . " " . $student->lastname);
    } else {
        $breadcrumbs->push("Danh Sách Học viên");
    }
});

//Giang vien Profile
Breadcrumbs::register('giang-vien-profile', function ($breadcrumbs, $teacher, $class = []) {
    if (!empty($class)) {
        $breadcrumbs->push($class->ten_lop, route('course-result', ["class" => $class->id]));
        $breadcrumbs->push('Danh sách Giảng viên', route('teacher-class-list', ['class_id' => $class->id]));
    } else {
        $breadcrumbs->push('Danh sách Giảng viên', route('teacher-index'));
    }

    $breadcrumbs->push($teacher->firstname);
    $breadcrumbs->push('Thông tin');
});

// Index > Giang Vien
Breadcrumbs::register('giangvien', function ($breadcrumbs, $text = "", $teacher = []) {
    $breadcrumbs->push("Giảng viên", route('teacher-index'));

    $breadcrumbs->push($text);

    if (!empty($teacher)) {
        $breadcrumbs->push($teacher->firstname . " " . $teacher->lastname);
    }
});

// Index > Báo cáo
Breadcrumbs::register('baocao', function ($breadcrumbs) {
    $breadcrumbs->push("Báo cáo", route('baocao-tonghop'));
});

// Index > Tra Cứu
Breadcrumbs::register('tracuu', function ($breadcrumbs) {
    $breadcrumbs->push("Tra Cứu", route('tracuu'));
});
