<?php

// Home
Breadcrumbs::register('index', function($breadcrumbs,$catinfo)
{
    if(empty($catinfo)) {
        $breadcrumbs->push('Nội dung đào tạo', route('index'));
    } else {
        $breadcrumbs->push('Nội dung đào tạo', route('index'));
        $breadcrumbs->push($catinfo->name);
    }


});

// Index > Course
Breadcrumbs::register('course', function($breadcrumbs,$nddt,$category)
{
    $breadcrumbs->parent('index');
    if(!empty($nddt))
        $breadcrumbs->push($nddt->name, route('index',["c"=>$nddt->id]));
    else
        $breadcrumbs->push('Danh sách khóa Đào tạo', route('course-index'));

    if(!empty($category)) $breadcrumbs->push($category->name);

});