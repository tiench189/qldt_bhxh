@extends('layout')

@section('page-title')
    Quản lý tài khoản
@stop

@section('content')
    <div class="page-title">Quản lý tài khoản</div>
    @if (Session::has('message'))
        <div class="alert alert-info">{!!  Session::get('message') !!}</div>
    @endif
    <table id="table" class="table table-bordered">
        <thead>
        <tr>
            <th class="stt">#</th>
            <th>Email<br><input type="text"></th>
            <th>Họ tên<br><input type="text"></th>
            <th>Đơn vị<br><input type="text"></th>
            <th>Nhóm quyền<br>
                <select>
                    <option></option>
                    @foreach($groups as $g)
                        <option value="{{$g->name}}">{{$g->name}}</option>
                    @endforeach
                </select>
            </th>
            @if(\App\Roles::checkRole('user-update-role'))
                <th class="action"></th>
            @endif
        </tr>

        </thead>
        <tbody>
        @foreach($users as $idx => $row)
            <tr>
                <td>{{$idx + 1}}</td>
                <td>{{$row->email}}</td>
                <td>{{$row->firstname}} {{$row->lastname}}</td>
                <td>{{$row->ten_donvi}}</td>
                <td>{{$row->group_name}}</td>
                @if(\App\Roles::checkRole('user-update-role'))
                    <td>
                        <a href="{{route('user-update-role', ['uid' => $row->id])}}" class="btn btn-xs btn-primary">Cập
                            nhật
                            nhóm quyền</a>
                    </td>
                @endif
            </tr>
        @endforeach
        </tbody>
    </table>
@stop