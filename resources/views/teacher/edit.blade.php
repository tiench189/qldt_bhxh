@extends('layout')

@section('page-title')
    Update User
@stop

@section('content')
    <div class="page-title">Cập nhật giáo viên</div>
    @if ( $errors->count() > 0 )
        @foreach( $errors->all() as $message )
            <p  class="alert alert-danger">{{ $message }}</p>
        @endforeach
    @endif

    {!! Form::open(array('route' => 'teacher-update', 'class' => 'form')) !!}
    {{ Form::hidden('id', $teacher->id, array('id' => 'teacherid')) }}
    <div class="form-group">
        <label>Tên đăng nhập: <span class="required">(*)</span></label>
        {!! Form::text('username', $teacher->username,
            array('class'=>'form-control',
                  'placeholder'=>'Tên đăng nhập ')) !!}
    </div>
    <div class="form-group">
        <label>Họ & tên đệm: <span class="required">(*)</span></label>
        {!! Form::text('lastname', $teacher->lastname,
            array('class'=>'form-control',
                  'placeholder'=>'Họ & tên đệm')) !!}
    </div>
    <div class="form-group">
        <label>Tên: <span class="required">(*)</span></label>
        {!! Form::text('firstname', $teacher->firstname,
            array('class'=>'form-control',
                  'placeholder'=>'Tên')) !!}
    </div>
    <div class="form-group">
        <label>Mô tả: <span class="required">(*)</span></label>
        {!! Form::textarea('description', $teacher->description,
            array('class'=>'form-control',
                  'placeholder'=>'Mô tả')) !!}
    </div>

    <div class="form-group">
        {!! Form::submit('Cập nhật',
          array('class'=>'btn btn-primary')) !!}
    </div>
    {!! Form::close() !!}


@stop