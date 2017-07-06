@extends('layout')

@section('page-title')
    Quản lý Khóa Học
@stop
@section('content')
    {!! Form::open(array('route' => 'course-remove', 'class' => 'form', 'id' => 'frmcourseremove')) !!}
    {{ Form::hidden('cid', 0, array('id' => 'courseid')) }}
    {!! Form::close() !!}
    <script language="javascript">
        function removeCourse(cid) {
            if(confirm("Bạn có muốn xóa khóa đào tạo này?")) {
                document.getElementById("courseid").value = cid;
                frmcourseremove.submit();
            }
        }
    </script>
    @if (Session::has('message'))
        <div class="alert alert-info">{!!  Session::get('message') !!}</div>
    @endif
    <div class="page-title">Danh sách Khóa đào tạo</div>
    <a class="btn btn-info" href="{{route('course-createCourse')}}" style="margin-bottom: 10px">Thêm mới</a>
    <table id="table" class="table table-bordered table-hover" data-export="[0,1,2]">
        <thead>
        <tr>

            <th class="stt">#</th>
            <th style="min-width: 300px">Tên khóa đào tạo</th>
            <th width="120px">Đối tượng đào tạo</th>
            <th width="60px">Thời gian</th>
            <th>Tổng quan</th>
            <th class="action"></th>
            <th class="action"></th>
            <th class="action"></th>
            <th class="action"></th>
        </tr>
        </thead>
        <tbody>
        @foreach ($course as $idx => $row)
            <tr>
                <td> {{$idx + 1}} </td>
                <td><strong> {{$row->fullname}} </strong></td>
                <td>{{$row->doi_tuong}}</td>
                <td>{{$row->thoi_gian}}</td>
                <td> {!! $row->summary !!} </td>
                <td>
                    <a href="{{route('course-classes', ['c' => $row->id])}}" class="btn btn-xs btn-info">
                        DS Lớp học
                    </a>
                </td>
                <td>
                    <a href="{{route('course-result', ['c' => $row->id])}}" class="btn btn-xs btn-info">
                        DS Học viên
                    </a>
                </td>
                <td>
                    <a href="{{route('course-update', ['id' => $row->id])}}" class="btn btn-xs btn-info">
                        Cập nhật
                    </a>
                </td>
                <td>
                    <a href="javascript:removeCourse({{$row->id}})" class="btn btn-xs btn-info">
                        Xóa
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@stop