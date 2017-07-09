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
            if (confirm("Bạn có muốn xóa khóa đào tạo này?")) {
                document.getElementById("courseid").value = cid;
                frmcourseremove.submit();
            }
        }
    </script>
    @if (Session::has('message'))
        <div class="alert alert-info">{!!  Session::get('message') !!}</div>
    @endif
    <div class="page-title">Danh sách Khóa đào tạo</div>
    @if(\App\Roles::checkRole('course-createCourse'))
        <a class="btn btn-primary btn-add" href="{{route('course-createCourse')}}">Thêm mới</a>
    @endif
    <table id="table" class="table table-bordered table-hover" data-export="[0,1,2]">
        <thead>
        <tr>

            <th class="stt">#</th>
            <th style="min-width: 300px">Tên khóa đào tạo<br><input type="text"></th>
            <th style="width: 120px">Đối tượng đào tạo<br><input type="text"></th>
            <th style="width: 60px">Thời gian<br><input type="text"></th>
            <th>Tổng quan<br><input type="text"></th>
            @if(\App\Roles::checkRole('course-classes'))
                <th class="action"></th>
            @endif
            @if(\App\Roles::checkRole('course-result'))
                <th class="action"></th>
            @endif
            @if(\App\Roles::checkRole('course-update'))
                <th class="action"></th>
            @endif
            @if(\App\Roles::checkRole('course-remove'))
                <th class="action"></th>
            @endif
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
                @if(\App\Roles::checkRole('course-classes'))
                    <td>
                        <a href="{{route('course-classes', ['c' => $row->id])}}" class="btn btn-xs btn-primary">
                            DS Lớp học
                        </a>
                    </td>
                @endif
                @if(\App\Roles::checkRole('course-result'))
                    <td>
                        <a href="{{route('course-result', ['c' => $row->id])}}" class="btn btn-xs btn-primary">
                            DS Học viên
                        </a>
                    </td>
                @endif
                @if(\App\Roles::checkRole('course-update'))
                    <td>
                        <a href="{{route('course-update', ['id' => $row->id])}}" class="btn btn-xs btn-primary">
                            Cập nhật
                        </a>
                    </td>
                @endif
                @if(\App\Roles::checkRole('course-remove'))
                    <td>
                        <a href="javascript:removeCourse({{$row->id}})" class="btn btn-xs btn-primary">
                            Xóa
                        </a>
                    </td>
                @endif
            </tr>
        @endforeach
        </tbody>
    </table>
    <style>
        #table_filter {
            display: none;
        }
    </style>
@stop