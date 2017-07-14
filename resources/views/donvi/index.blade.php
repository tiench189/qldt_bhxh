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
            <th>Cấp đơn vị</th>
            <th>Tên đơn vị</th>
            <th>Mã đơn vị</th>
            <th>Mã trực thuộc</th>
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
                <td> {{$row->cap_donvi}} </td>
                <td> {{$row->ten_donvi}} </td>
                <td> {{$row->ma_donvi}} </td>
                <td> {{$row->ma_truc_thuoc}} </td>
                @if(\App\Roles::checkRole('donvi-update'))
                    <td><a href="{{route('donvi-update', ['id' => $row->id])}}">
                            Cập nhật</a>
                    </td>
                @endif
                @if(\App\Roles::checkRole('hocvien-remove'))
                    <td><a href="javascript:remove({{$row->id}})">
                            Xóa</a>
                    </td>
                @endif
            </tr>
        @endforeach
        </tbody>
    </table>
@stop
