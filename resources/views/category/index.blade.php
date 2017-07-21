@extends('layout')

@section('page-title')
    Danh mục
@stop
@section('content')
    {!! Form::open(array('route' => 'category-remove', 'class' => 'form', 'id' => 'frmcateremove')) !!}
    {{ Form::hidden('id', 0, array('id' => 'cateid')) }}
    {!! Form::close() !!}
    <script language="javascript">
        function removeCourse(cid) {
            if (confirm("Bạn có muốn xóa danh mục đào tạo này?")) {
                document.getElementById("cateid").value = cid;
                frmcateremove.submit();
            }
        }
    </script>
    @if (Session::has('message'))
        <div class="alert alert-info">{!!  Session::get('message') !!}</div>
    @endif
    <div class="page-title">Danh sách category</div>
    @if(\App\Roles::checkRole('category-create'))
        <a class="btn btn-primary btn-add" href="{{route('category-create')}}">Thêm mới</a>
    @endif
    <table id="table" class="table table-bordered table-hover" data-export="[0,1,2]">
        <thead>
        <tr>

            <th class="stt">#</th>
            <th style="min-width: 50px">Tên danh mục đào tạo<br><input type="text"></th>
            <th style="width: 300px">Mô tả<br><input type="text"></th>
            @if(\App\Roles::checkRole('index'))
                <th class="action"></th>
            @endif
            @if(\App\Roles::checkRole('course-update'))
                <th class="action"></th>
            @endif
            @if(\App\Roles::checkRole('course-remove'))
                <th class="action"></th>
            @endif
        </tr>
        </thead>
        <tbody>
        @foreach ($category as $idx => $row)
            <tr>
                <td> {{$idx + 1}} </td>
                <td><strong> {{$row->name}} </strong></td>
                <td>{{$row->description}}</td>

                @if(\App\Roles::checkRole('index'))
                    <td>
                        <a href="{{route('index', ['c' => $row->id])}}" class="btn btn-xs btn-primary">
                            Danh sách khóa
                        </a>
                    </td>
                @endif
                @if(\App\Roles::checkRole('category-update'))
                    <td>
                        <a href="{{route('category-update', ['id' => $row->id])}}" class="btn btn-xs btn-primary">
                            Cập nhật
                        </a>
                    </td>
                @endif
                @if(\App\Roles::checkRole('category-remove'))
                    <td>
                        <a href="javascript:removeCourse({{$row->id}})" class="btn btn-xs btn-primary">
                            Xóa
                        </a>
                    </td>
                @endif
            </tr>
        @endforeach
        </tbody>
    </table>
    <style>
        #table_filter {
            display: none;
        }
    </style>
@stop