@extends('layout')

@section('page-title')
    Cập nhật thông tin tài khoản
@stop

@section('content')

    <div class="breadcrumbs">
        {!! Breadcrumbs::render('user',"Cập nhật thông tin tài khoản",$user) !!}
    </div>

    @if (Session::has('message'))
        <div class="alert alert-info">{!!  Session::get('message') !!}</div>
    @endif
    {!! Form::open(array('route' => 'user-update', 'class' => 'form-horizontal')) !!}
    <input type="hidden" name="uid" value="{{$user->id}}">

    <div class="row">
        <div class="col-sm-12">
            <div class="form-group">
                <label class="col-sm-2 control-label"> Họ <span class="required">(*)</span></label>
                <div class="col-sm-9">
                    <input type="text" name="firstname" class="form-control" required value="{{$user->firstname}}">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label"> Tên <span class="required">(*)</span></label>
                <div class="col-sm-9">
                    <input type="text" name="lastname" class="form-control" required value="{{$user->lastname}}">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label"> Nhóm quyền <span class="required">(*)</span></label>
                <div class="col-sm-9">
                    <select name="group_permission" class="form-control">
                        <option value=""></option>
                        @foreach($groups as $gr)
                            <option value="{{$gr->id}}" {{$gr->id == $user->group_permission ? 'selected' : ''}}>{{$gr->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Email <span class="required">(*)</span></label>
                <div class="col-sm-9">
                    <input type="text" name="email" class="form-control" required value="{{$user->email}}">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Tài khoản <span>(*)</span></label>
                <div class="col-sm-9">
                    <strong>{{$user->username}}</strong>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Mật khẩu</label>
                <div class="col-sm-9">
                    <input type="text" name="name" class="form-control" placeholder="Mật khẩu">
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 text-center">
            <div class="form-group">
                {!! Form::submit('Hoàn tất',
                  array('class'=>'btn btn-primary')) !!}
                <a href="{{route('user-index')}}" class="btn btn-default">Quay lại</a>
            </div>
        </div>
    </div>

    {!! Form::close() !!}
    <style>
        label {
            min-width: 100px;
        }
    </style>
@stop