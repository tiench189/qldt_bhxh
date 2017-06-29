@extends('layout')

@section('page-title')
    Danh sách học viên {{$course->fullname}}
@stop

@section('content')
    <div class="page-title">Danh sách học viên: <strong>{{$course->fullname}}</strong></div>
    <table class="table table-bordered" id="table" data-export="[0,1,2,3,4,5,6]">
        <thead>
        <tr>
            <th class="stt">#</th>
            <th>Họ tên</th>
            <th>Email</th>
            <th>Đơn vị</th>
            <th>Điểm</th>
            <th>Xếp loại</th>
            <th>Ngày hoàn thành</th>
        </tr>
        </thead>
        <tbody>
        @foreach($allResult as $idx=>$row)
            <tr>
                <td>{{$idx + 1}}</td>
                <td>{{$users[$row->user_id]->firstname}} {{$users[$row->user_id]->lastname}}</td>
                <td>{{$users[$row->user_id]->email}}</td>
                <td>{{array_key_exists($users[$row->user_id]->donvi, $donvi)?$donvi[$users[$row->user_id]->donvi]->ten_donvi:''}}</td>
                <td>{{$row->grade}}</td>
                <td>{{$xeploai[$row->xeploai]->name}}</td>
                <td>{{\app\Utils::formatTimestamp($row->complete_at)}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@stop
