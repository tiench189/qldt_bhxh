@extends('layout')

@section('page-title')
    Thêm học viên
@stop

@section('content')
    <div class="page-title">Thêm học viên</div>
    @if (Session::has('message'))
        <div class="alert alert-info">{!!  Session::get('message') !!}</div>
    @endif
    {!! Form::open(array('route' => 'hocvien-add', 'class' => 'form')) !!}
    <div class="form-group form-inline">
        <label>Họ tên <span class="required">(*)</span> :</label>
        <input type="text" name="name" class="form-control" required>
    </div>
    <div class="form-group form-inline">
        <label>Email <span class="required">(*)</span> :</label>
        <input type="text" name="email" class="form-control" required>
    </div>
    <div class="form-group form-inline">
        <label>Đơn vị <span class="required">(*)</span> :</label>
        <select name="donvi" class="form-control js-example-basic-single" required>
            @foreach($donvi as $dv)
                <option value="{{$dv->id}}">{{$dv->ten_donvi}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group form-inline">
        <label>Ngày sinh :</label>
        <input type="text" name="birthday" class="form-control datepicker2" placeholder="dd/mm/yyyy">
    </div>
    <div class="form-group form-inline">
        <label>Giới tính :</label>
        <input type="radio" name="sex" value="male" checked> Nam&nbsp;&nbsp;&nbsp;
        <input type="radio" name="sex" value="male"> Nữ
    </div>
    <div class="form-group form-inline">
        <label>Chức danh :</label>
        <input type="text" name="chucdanh" class="form-control">
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