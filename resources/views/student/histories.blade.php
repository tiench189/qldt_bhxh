@extends('layout')

@section('page-title')
    Lịch sử đào tạo
@stop

@section('content')
    <div class="page-title">Lịch sử đào tạo: <strong>{{$user->firstname}} {{$user->lastname}} ({{$user->email}})</strong></div>
    <table class="table table-bordered" id="table">
        <thead>
        <tr>
            <th class="stt">#</th>
            <th>Khóa học</th>
            <th>Lớp</th>
            <th>Trạng thái</th>
            <th>Điểm</th>
            <th>Xếp loại</th>
            <th>Ngày hoàn thành</th>
        </tr>
        </thead>
        <tbody>
        @foreach($histories as $idx=>$row)
            <tr>
                <td>{{$idx + 1}}</td>
                <td>{{$lop[$row->lop_id]->course_name}}</td>
                <td>{{$lop[$row->lop_id]->ten_lop}}</td>
                <td>{{\app\Utils::getStatus($row->status)}}</td>
                <td>{{$ketqua[$lop[$row->lop_id]->course_id]->grade}}</td>
                <td>{{$xeploai[$ketqua[$lop[$row->lop_id]->course_id]->xeploai]->name}}</td>
                <td>{{\app\Utils::formatTimestamp($ketqua[$lop[$row->lop_id]->course_id]->complete_at)}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@stop
