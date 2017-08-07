@extends('layout')

@section('page-title')
    Danh sách giảng viên
@stop

@section('content')
    <div class="breadcrumbs">
        {!! Breadcrumbs::render('giangvien', 'Danh sách Giảng viên') !!}
    </div>
    @if (Session::has('message'))
        <div class="alert alert-info">{!!  Session::get('message') !!}</div>
    @endif

    @if(\App\Roles::checkRole('teacher-add'))
        <a class="btn btn-primary btn-add" href="{{route('teacher-add')}}">Thêm mới</a>
    @endif

    {!! Form::open(array('route' => 'teacher-remove', 'class' => 'form', 'id' => 'frmteacherremove')) !!}
    {{ Form::hidden('uid', 0, array('id' => 'teacherid')) }}
    {!! Form::close() !!}
    <script language="javascript">
        function removeTeacher(uid) {
            if (confirm("Bạn có muốn xóa giảng viên này?")) {
                document.getElementById("teacherid").value = uid;
                frmteacherremove.submit();
            }
        }
    </script>

    <table id="table" class="table table-bordered table-hover">
        <thead>
        <tr>

            <th width="20">#</th>
            <th>Tên giáo viên <br><input type="text"></th>
            <th>Đơn vị <br><input type="text"></th>
            <th>Chức danh <br><input type="text"></th>
            <th>Vị trí công tác <br><input type="text"></th>
            <th>Học hàm <br><input type="text"></th>
            <th>Chuyên ngành <br><input type="text"></th>
            @if(\App\Roles::checkRole('teacher-update'))
                <th class="action"></th>
            @endif
            @if(\App\Roles::checkRole('teacher-remove'))
                <th class="action"></th>
            @endif
        </tr>
        </thead>
        <tbody>
        @foreach ($teachers as $row)
            <tr>
                <td> {{$row->id}} </td>
                <td><strong>{{$row->lastname}} {{$row->firstname}}</strong></td>
                <td>{{$row->getDonvi->ten_donvi}}</td>
                <td>{{$row->chucdanh}}</td>
                <td>{{$row->chucvu}}</td>
                <td>{{$row->getGiangVien->hoc_ham or ''}}</td>
                <td>{{$row->getGiangVien->chuyen_nganh or ''}}</td>
                @if(\App\Roles::checkRole('teacher-update'))
                    <td><a href="{{route('teacher-update', ['uid' => $row->id])}}" class="btn btn-xs btn-primary">
                            Cập nhật</a>
                    </td>
                @endif
                @if(\App\Roles::checkRole('teacher-remove'))
                    <td><a href="javascript:removeTeacher({{$row->id}})" class="btn btn-xs btn-danger">
                            Xóa</a>
                    </td>
                @endif
            </tr>
        @endforeach
        </tbody>
    </table>
@stop
