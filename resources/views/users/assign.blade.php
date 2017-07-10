@extends('layout')

@section('page-title')
    Phân quyền nhóm người dùng - {{$groupname}}
@stop

@section('content')
    <div class="page-title">Phân quyền nhóm người dùng: {{$groupname}}</div>

    @if (Session::has('message'))
        <div class="alert alert-info">{!!  Session::get('message') !!}</div>
    @endif
    {!! Form::open(array('route' => 'role-assign', 'class' => 'form')) !!}
    <input type="hidden" name="gid" value="{{$groupid}}">
    <div class="form-group form-inline">
        <label>Tên nhóm quyền: </label>
        <input type="text" required name="name" placeholder="Tên nhóm quyền" class="form-control"
               value="{{$groupname}}">
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="role-contain">
                <div class="role-header">Nhóm chức năng chính</div>
                <div class="role-content">
                    @foreach($allRoles as $row)
                        <div class="form-group">
                            <input type="checkbox" name="roles[]"
                                   value="{{$row->id}}"
                                   {{in_array($row->id, $groupRole)?'checked':''}} class="role-root">
                            <label>{{$row->name}}</label>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="form-group">
                {!! Form::submit('Hoàn tất',
                  array('class'=>'btn btn-primary')) !!}
            </div>
        </div>
        <div class="row col-md-8 child-role">
            @foreach($allRoles as $row)
                @if(count($row->children) > 0)
                    <div class="col-md-6" style="display: {{in_array($row->id, $groupRole)?'block':'none'}}"
                         id="child-role-{{$row->id}}">
                        <div class="role-contain">
                            <div class="role-header child">{{$row->name}}</div>
                            <div class="role-content">
                                @foreach($row->children as $child)
                                    <div class="form-group">
                                        <input type="checkbox" name="roles[]" class="child-{{$row->id}}"
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
        $('.role-root').change(function () {
            var id = $(this).val();
            if (this.checked) {
                $('#child-role-' + id).show();
                console.log($('#child-role-' + id).offset().top);
                $('html, body').animate({
                    scrollTop: $('#child-role-' + id).offset().top
                }, 1000);
            } else {
                $('#child-role-' + id).hide();
                $('.child-' + id).prop('checked', false);
            }
        });
    </script>
@stop