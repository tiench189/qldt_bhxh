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
            <th width="20">#
            </th>
            <th width="15%">Tên khóa học
            </th>
            <th width="15%">Tên khóa học (đầy đủ)
            </th>
            <th>Mô Tả
            </th>
            <th>Hiển thị
            </th>
            <th width="10%">Ngày kết thúc
            </th>
            <th width="10%">Ngày tạo / Ngày sửa
            </th>
            <th width="10%">
            </th>
        </tr>
        </thead>
        <tbody>
        @foreach ($course as $row)
            <tr>
                <td> {{$row->id}} </td>
                <td> {{$row->shortname}} </td>
                <td> {{$row->fullname}} </td>
                <td> {!! $row->summary !!} </td>
                <td> {{$row->visible}} </td>
                <td> {{\App\Utils::toTimeFormat($row->enddate)}} </td>
                <td> {{\App\Utils::toTimeFormat($row->timecreated)}} <br /> {{\App\Utils::toTimeFormat($row->timemodified)}} </td>
                <td> {{ link_to_action('CourseController@edit', $title = "edit", $parameters = ['id'=>$row->id], $attributes = ['class'=>'btn btn-sm btn-primary']) }} </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    </div>
@stop
