@extends('layout')

@section('page-title')
    Quản lý nhóm quyền
@stop

@section('content')
    {!! Form::open(array('route' => 'role-delete', 'class' => 'form', 'id' => 'frmroleremove')) !!}
    {{ Form::hidden('gid', 0, array('id' => 'gid')) }}
    {!! Form::close() !!}
    <script language="javascript">
        function removeRole(gid) {
            if(confirm("Bạn có muốn xóa nhóm quyền này?")) {
                document.getElementById("gid").value = gid;
                frmroleremove.submit();
            }
        }
    </script>
    <div class="page-title">Quản lý nhóm quyền</div>

    @if (Session::has('message'))
        <div class="alert alert-info">{!!  Session::get('message') !!}</div>
    @endif
    @if(\App\Roles::checkRole('role-create'))
        <a class="btn btn-info" href="{{route('role-create')}}">Thêm mới</a>
    @endif
    <table id="table" class="table table-bordered">
        <thead>
        <tr>
            <th>#</th>
            <th>Nhóm quyền</th>
            <th style="width: 100px"></th>
        </tr>
        </thead>
        <tbody>
        @foreach($groups as $idx => $row)
            <tr>
                <td>{{$idx + 1}}</td>
                <td>{{$row->name}}</td>
                <td class="td-action">
                    @if(\App\Roles::checkRole('role-assign'))
                        <a class="btn btn-xs btn-info" href="{{route('role-assign', ['gid' => $row->id])}}">Cập nhật</a>
                    @endif
                    @if(\App\Roles::checkRole('role-delete'))
                        <a class="btn btn-xs btn-info" href="javascript:removeRole({{$row->id}})">Xóa</a>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@stop