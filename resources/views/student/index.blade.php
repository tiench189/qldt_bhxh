@extends('layout')

@section('page-title')
    Quản lý Học Viên
@stop

@section('content')
    <div class="page-title">Danh sách học viên</div>
    <table id="table" class="table table-bordered table-hover">
        <thead>
        <tr>
            <th class="stt">#</th>
            <th>Họ tên</th>
            <th>Email</th>
            <th>Đơn vị</th>
            <th>Ngày sinh</th>
            <th>Giới tính</th>
            <th>Chức danh</th>
            <th class="action"></th>
        </tr>
        </thead>
        <tbody>
        @foreach ($users as $idx=>$row)
            <tr>
                <td>{{$idx + 1}}</td>
                <td> {{$row->firstname}} {{$row->lastname}} </td>
                <td> {{$row->email}} </td>
                <td> {{$donvi[$row->donvi]->ten_donvi}} </td>
                <td></td>
                <td></td>
                <td></td>
                <td><a href="{{env('ALIAS')}}/hocvien/histories?u={{$row->id}}" title="Lịch sử đào tạo">
                        <div class="ico-action history"></div></a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@stop
