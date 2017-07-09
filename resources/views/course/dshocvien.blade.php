@extends('layout')

@section('page-title')
    Danh sách học viên của lớp
@stop

@section('content')
    <div class="page-title">Danh sách học viên của một lớp</div>
    <table id="table" class="table table-bordered table-hover">
        <thead>
        <tr>

            <th width="20"># </th>
            <th width="15%">Tên đăng nhập</th>
            <th width="15%">Họ tên</th>
            <th>Email</th>
            <th> Mô tả </th>
            <th width="10%">
            </th>
        </tr>
        </thead>
        <tbody>
        @foreach ($users as $row)
            <tr>
                <td> {{$row->id}} </td>
                <td> <strong>{{$row->username}}</strong> </td>
                <td> {{$row->lastname}} {{$row->firstname}} </td>
                <td>  {{$row->email}} </td>
                <td> {{$row->description}} </td>
                <td>
                    <a href="{{route('class-capnhathocvien')}}" title="Chỉnh sửa" class="btn btn-xs btn-primary">
                        Cập nhật
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@stop

