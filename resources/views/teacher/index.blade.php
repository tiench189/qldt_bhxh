@extends('layout')

@section('page-title')
    Danh sách giảng viên
@stop

@section('content')
    <div class="breadcrumbs">
        {!! Breadcrumbs::render('giangvien', 'Danh sách Giảng viên') !!}
    </div>
    @if (Session::has('message'))
        <div class="alert alert-info">{!!  Session::get('message') !!}</div>
    @endif
    @if(\App\Roles::checkRole('teacher-add'))
        <a class="btn btn-primary btn-add" href="{{route('teacher-add')}}">Thêm mới</a>
    @endif
    <table id="table" class="table table-bordered table-hover">
        <thead>
        <tr>

            <th width="20"># </th>
            <th>Tên giáo viên <br><input type="text"></th>
            <th>Chức danh <br><input type="text"></th>
            <th>Vị trí công tác <br><input type="text"></th>
            <th>Học hàm <br><input type="text"></th>
            <th>Chuyên ngành <br><input type="text"></th>
            <th width="10"></th>
            <th width="10"></th>
        </tr>
        </thead>
        <tbody>
        @foreach ($teachers as $row)
            <tr>
                <td> {{$row->id}} </td>
                <td> <strong>{{$row->lastname}} {{$row->firstname}}</strong> </td>
                <td>{{$row->chucdanh}}</td>
                <td>{{$row->chucvu}}</td>
                <td>{{$row->getGiangVien->hoc_ham or ''}}</td>
                <td>{{$row->getGiangVien->chuyen_nganh or ''}}</td>
                <td>
                    <a href="{{route('teacher-update', ['id' => $row->id])}}" title="Chỉnh sửa khóa đào tạo" class="btn btn-xs btn-primary">
                        Cập nhật
                    </a>
                </td>
                <td>
                    <a href="{{route('teacher-update', ['id' => $row->id])}}" title="Chỉnh sửa khóa đào tạo" class="btn btn-xs btn-danger">
                        Xóa
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@stop
