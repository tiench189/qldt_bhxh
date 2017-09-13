@extends('layout')

@section('page-title')
    Phiếu Khảo Sát Chất Lượng Đào Tạo
@stop

@section('content')

    <div class="breadcrumbs">
        {!! Breadcrumbs::render('khaosat',"Danh sách") !!}
    </div>
    {!! Form::open(array('route' => 'khaosat-remove', 'class' => 'form', 'id' => 'frmkhaosatremove')) !!}
    {{ Form::hidden('uid', 0, array('id' => 'id')) }}
    {!! Form::close() !!}
    <script language="javascript">
        function removeKhaosat(id) {
            if (confirm("Bạn có muốn xóa phiếu khảo sát này?")) {
                document.getElementById("id").value = id;
                frmkhaosatremove.submit();
            }
        }
    </script>

    @if (Session::has('message'))
        <div class="alert alert-info">{!!  Session::get('message') !!}</div>
    @endif
    <a class="btn btn-primary btn-add" href="{{route('khaosat-create')}}">Thêm Phiếu Khảo Sát</a>
    <table id="table" class="table table-bordered table-hover" data-export="[0,1,2,3,4,5,6]">
        <thead>
        <tr>
            <th class="stt">#</th>
            <th>Nội dung<br><input type="text"></th>
            <th>Lớp<br><input type="text"></th>
            <th>Khóa học<br><input type="text"> </th>
            <th>Ngày tạo</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach ($khaosat as $idx=>$row)
            <tr>
                <td>{{ $row->id }}</td>
                <td>{{ $row->title }}</td>
                <td>{{ $ddclass[$row->class] }}</td>
                <td>{{ $ddcourse[$row->course] }}</td>
                <td>{{\App\Utils::toTimeFormat($row->created_at)}}</td>
                <td>
                    <a href="{{route('khaosat-update',["id"=>$row->id])}}" class="btn btn-xs btn-primary">Chuyên đề</a>
                    <a href="javascript:removeKhaosat({{$row->id}})" class="btn btn-xs btn-danger">Xóa</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@stop
