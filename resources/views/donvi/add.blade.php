@extends('layout')

@section('page-title')
    {{isset($donvi) ? "Sửa đơn vị" : "Thêm đơn vị"}}
@stop

@section('content')
    <div class="page-title">{{isset($donvi) ? "Sửa đơn vị" : "Thêm đơn vị"}}</div>
    @if ( $errors->count() > 0 )
        @foreach( $errors->all() as $message )
            <p  class="alert alert-danger">{{ $message }}</p>
        @endforeach
    @endif

    @if (Session::has('message'))
        <div class="alert alert-info">{!!  Session::get('message') !!}</div>
    @endif
    {!! Form::open(array('route' => isset($donvi) ? 'donvi-update' : 'donvi-add', 'class' => 'form')) !!}
    <input type="hidden" name="id" value="{{isset($donvi) ? $donvi->id : ''}}">

    <div class="form-group form-inline">
        <label>Tên đơn vị<span class="required">(*)</span> :</label>
        <input type="text" name="ten_donvi" class="form-control" value="{{ isset($donvi) ? $donvi->ten_donvi : ''}}" required>
    </div>

    <div class="form-group form-inline">
        <label>Mã đơn vị<span class="required">(*)</span> :</label>
        <input type="text" name="ma_donvi" class="form-control" value="{{ isset($donvi) ? $donvi->ma_donvi : ''}}" required>
    </div>

    <div class="form-group form-inline">
        <label>Cấp đơn vị <span class="required">(*)</span> :</label>
        <select name="cap_donvi" class="form-control js-example-basic-single" required>
                <option value="1" {{ (isset($donvi) && $donvi->cap_donvi == 1) ? "selected" : ""}}  >Cấp trung ương</option>
                <option value="2" {{ (isset($donvi) && $donvi->cap_donvi == 2) ? "selected" : ""}}  >Cấp tỉnh</option>
                <option value="3" {{ (isset($donvi) && $donvi->cap_donvi == 3) ? "selected" : ""}}  >Cấp huyện</option>
        </select>
    </div>

    <div class="form-group form-inline">
        <label>Đơn vị trực thuộc<span class="required">(*)</span> :</label>
        <select name="ma_truc_thuoc" class="form-control js-example-basic-single">
            @foreach($listdonvi as $dv)
                <option value="{{$dv->id}}" {{ (isset($donvi) && $donvi->ma_truc_thuoc == $dv->id) ? "selected" : ""}} >{{$dv->ten_donvi}}</option>
            @endforeach
        </select>
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