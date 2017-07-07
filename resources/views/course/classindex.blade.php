@extends('layout')

@section('page-title')
    Danh sách lớp học | {{ $course->fullname }}
@stop
@section('content')
    <div class="page-title">Danh sách lớp <strong>{{ $course->fullname }}</strong></div>
    @if(\App\Roles::checkRole('class-edit'))
        <a class="btn btn-info" href="{{route('class-edit', ['cid' => $course->id])}}" style="margin-bottom: 10px">Thêm
            mới</a>
    @endif
    <table id="table" class="table table-bordered table-hover" data-export="[0,1,2,3,4,5]">
        <thead>
        <tr>
            <th width="20">#</th>
            <th width="25%">Tên lớp</th>
            <th>Thời Gian Bắt đầu</th>
            <th>Thời Gian Kết Thúc</th>
            <th>Đối tượng</th>
            <th>Số lượng học viên</th>
            {{--<th></th>--}}
            @if(\App\Roles::checkRole('course-result'))
                <th></th>
            @endif
            @if(\App\Roles::checkRole('class-edit'))
                <th></th>
            @endif
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
                {{--<td>--}}
                {{--<a href="{{route('class-danhsach', ['cid' => $row->id])}}" class="btn btn-xs btn-info">--}}
                {{--DS Giáo Viên--}}
                {{--</a>--}}
                {{--</td>--}}
                @if(\App\Roles::checkRole('course-result'))
                    <td>
                        <a href="{{route('course-result', ['class' => $row->id])}}" class="btn btn-xs btn-info">
                            DS Học Viên
                        </a>
                    </td>
                @endif
                @if(\App\Roles::checkRole('class-edit'))
                    <td>
                        <a href="{{route('class-edit', ['cid' => $course->id, 'id' => $row->id])}}"
                           class="btn btn-xs btn-info">
                            Cập nhật
                        </a>
                    </td>
                @endif
            </tr>
        @endforeach
        </tbody>
    </table>
@stop