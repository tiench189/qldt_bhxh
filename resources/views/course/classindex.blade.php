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
    <div class="breadcrumbs">
        {!! Breadcrumbs::render('course-class',$category,$course,$class) !!}
    </div>

    @if (Session::has('message'))
        <div class="alert alert-info">{!!  Session::get('message') !!}</div>
    @endif

    @if(\App\Roles::checkRole('class-edit'))
        <a class="btn btn-primary btn-add" href="{{route('class-edit', ['cid' => $course->id])}}" style="margin-bottom: 10px">Thêm mới</a>
        <button type="button" class="btn btn-warning" data-target="#modalTeacher" data-toggle="modal"
                style="margin-bottom: 10px; position: absolute;margin-left: 100px;">
            Thêm giảng viên
        </button>
    @endif

    <div id="modalTeacher" class="modal fade" role="dialog">
        <div class="modal-dialog" style="margin-top: 150px">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">
                        Thêm giảng viên
                    </h4>
                </div>
                {!! Form::open(array('route' => 'add-to-class', 'class' => 'form','id' => 'frmaddteacher')) !!}
                <input type="hidden" value="{{$course->id}}" name="course_id">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Lớp: <span class="required">(*)</span></label>
                        <select class="form-control" name="lop_id" required>
                            @foreach($class as $item)
                                <option value="{{$item->id}}">{{$item->ten_lop}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="bold">Giảng viên (*)</label>
                        <select class="form-control" name="giangvien_id" required>
                            @foreach($teachers as $teacher_item)
                                <option value="{{$teacher_item->id}}">{{trim($teacher_item->firstname)}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    {!! Form::submit('Hoàn tất', ['class' => 'btn btn-primary']) !!}
                    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                </div>
                {!! Form::close() !!}
            </div>

        </div>
    </div>

    <table id="table" class="table table-bordered table-hover" data-export="[0,1,2,3,4,5]">
        <thead>
        <tr>
            <th width="20">#</th>
            <th width="25%">Tên lớp<br><input type="text"></th>
            <th>Bắt đầu<br><input type="text"></th>
            <th>Kết thúc<br><input type="text"></th>
            <th>Học viên<br><input type="text"></th>
            <th>Giảng viên<br><input type="text"></th>
            @if(\App\Roles::checkRole('class-edit'))
                <th width="10"></th>
            @endif
            @if(\App\Roles::checkRole('class-remove'))
                <th width="10"></th>
            @endif
        </tr>
        </thead>
        <tbody>
        @foreach ($class as $idx => $row)
            <tr>
                <td> {{$idx + 1}}</td>
                <td>
                    @if(\App\Roles::checkRole('course-result'))
                        <a href="{{route('course-result', ['class' => $row->id])}}">
                            {{$row->ten_lop}}
                        </a>
                    @else
                        {{$row->ten_lop}}
                    @endif
                </td>
                <td>{{\App\Utils::toTimeFormat($row->time_start)}} </td>
                <td>{{\App\Utils::toTimeFormat($row->time_end)}} </td>
                <td>{{ $hocvien[$row->id] or 0 }}</td>
                <td width="25">
                    <a href="{{route('teacher-class-list', ['class_id' => $row->id])}}" class="btn btn-xs btn-primary">
                        DS Giảng viên
                    </a>
                </td>
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
                           class="btn btn-xs btn-danger">Xóa</a>
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