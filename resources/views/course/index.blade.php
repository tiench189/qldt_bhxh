@extends('layout')

@section('page-title')
    Quản lý Khóa Học
@stop

@section('content')
    <div class="page-title">Danh sách Khóa đào tạo</div>
    <table id="table" class="table table-bordered table-hover">
        <thead>
        <tr>
            <th>#</th>
            <th>Tên khóa học</th>
            <th>Tên khóa học (đầy đủ)</th>
            <th>Mô Tả</th>
            <th>Ngày kết thúc</th>
            <th>Ngày tạo / Ngày sửa</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach ($course as $row)
            <tr>
                <td> {{$row->id}} </td>
                <td> {{$row->shortname}} </td>
                <td> {{$row->fullname}} </td>
                <td> {{$row->summary}} </td>
                <td> {{\App\Utils::toTimeFormat($row->enddate)}} </td>
                <td>  {{\App\Utils::toTimeFormat($row->timecreated)}}
                    <br/> {{\App\Utils::toTimeFormat($row->timemodified)}} </td>
                {{--                    <td> {{ link_to_action('CourseController@edit', $title = "edit", $parameters = ['id'=>$row->id], $attributes = []) }}</td>--}}
                <td>
                    <a href="{{env('ALIAS')}}/course/update?id={{$row->id}}" title="Chỉnh sửa khóa đào tạo">
                        <div class="ico-action edit"></div>
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@stop
