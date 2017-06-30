@extends('layout')

@section('page-title')
    {{ $course->shortname }} | Danh sách lớp học
@stop
@section('content')
    <div class="page-title">Danh sách lớp {{ $course->shortname }}</div>
    <table id="table" class="table table-bordered table-hover" data-export="[0,1,2,3,4,5]">
        <thead>
        <tr>

            <th width="20">#</th>
            <th width="25%">Tên lớp</th>
            <th>Thời Gian Bắt đầu</th>
            <th>Thời Gian Kết Thúc</th>
            <th>Đối tượng</th>
            <th>Số lượng học viên</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach ($class as $row)
            <tr>
                <td> {{$row->id}}</td>
                <td> {{$row->ten_lop}} </td>
                <td> {{\App\Utils::toTimeFormat($row->time_start)}} </td>
                <td> {{\App\Utils::toTimeFormat($row->time_end)}} </td>
                <td> {{$row->doi_tuong}}  </td>
                <td>
                    @isset($hocvien[$row->id])
                        {{ $hocvien[$row->id] }}
                    @endisset
                    @empty($hocvien[$row->id])
                        0
                    @endempty
                </td>
                <td>
                    <a href="{{env('ALIAS')}}/course/class?c={{$row->id}}" class="btn btn-xs btn-info">
                        DS Giáo Viên
                    </a>
                    <a href="{{route('class-danhsach', ['cid' => $row->id])}}" class="btn btn-xs btn-info">
                        DS Học Viên
                    </a> </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@stop