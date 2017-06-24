@extends('layout')

@section('page-title')
    Update User
@stop

@section('content')
    <div class="page-title">Cập nhật khóa đào tạo</div>

    {!! Form::open(array('route' => 'course-update', 'class' => 'form')) !!}
    {{ Form::hidden('id', $course->id, array('id' => 'courseid')) }}
    <div class="form-group">
        <label>Tên khóa học (rút gọn): <span class="required">(*)</span></label>
        {!! Form::text('shortname', $course->shortname,
            array('class'=>'form-control',
                  'placeholder'=>'Tên khóa học rút gọn')) !!}
    </div>
    <div class="form-group">
        <label>Tên khóa học: <span class="required">(*)</span></label>
        {!! Form::text('fullname', $course->fullname,
            array('class'=>'form-control',
                  'placeholder'=>'Tên khóa học ')) !!}
    </div>
    <div class="form-group">
        <label>Mô tả: <span class="required">(*)</span></label>
        {!! Form::textarea('summary', $course->summary,
            array('class'=>'form-control',
                  'placeholder'=>'Tóm tắt nội dung')) !!}
    </div>

    <div class="form-group">
        {!! Form::submit('Cập nhật',
          array('class'=>'btn btn-primary')) !!}
    </div>
    {!! Form::close() !!}


@stop