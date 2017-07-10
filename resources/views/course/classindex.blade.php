@extends('layout')

@section('page-title')
    Danh sách lớp học | {{ $course->fullname }}
@stop
@section('content')
    {!! Form::open(array('route' => 'class-remove', 'class' => 'form', 'id' => 'frmClassDelete')) !!}
    {{ Form::hidden('id', 0, array('id' => 'id')) }}
    {{ Form::hidden('courseId', 0, array('id' => 'courseId')) }}
    {!! Form::close() !!}

    <script language="javascript">
        function xoalophoc(id, courseId) {
            if (confirm("Bạn có muốn xóa?")) {
                document.getElementById("id").value = id;
                document.getElementById("courseId").value = courseId;
                frmClassDelete.submit();
            }
        }
    </script>
    @if (Session::has('message'))
        <div class="alert alert-info">{!!  Session::get('message') !!}</div>
    @endif

    <div class="page-title">Danh sách lớp <strong>{{ $course->fullname }}</strong></div>
    @if(\App\Roles::checkRole('class-edit'))
        <a class="btn btn-primary btn-add" href="{{route('class-edit', ['cid' => $course->id])}}" style="margin-bottom: 10px">Thêm
            mới</a>
    @endif
    <table id="table" class="table table-bordered table-hover" data-export="[0,1,2,3,4,5]">
        <thead>
        <tr>
            <th width="20">#</th>
            <th width="25%">Tên lớp<br><input type="text"></th>
            <th>Thời Gian Bắt đầu<br><input type="text"></th>
            <th>Thời Gian Kết Thúc<br><input type="text"></th>
            <th>Số lượng học viên<br><input type="text"></th>
            {{--<th></th>--}}
            @if(\App\Roles::checkRole('course-result'))
                <th></th>
            @endif
            @if(\App\Roles::checkRole('class-edit'))
                <th></th>
            @endif
            @if(\App\Roles::checkRole('class-remove'))
                <th></th>
            @endif
        </tr>
        </thead>
        <tbody>
        @foreach ($class as $idx => $row)
            <tr>
                <td> {{$idx + 1}}</td>
                <td> {{$row->ten_lop}} </td>
                <td> {{\App\Utils::toTimeFormat($row->time_start)}} </td>
                <td> {{\App\Utils::toTimeFormat($row->time_end)}} </td>
                <td>
                    @isset($hocvien[$row->id])
                        {{ $hocvien[$row->id] }}
                    @endisset
                    @empty($hocvien[$row->id])
                        0
                    @endempty
                </td>
                {{--<td>--}}
                {{--<a href="{{route('class-danhsach', ['cid' => $row->id])}}" class="btn btn-xs btn-primary">--}}
                {{--DS Giáo Viên--}}
                {{--</a>--}}
                {{--</td>--}}
                @if(\App\Roles::checkRole('course-result'))
                    <td>
                        <a href="{{route('course-result', ['class' => $row->id])}}" class="btn btn-xs btn-primary">
                            DS Học Viên
                        </a>
                    </td>
                @endif
                @if(\App\Roles::checkRole('class-edit'))
                    <td>
                        <a href="{{route('class-edit', ['cid' => $course->id, 'id' => $row->id])}}"
                           class="btn btn-xs btn-primary">
                            Cập nhật
                        </a>
                    </td>
                @endif
                @if(\App\Roles::checkRole('class-remove'))
                    <td>
                        <a href="javascript:void(0)"
                           onclick="xoalophoc({{$row->id}}, {{$row->course_id}})"
                           class="btn btn-xs btn-primary">Xóa</a>
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