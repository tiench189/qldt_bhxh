@extends('layout')

@section('page-title')
    Quản lý Đơn vị
@stop

@section('content')
    <div class="page-title">Danh sách đơn vị</div>

    {!! Form::open(array('route' => 'donvi-remove', 'class' => 'form', 'id' => 'frmremove')) !!}
    {{ Form::hidden('id', 0, array('id' => 'madonvi')) }}

    {!! Form::close() !!}
    <script language="javascript">
        function remove(id) {
            if (confirm("Bạn có muốn xóa đơn vị này?")) {
                document.getElementById("madonvi").value = id;
                frmremove.submit();
            }
        }
    </script>

    @if (Session::has('message'))
        <div class="alert alert-info">{!!  Session::get('message') !!}</div>
    @endif
    @if(\App\Roles::checkRole('donvi-add'))
        <a class="btn btn-primary btn-add" href="{{route('donvi-add')}}">Thêm mới</a>
    @endif
    <table id="table" class="table table-bordered table-hover" data-export="[0,1,2,3,4,5,6]">
        <thead>
        <tr>
            <th class="stt">STT</th>
            <th>Tên đơn vị</th>
            <th>Cấp đơn vị</th>
            <th>Mã đơn vị</th>
            <th>Đơn vị trực thuộc</th>
            @if(\App\Roles::checkRole('hocvien-index'))
                <th class="action"></th>
            @endif
            @if(\App\Roles::checkRole('donvi-update'))
                <th class="action"></th>
            @endif
            @if(\App\Roles::checkRole('donvi-remove'))
                <th class="action"></th>
            @endif
        </tr>
        </thead>
        <tbody>
        @foreach ($donvi as $idx=>$row)
            <tr>
                <td>{{$idx + 1}}</td>
                <td> {{$row->ten_donvi}} </td>
                <td> {{$row->capDonVi->ten_cap}} </td>
                <td> {{$row->ma_donvi}} </td>
                <td> {{$row->trucThuoc['ten_donvi']}} </td>
                @if(\App\Roles::checkRole('hocvien-index'))
                    <td><a href="{{route('hocvien-index', ['donvi' => $row->id])}}" class="btn btn-xs btn-primary">
                            Danh sách học viên</a>
                    </td>
                @endif
                @if(\App\Roles::checkRole('donvi-update'))
                    <td><a href="{{route('donvi-update', ['id' => $row->id])}}" class="btn btn-xs btn-primary">
                            Cập nhật</a>
                    </td>
                @endif
                @if(\App\Roles::checkRole('hocvien-remove'))
                    <td><a href="javascript:remove({{$row->id}})" class="btn btn-xs btn-primary">
                            Xóa</a>
                    </td>
                @endif
            </tr>
        @endforeach
        </tbody>
    </table>
@stop
