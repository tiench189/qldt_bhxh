@extends('layout')

@section('page-title')
    Phân quyền nhóm người dùng
@stop

@section('content')
    <div class="page-title">Phân quyền nhóm người dùng</div>

    @if (Session::has('message'))
        <div class="alert alert-info">{!!  Session::get('message') !!}</div>
    @endif
    {!! Form::open(array('route' => 'role-assign', 'class' => 'form')) !!}
    <div class="row">
        <div class="col-md-4">
            <div class="role-contain">
                <div class="role-header">Nhóm chức năng chính</div>
                <div class="role-content">
                    @foreach($allRoles as $row)
                        <div class="form-group">
                            <input type="checkbox" name="roles[]"
                                   value="{{$row->id}}" {{in_array($row->id, $groupRole)?'checked':''}} class="role-root">
                            <label>{{$row->name}}</label>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="row col-md-8 child-role">
            @foreach($allRoles as $row)
                @if(count($row->children) > 0)
                    <div class="col-md-6 {{in_array($row->id, $groupRole)?'':'hidden'}}" id="child-role-{{$row->id}}">
                        <div class="role-contain">
                            <div class="role-header child">{{$row->name}}</div>
                            <div class="role-content">
                                @foreach($row->children as $child)
                                    <div class="form-group">
                                        <input type="checkbox" name="roles[]"
                                               value="{{$child->id}}" {{in_array($child->id, $groupRole)?'checked':''}}>
                                        <label>{{$child->name}}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>

    {!! Form::close() !!}
    <script>
        $('.role-root').change(function(){
            var id = $(this).val();
            if (this.checked){
                $('#child-role-' + id).show();
            }else{
                $('#child-role-' + id).hide();
            }
        });
    </script>
@stop