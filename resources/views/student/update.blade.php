@extends('layout')

@section('page-title')
    Cập nhật thông tin học viên
@stop

@section('content')
    <div class="page-title">Cập nhật thông tin học viên<br><strong>{{$user->firstname}} {{$user->lastname}}
            ({{$user->email}})</strong></div>
    @if (Session::has('message'))
        <div class="alert alert-info">{!!  Session::get('message') !!}</div>
    @endif
    {!! Form::open(array('route' => 'hocvien-update', 'class' => 'form')) !!}
    <input type="hidden" name="uid" value="{{$user->id}}">
    <div class="form-group form-inline">
        <label>Họ tên <span class="required">(*)</span> :</label>
        <input type="text" name="name" class="form-control" required value="{{$user->firstname}}">
    </div>
    <div class="form-group form-inline">
        <label>Đơn vị <span class="required">(*)</span> :</label>
        <select name="donvi" class="form-control js-example-basic-single" required>
            @foreach($donvi as $dv)
                <option value="{{$dv->id}}" {{$user->donvi == $dv->id?'selected':''}}>{{$dv->ten_donvi}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group form-inline">
        <label>Ngày sinh :</label>
        <input type="text" name="birthday" class="form-control datepicker2" placeholder="dd/mm/yyyy"
               value="{{\App\Utils::toTimeFormat($user->birthday)}}">
    </div>
    <div class="form-group form-inline">
        <label>Giới tính :</label>
        <input type="radio" name="sex" value="male" {{$user->sex == 'male'?'checked':''}}> Nam&nbsp;&nbsp;&nbsp;
        <input type="radio" name="sex" value="female" {{$user->sex == 'female'?'checked':''}}> Nữ
    </div>
    <div class="form-group form-inline">
        <label>Chức danh :</label>
        <input type="text" name="chucdanh" class="form-control" value="{{$user->chucdanh}}">
    </div>
    <div class="form-group form-inline">
        <label>Vị trí công tác :</label>
        <input type="text" name="chucvu" class="form-control" value="{{$user->chucvu}}">
    </div>
    <div class="form-group">
        {!! Form::submit('Hoàn tất',
          array('class'=>'btn btn-primary')) !!}
    </div>
    {!! Form::close() !!}
    <style>
        label {
            min-width: 100px;
        }
    </style>
@stop