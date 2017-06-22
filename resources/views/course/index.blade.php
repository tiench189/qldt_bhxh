@extends('layout')

@section('page-title')
    Quản lý Học Viên
@stop

@section('content')
    <div class="col-lg-12">
    <h1>Danh sách học viên</h1>


    <table id="table" class="table table-bordered table-hover">
        <thead>
        <tr>
            <th>T&ecirc;n đệm v&agrave; t&ecirc;n&nbsp;/&nbsp;Họ
            </th>
            <th>Username
            </th>
            <th>Thư điện tử
            </th>
            <th>Tỉnh/Th&agrave;nh phố
            </th>
            <th>Quốc gia
            </th>
            <th>Truy cập gần nhất
            </th>
            <th>Chỉnh sửa
            </th>
        </tr>
        </thead>
        <tbody>
        @foreach ($users as $row)
            <tr>
                <td> {{$row->firstname}} {{$row->lastname}} </td>
                <td> {{$row->username}} </td>
                <td> {{$row->email}} </td>
                <td> {{$row->city}} </td>
                <td> {{$row->country}} </td>
                <td> {{$row->lastlogin}} </td>
                <td> / </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    </div>
@stop
