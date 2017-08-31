@extends('layout')

@section('page-title')
    Thêm tài khoản
@stop

@section('content')
    <div class="page-title">Thêm tài khoản</div>
    @if (Session::has('message'))
        <div class="alert alert-info">{!!  Session::get('message') !!}</div>
    @endif
    {!! Form::open(array('route' => 'user-add', 'class' => 'form-horizontal')) !!}
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group">
                <label class="col-sm-2 control-label">Họ <span class="required">(*)</span></label>
                <div class="col-sm-9">
                    <input type="text" name="firstname" class="form-control" required>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Tên <span class="required">(*)</span></label>
                <div class="col-sm-9">
                    <input type="text" name="lastname" class="form-control" required>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Email <span class="required">(*)</span></label>
                <div class="col-sm-9">
                    <input type="text" name="email" class="form-control" required>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label">Tên đăng nhập</label>
                <div class="col-sm-9">
                    <input type="text" name="username" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Mật khẩu</label>
                <div class="col-sm-9" style="margin-top: 6px">
                    <input type="password" name="password" class="form-control">

                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label"> Nhóm quyền <span class="required">(*)</span></label>
                <div class="col-sm-9">
                    <select name="group_permission" class="form-control">
                        <option value=""></option>
                        @foreach($groups as $gr)
                            <option value="{{$gr->id}}">{{$gr->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 text-center">
            <div class="form-group">
                {!! Form::submit('Hoàn tất',
                  array('class'=>'btn btn-primary')) !!}
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