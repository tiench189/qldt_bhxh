@extends('layout')

@section('page-title')
    Cập nhật thông tin học viên
@stop

@section('content')

    <div class="breadcrumbs">
        {!! Breadcrumbs::render('hocvien',"Cập nhật thông tin học viên",$user) !!}
    </div>

    @if (Session::has('message'))
        <div class="alert alert-info">{!!  Session::get('message') !!}</div>
    @endif
    {!! Form::open(array('route' => 'hocvien-update', 'class' => 'form-horizontal')) !!}
    <input type="hidden" name="uid" value="{{$user->id}}">

    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label class="col-sm-2 control-label">Email <span class="required">(*)</span></label>
                <div class="col-sm-9">
                    <strong>{{$user->email}}</strong>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Họ tên <span class="required">(*)</span></label>
                <div class="col-sm-9">
                    <input type="text" name="name" class="form-control" required value="{{$user->firstname}}">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Ngày sinh</label>
                <div class="col-sm-9">
                    <input type="text" name="birthday" class="form-control datepicker2" placeholder="dd/mm/yyyy"
                           value="{{\App\Utils::toTimeFormat($user->birthday)}}">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Giới tính</label>
                <div class="col-sm-9">
                    <input type="radio" name="sex" value="male" {{$user->sex == 'male'?'checked':''}}> Nam&nbsp;&nbsp;&nbsp;
                    <input type="radio" name="sex" value="female" {{$user->sex == 'female'?'checked':''}}> Nữ
                </div>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="form-group">
                <label class="col-sm-3 control-label">Đơn vị <span class="required">(*)</span></label>
                <div class="col-sm-9">
                    <select name="donvi" class="form-control js-example-basic-single" required>
                        @foreach($donvi as $dv)
                            <option value="{{$dv->id}}" {{$user->donvi == $dv->id?'selected':''}}>{{$dv->ten_donvi}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Chức danh</label>
                <div class="col-sm-9">
                    <input type="text" name="chucdanh" class="form-control" value="{{$user->chucdanh}}">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Vị trí công tác</label>
                <div class="col-sm-9">
                    <input type="text" name="chucvu" class="form-control" value="{{$user->chucvu}}">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Trình độ học vấn</label>
                <div class="col-sm-9">
                    <select name="hocvan" class="form-control js-example-basic-single">
                        <option value="">&nbsp;</option>
                        @foreach($hocvans as $hocvan)
                            <option value="{{$hocvan->id}}" @if($user->hocvan == $hocvan->id) selected @endif>{{$hocvan->hocvan}}</option>
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
                <a href="{{route('hocvien-index')}}" class="btn btn-default">Quay lại</a>
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