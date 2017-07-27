@extends('layout')

@section('page-title')
    Quản lý đào tạo
@stop

@section('content')
    <div class="page-title">Kết quả đào tạo: <strong>{{$course->fullname}}</strong></div>

    <table class="table table-bordered">
        <thead>
        <tr>
            <th class="stt">#</th>
            <th>Họ tên</th>
            <th>Email</th>
            <th>Điểm</th>
            <th>Xếp loại</th>
            <th>Ngày hoàn thành</th>
        </tr>
        </thead>
        <tbody>
        @foreach($allResult as $idx=>$row)
        <tr>
            <td>{{$idx}}</td>
            <td>{{$users[$row->user_id]->firstname}} {{$users[$row->user_id]->lastname}}</td>
            <td>{{$users[$row->user_id]->email}}</td>
            <td>{{$row->grade}}</td>
            <td>{{$xeploai[$row->xeploai]->name}}</td>
            <td>{{\app\Utils::formatTimestamp($row->complete_at)}}</td>
        </tr>
        @endforeach
        </tbody>
    </table>
@stop
