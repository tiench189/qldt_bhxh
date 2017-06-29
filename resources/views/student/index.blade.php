@extends('layout')

@section('page-title')
    Quản lý Học Viên
@stop

@section('content')
    <div class="page-title">Danh sách học viên</div>
    <table id="table" class="table table-bordered table-hover" data-export="[0,1,2,3,4,5,6]">
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
                <td> {{array_key_exists($row->donvi, $donvi)?$donvi[$row->donvi]->ten_donvi:''}} </td>
                <td></td>
                <td></td>
                <td></td>
                <td><a href="{{env('ALIAS')}}/hocvien/histories?u={{$row->id}}" class="btn btn-xs btn-info">
                        Lịch sử đào tạo</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@stop
