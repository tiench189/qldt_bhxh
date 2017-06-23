@extends('layout')

@section('page-title')
    Quản lý Khóa Học
@stop

@section('content')
    <div class="col-lg-12">
    <h1>Danh sách Khóa Học</h1>


    <table id="table" class="table table-bordered table-hover">
        <thead>
        <tr>
            <th>#
            </th>
            <th>Tên khóa học
            </th>
            <th>Tên khóa học (đầy đủ)
            </th>
            <th>Mô Tả
            </th>
            <th>Hiển thị
            </th>
            <th>Ngày kết thúc
            </th>
            <th>Ngày tạo / Ngày sửa
            </th>
            <th>
            </th>
        </tr>
        </thead>
        <tbody>
        @foreach ($course as $row)
            <tr>
                <td> {{$row->id}} </td>
                <td> {{$row->shortname}} </td>
                <td> {{$row->fullname}} </td>
                <td> {{$row->summary}} </td>
                <td> {{$row->visible}} </td>
                <td> {{$row->enddate}} </td>
                <td> {{$row->timecreated}} / {{$row->timemodified}} </td>
                <td> {{ link_to_action('CourseController@edit', $title = "edit", $parameters = ['id'=>$row->id], $attributes = []) }} / </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    </div>
@stop
