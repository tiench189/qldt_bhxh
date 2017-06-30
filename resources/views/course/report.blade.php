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
            <th class="stt">Số lượng Học Viên</th>
            <th class="stt">Thời gian học</th>
            <th class="stt">Kết quả</th>
            <th class="stt">Ghi chú</th>
        </tr>
        </thead>
        <tbody>
        @foreach($row as $course_id=>$r)
            <tr>
                <td> {{ $course_id }}</td>
                <td> {{ $coursearray[$course_id]->shortname }}</td>
                <td> {{ $r['doi_tuong']  }} </td>
                <td> {{ $r['so_lop']  }} </td>
                <td> </td>
                <td> </td>
                <td> </td>
                <td> </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    @endforeach
@stop
