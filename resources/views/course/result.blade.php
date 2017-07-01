@extends('layout')

@section('page-title')
    @if($courseID != 0 && $classID == 0)
        Danh sách học viên {{$course->fullname}}
    @else
        Danh sách học viên {{$class->ten_lop}} - {{$course->fullname}}
    @endif
@stop

@section('content')
    <div class="page-title">
        @if($courseID != 0)
            Danh sách học viên: <strong>{{$course->fullname}}</strong>
        @else
            Danh sách học viên: <strong>{{$class->ten_lop}}</strong> - <strong>{{$course->fullname}}</strong>
        @endif
    </div>
    <table class="table table-bordered" id="table" data-export="[0,1,2,3,4,5,6,7,8]">
        <thead>
        <tr>
            <th class="stt">#</th>
            <th>Họ tên</th>
            <th>Email</th>
            <th class="{{$classID == 0?'':'hidden'}}">Lớp</th>
            <th>Đơn vị</th>
            <th>Trạng thái</th>
            <th>Điểm</th>
            <th>Xếp loại</th>
            <th>Ngày hoàn thành</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach($allResult as $idx=>$row)
            <tr>
                <td>{{$idx + 1}}</td>
                <td>{{$users[$row->user_id]->firstname}} {{$users[$row->user_id]->lastname}}</td>
                <td>{{$users[$row->user_id]->email}}</td>
                <td class="{{$classID == 0?'':'hidden'}}">{{$row->ten_lop}}</td>
                <td>{{array_key_exists($users[$row->user_id]->donvi, $donvi)?$donvi[$users[$row->user_id]->donvi]->ten_donvi:''}}</td>
                <td>{{\app\Utils::getStatus($row->status)}}</td>
                <td>{{$row->grade}}</td>
                <td>{{$xeploai[$row->xeploai]->name}}</td>
                <td>{{\app\Utils::formatTimestamp($row->complete_at)}}</td>
                <td>
                    <a href="#" class="btn btn-xs btn-info">Xóa</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@stop
