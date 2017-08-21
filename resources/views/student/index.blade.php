@extends('layout')

@section('page-title')
    Quản lý Học Viên
@stop

@section('content')

    <div class="breadcrumbs">
        {!! Breadcrumbs::render('hocvien',$infodonvi) !!}
    </div>
    {!! Form::open(array('route' => 'hocvien-remove', 'class' => 'form', 'id' => 'frmstudentremove')) !!}
    {{ Form::hidden('uid', 0, array('id' => 'studentid')) }}
    {!! Form::close() !!}
    <script language="javascript">
        function removeStudent(uid) {
            if (confirm("Bạn có muốn xóa học viên này?")) {
                document.getElementById("studentid").value = uid;
                frmstudentremove.submit();
            }
        }
    </script>

    @if (Session::has('message'))
        <div class="alert alert-info">{!!  Session::get('message') !!}</div>
    @endif
    @if(\App\Roles::checkRole('hocvien-add'))
        <a class="btn btn-primary btn-add" href="{{route('hocvien-add')}}">Thêm mới</a>
    @endif
    <table id="table" class="table table-bordered table-hover" data-export="[0,1,2,3,4,5,6]">
        <thead>
        <tr>
            <th class="stt">#</th>
            <th>Họ tên<br><input type="text"></th>
            <th>Email<br><input type="text"></th>
            <th>Đơn vị<br><input type="text"> </th>
            <th>Ngày sinh<br><input type="text"></th>
            <th>Giới tính<br>
                <select>
                    <option></option>
                    <option value="nam">Nam</option>
                    <option value="nữ">Nữ</option>
                </select>
            </th>
            <th>Chức danh<br><input type="text"></th>
            <th>Vị trí công tác<br><input type="text"></th>
            @if(\App\Roles::checkRole('hocvien-update'))
                <th class="action"></th>
            @endif
            @if(\App\Roles::checkRole('hocvien-remove'))
                <th class="action"></th>
            @endif
        </tr>
        </thead>
        <tbody>
        @foreach ($users as $idx=>$row)
            <tr>
                <td>{{$idx + 1}}</td>
                <td><a href="@if(\App\Roles::checkRole('hocvien-histories')) {{route('hocvien-histories', ['u' => $row->id])}} @endif">
                        {{$row->firstname}} {{$row->lastname}} </a>
                </td>
                <td> {{$row->email}} </td>
                <td>

                    <a href="{{route('hocvien-index', ['donvi' => $row->donvi])}}">
                        {{array_key_exists($row->donvi, $donvi)?$donvi[$row->donvi]->ten_donvi:''}}
                    </a>
                </td>
                <td>{{\App\Utils::toTimeFormat($row->birthday)}}</td>
                <td>{{\App\Utils::formatSex($row->sex)}}</td>
                <td>{{$row->chucdanh}}</td>
                <td>{{$row->chucvu}}</td>
                @if(\App\Roles::checkRole('hocvien-update'))
                    <td><a href="{{route('hocvien-update', ['uid' => $row->id])}}" class="btn btn-xs btn-primary {{$row->auth == 'cas'?'disabled':''}}">
                            Cập nhật</a>
                    </td>
                @endif
                @if(\App\Roles::checkRole('hocvien-remove'))
                    <td><a href="javascript:removeStudent({{$row->id}})" class="btn btn-xs btn-danger {{$row->auth == 'cas'?'disabled':''}}">
                            Xóa</a>
                    </td>
                @endif
            </tr>
        @endforeach
        </tbody>
    </table>
@stop
