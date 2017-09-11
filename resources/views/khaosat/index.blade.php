@extends('layout')

@section('page-title')
    Phiếu Khảo Sát Chất Lượng Đào Tạo
@stop

@section('content')

    <div class="breadcrumbs">
        {!! Breadcrumbs::render('khaosat') !!}
    </div>
    {!! Form::open(array('route' => 'khaosat-remove', 'class' => 'form', 'id' => 'frmkhaosatremove')) !!}
    {{ Form::hidden('uid', 0, array('id' => 'id')) }}
    {!! Form::close() !!}
    <script language="javascript">
        function removeStudent(uid) {
            if (confirm("Bạn có muốn xóa phiếu khảo sát này?")) {
                document.getElementById("id").value = uid;
                frmstudentremove.submit();
            }
        }
    </script>

    @if (Session::has('message'))
        <div class="alert alert-info">{!!  Session::get('message') !!}</div>
    @endif
    <a class="btn btn-primary btn-add" href="{{route('hocvien-add')}}">Thêm Phiếu Khảo Sát</a>
    <table id="table" class="table table-bordered table-hover" data-export="[0,1,2,3,4,5,6]">
        <thead>
        <tr>
            <th class="stt">#</th>
            <th>Nội dung<br><input type="text"></th>
            <th>Lớp<br><input type="text"></th>
            <th>Khóa học<br><input type="text"> </th>
            <th>Ngày tạo<br><input type="text"></th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach ($khaosat as $idx=>$row)
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        @endforeach
        </tbody>
    </table>
@stop
