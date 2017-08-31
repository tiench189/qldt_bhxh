@extends('layout')

@section('page-title')
    Quản lý tài khoản
@stop

@section('content')
    {!! Form::open(array('route' => 'user-remove', 'class' => 'form', 'id' => 'frmuserremove')) !!}
    {{ Form::hidden('id', 0, array('id' => 'uid')) }}
    {!! Form::close() !!}
    <script language="javascript">
        function removeUser(cid) {
            if (confirm("Bạn có muốn xóa tài khoản này?")) {
                document.getElementById("uid").value = cid;
                frmuserremove.submit();
            }
        }
    </script>
    <div class="page-title">Quản lý tài khoản</div>
    @if (Session::has('message'))
        <div class="alert alert-info">{!!  Session::get('message') !!}</div>
    @endif

    {{--@if(\App\Roles::checkRole('hocvien-add'))--}}
    <a class="btn btn-primary btn-add" href="{{route('user-add')}}">Thêm mới</a>
    {{--@endif--}}
    <table id="table" class="table table-bordered">
        <thead>
        <tr>
            <th class="stt">#</th>
            <th>Tài khoản<br><input type="text"></th>
            <th>Email<br><input type="text"></th>
            <th>Họ tên<br><input type="text"></th>
            <th>Nhóm quyền<br>
                <select>
                    <option></option>
                    @foreach($groups as $g)
                        <option value="{{$g->name}}">{{$g->name}}</option>
                    @endforeach
                </select>
            </th>
            @if(\App\Roles::checkRole('user-update'))
                <th class="action"></th>
            @endif
            @if(\App\Roles::checkRole('user-remove'))
                <th class="action"></th>
            @endif
        </tr>

        </thead>
        <tbody>
        @foreach($users as $idx => $row)
            <tr>
                <td>{{$idx + 1}}</td>
                <td>{{$row->username}}</td>
                <td>{{$row->email}}</td>
                <td>{{$row->firstname}} {{$row->lastname}}</td>
                <td>{{$row->group_name}}</td>
                @if(\App\Roles::checkRole('user-update'))
                    <td>
                        {{--                        <a href="{{route('user-update-role', ['uid' => $row->id])}}" class="btn btn-xs btn-primary">Nhóm quyền</a>--}}
                        <a href="{{route('user-update', ['uid' => $row->id])}}" class="btn btn-xs btn-primary">Cập
                            nhật</a>
                    </td>
                @endif
                @if(\App\Roles::checkRole('user-remove'))
                    <td>
                        <a href="javascript:removeUser({{$row->id}})" class="btn btn-xs btn-danger">
                            Xóa
                        </a>
                    </td>
                @endif
            </tr>
        @endforeach
        </tbody>
    </table>
@stop