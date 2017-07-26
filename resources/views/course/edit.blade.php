@extends('layout')

@section('page-title')
    Cập nhật thông tin khóa đào tạo
@stop

@section('content')
    <div class="page-title">Cập nhật thông tin khóa đào tạo
        <a href="{{env('APP_URL')}}/course/view.php?id={{$course->id}}&notifyeditingon=1#contentcourse"
           class="btn btn-primary pull-right">Tạo nội dung khóa đào tạo</a>
    </div>

    @if ( $errors->count() > 0 )
        @foreach( $errors->all() as $message )
            <p class="alert alert-danger">{{ $message }}</p>
        @endforeach
    @endif

    {!! Form::open(array('route' => 'course-update', 'class' => 'form', 'files'=>"true" )) !!}
    {{ Form::hidden('id', $course->id, array('id' => 'courseid')) }}
    <div class="form-group">
        <label>Tên khóa học<span class="required">(*)</span>: </label>
        {!! Form::textarea('fullname', $course->fullname,
            array('class'=>'form-control',
                  'placeholder'=>'Tên khóa học',
                  'rows' => 4)) !!}
    </div>
    <div class="form-group form-inline">
        <label>Đối tượng đào tạo: </label>
        <input type="text" name="doi_tuong" class="form-control" placeholder="VD: CBCC Bảo hiểm"
               value="{{$course->doi_tuong}}">
    </div>
    <div class="form-group form-inline">
        <label>Thời gian đào tạo: </label>
        <input type="text" name="thoi_gian" class="form-control" placeholder="VD: 1 tháng"
               value="{{$course->thoi_gian}}">
    </div>
    <div class="form-group form-inline">
        <label>Danh mục<span class="required">(*)</span>: </label>
        <select name="category" class="js-example-basic-single form-control">
            @foreach($categories as $cate)
                <option value="{{$cate->id}}" {{$cate->id == $course->category?'selected':''}}>{{$cate->name}}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label>Mô tả: </label>
        {!! Form::textarea('summary', $course->summary,
            array('class'=>'form-control myTextEditor',
                  'placeholder'=>'Tóm tắt nội dung')) !!}
    </div>

    <div class="form-group">
        <label>Tài liệu đính kèm: </label>
        {!! Form::file('docs', array('class'=>'')) !!}
    </div>

    <div class="form-group">
        {!! Form::submit('Cập nhật',
          array('class'=>'btn btn-primary')) !!}
    </div>
    {!! Form::close() !!}

@stop