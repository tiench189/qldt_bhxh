@extends('layout')

@section('page-title')
    Cập nhật thông tin khóa đào tạo
@stop

@section('content')
    <div class="page-title">Cập nhật thông tin khóa đào tạo</div>

    @if ( $errors->count() > 0 )
        @foreach( $errors->all() as $message )
            <p class="alert alert-danger">{{ $message }}</p>
        @endforeach
    @endif

    {!! Form::open(array('route' => 'course-update', 'class' => 'form')) !!}
    {{ Form::hidden('id', $course->id, array('id' => 'courseid')) }}
    <div class="form-group">
        <label>Tên khóa học<span class="required">(*)</span>: </label>
        {!! Form::textarea('fullname', $course->fullname,
            array('class'=>'form-control',
                  'placeholder'=>'Tên khóa học',
                  'rows' => 4)) !!}
    </div>
    <div class="form-group form-inline">
        <label>Phân loại<span class="required">(*)</span>: </label>
        {!! Form::select('category', $categories, $course->category,
                            array('class'=>'form-control')) !!}
    </div>

    <div class="form-group">
        <label>Mô tả: </label>
        {!! Form::textarea('summary', $course->summary,
            array('class'=>'form-control myTextEditor',
                  'placeholder'=>'Tóm tắt nội dung')) !!}
    </div>

    <div class="form-group">
        {!! Form::submit('Cập nhật',
          array('class'=>'btn btn-primary')) !!}
    </div>
    {!! Form::close() !!}

    <script>
        tinymce.init({
            selector: 'textarea.myTextEditor'
        });
    </script>
@stop