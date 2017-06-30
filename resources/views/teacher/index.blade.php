@extends('layout')

@section('page-title')
    Danh sách giảng viên
@stop

@section('content')
    <div class="page-title">Danh sách giảng viên</div>
    <table id="table" class="table table-bordered table-hover">
        <thead>
        <tr>

            <th width="20"># </th>
            <th width="15%">Tên giáo viên</th>
            <th width="15%">Tên đầy đủ </th>
            <th>Mô Tả </th>
            <th>Email </th>
            <th width="10%">
            </th>
        </tr>
        </thead>
        <tbody>
        @foreach ($teachers as $row)
            <tr>
                <td> {{$row->id}} </td>
                <td> <strong>{{$row->username}}</strong> </td>
                <td> {{$row->lastname}} {{$row->firstname}} </td>
                <td> {!! $row->description !!}</td>
                <td>  {{$row->email}} </td>
                <td>
                    <a href="{{route('teacher-update', ['id' => $row->id])}}" title="Chỉnh sửa khóa đào tạo" class="btn btn-xs btn-info">
                        Cập nhật
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@stop
