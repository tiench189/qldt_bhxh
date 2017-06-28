@extends('layout')

@section('page-title')
    Quản lý đào tạo
@stop

@section('content')
    @foreach($rs as $year=>$row)
    <div class="page-title">Năm {{ $year  }}</div>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th class="stt">#</th>
            <th class="stt">Tên khóa học</th>
            <th class="stt">Đối tượng Đào Tạo</th>
            <th class="stt">Số lớp</th>
            <th class="stt"></th>
        </tr>
        </thead>
        <tbody>
        @foreach($row as $course_id=>$so_lop)
            <tr>
                <td> {{ $course_id }}</td>
                <td> {{ $coursearray[$course_id]->shortname }}</td>
                <td>  </td>
                <td> {{ $so_lop  }} </td>
                <td> </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    @endforeach
@stop
