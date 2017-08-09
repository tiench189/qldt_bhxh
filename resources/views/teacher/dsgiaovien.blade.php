@extends('layout')

@section('page-title')
    Danh sách giảng viên
@stop

@section('content')
    <div class="breadcrumbs">
        {!! Breadcrumbs::render('class-list-teacher',$course,$class) !!}
    </div>

    @if (Session::has('message'))
        <div class="alert alert-info">{!!  Session::get('message') !!}</div>
    @endif

    @if(\App\Roles::checkRole('class-edit'))
        <button type="button" class="btn btn-primary btn-add" data-target="#modalTeacher" data-toggle="modal">
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
                <input type="hidden" value="{{$class->id}}" name="lop_id">
                <input type="hidden" value="teacher-class-list" name="from">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Lớp: <span class="required">(*)</span></label>
                        <input type="text" value="{{$class->ten_lop}}" class="form-control" readonly>
                    </div>

                    <div class="form-group">
                        <label class="bold">Giảng viên (*)</label>
                        <select class="form-control" name="giangvien_id" required>
                            @foreach($raw_teachers as $teacher_item)
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

    {!! Form::open(array('route' => 'teacher-remove', 'class' => 'form', 'id' => 'frmteacherremove')) !!}
    {{ Form::hidden('uid', 0, array('id' => 'teacherid')) }}
    {{ Form::hidden('class_id', 0, array('id' => 'class_id', 'value' => $class->id)) }}
    {!! Form::close() !!}
    <script language="javascript">
        function removeTeacher(uid) {
            if (confirm("Bạn có muốn xóa giảng viên này?")) {
                document.getElementById("teacherid").value = uid;
                frmteacherremove.submit();
            }
        }
    </script>

    <table id="table" class="table table-bordered table-hover" data-export="[0,1,2,3,4,5,6]">
        <thead>
        <tr>

            <th width="20">#</th>
            <th>Tên giáo viên <br><input type="text"></th>
            <th>Đơn vị <br><input type="text"></th>
            <th>Chức danh <br><input type="text"></th>
            <th>Vị trí công tác <br><input type="text"></th>
            <th>Học hàm <br><input type="text"></th>
            <th>Chuyên ngành <br><input type="text"></th>
            @if(\App\Roles::checkRole('teacher-remove'))
                <th class="action"></th>
            @endif
        </tr>
        </thead>
        <tbody>
        @foreach ($teachers as $row)
            <tr>
                <td> {{$row->pivot->giangvien_id}} </td>
                <td><strong>{{$row->lastname}} {{$row->firstname}}</strong></td>
                <td>{{$row->getDonvi->ten_donvi}}</td>
                <td>{{$row->chucdanh}}</td>
                <td>{{$row->chucvu}}</td>
                <td>{{$row->getGiangVien->hoc_ham or ''}}</td>
                <td>{{$row->getGiangVien->chuyen_nganh or ''}}</td>
                @if(\App\Roles::checkRole('teacher-remove'))
                    <td><a href="javascript:removeTeacher({{$row->pivot->giangvien_id}})" class="btn btn-xs btn-danger">
                            Xóa</a>
                    </td>
                @endif
            </tr>
        @endforeach
        </tbody>
    </table>
@stop
