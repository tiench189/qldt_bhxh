@extends('layout')

@section('page-title')
    Quản lý Khóa Học
@stop
@section('content')
    @if (Session::has('message'))
        <div class="alert alert-info">{!!  Session::get('message') !!}</div>
    @endif
    <div class="page-title">Danh sách Khóa đào tạo</div>
    <table id="table" class="table table-bordered table-hover" data-export="[0,1,2]">
        <thead>
        <tr>

            <th class="stt">#</th>
            <th style="min-width: 300px">Tên khóa đào tạo</th>
            <th>Tổng quan</th>
            <th></th>
            <th></th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach ($course as $idx => $row)
            <tr>
                <td> {{$idx + 1}} </td>
                <td><strong> {{$row->fullname}} </strong></td>
                <td> {!! $row->summary !!} </td>
                <td>
                    <a href="{{route('course-update', ['id' => $row->id])}}" class="btn btn-xs btn-info">
                        Cập nhật
                    </a>
                </td>
                <td>
                    <a href="{{route('course-classes', ['c' => $row->id])}}" class="btn btn-xs btn-info">
                        DS Lớp học
                    </a>
                </td>
                <td>
                    <a href="{{route('course-result', ['c' => $row->id])}}" class="btn btn-xs btn-info">
                        DS Học viên
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@stop