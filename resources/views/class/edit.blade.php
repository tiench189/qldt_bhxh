@extends('layout')

@section('page-title')
    Update Class
@stop

@section('content')
    <div class="page-title">{{($id==0)? "Thêm mới lớp học" : "Sửa lớp học"}}</div>

    @if ( $errors->count() > 0 )
        @foreach( $errors->all() as $message )
            <p  class="alert alert-danger">{{ $message }}</p>
        @endforeach
    @endif

    {!! Form::open(array('route' => 'class-edit', 'class' => 'form')) !!}
    {{ Form::hidden('id', ($id != 0) ? $class->id : 0, array('id' => 'id')) }}
    <div class="form-group">
        <label>Tên lớp: <span class="required">(*)</span></label>
        {!! Form::text('ten_lop', ($id != 0) ? $class->ten_lop : '',
            array('class'=>'form-control',
                  'placeholder'=>'Tên lớp')) !!}
    </div>
    <div class="form-group">
        <label>Khóa học: <span class="required">(*)</span></label>
        <select name="course_id" class="js-example-basic-single form-control">
            <option value=""></option>
            @foreach($courses as $row)
                <option value="{{$row->id}}" {{$cid}} {{ (isset ($cid) && $cid == $row->id) ? "selected" : '' }} >{{$row->fullname}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label>Đối tượng: <span class="required">(*)</span></label>
        {!! Form::text('doi_tuong', ($id != 0) ? $class->doi_tuong : '',
            array('class'=>'form-control',
                  'placeholder'=>'Đối tượng')) !!}
    </div>
    <div class="form-group form-inline">
        <label>Thời gian bắt đầu:</label>
        <input type="text" name="time_start" value="{{($id != 0) ? $class->time_start : ''}}" class="form-control datepicker2">
    </div>
    <div class="form-group form-inline">
        <label>Thời gian kết thúc:</label>
        <input type="text" name="time_end" value="{{($id != 0) ? $class->time_end : ''}}" class="form-control datepicker2">
    </div>

    <div class="form-group">
        {!! Form::submit('Cập nhật',
          array('class'=>'btn btn-primary')) !!}
    </div>
    {!! Form::close() !!}


@stop