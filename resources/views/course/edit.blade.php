@extends('layout')

@section('page-title')
    Cập nhật thông tin khóa đào tạo
@stop

@section('content')
    <div class="breadcrumbs">
        {!! Breadcrumbs::render('category', 'Cập nhật thông tin khóa đào tạo') !!}
    </div>

    @if ( $errors->count() > 0 )
        @foreach( $errors->all() as $message )
            <p class="alert alert-danger">{{ $message }}</p>
        @endforeach
    @endif

    {!! Form::open(array('route' => 'course-update', 'class' => 'form-horizontal', 'files'=>"true" )) !!}
    {{ Form::hidden('id', $course->id, array('id' => 'courseid')) }}
    <div class="row">
        <div class="col-md-offset-2 col-md-8">
            <div class="form-group">
                <label class="col-sm-3 control-label">Tên khóa học <span class="required text-danger">(*)</span>: </label>
                <div class="col-sm-9">
                    {!! Form::text('fullname', $course->fullname,
                        array('class'=>'form-control',
                              'placeholder'=>'Tên khóa học',
                              'required' => 'required')) !!}
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Đối tượng đào tạo: </label>
                <div class="col-sm-9">
                    <input type="text" name="doi_tuong" class="form-control" placeholder="VD: CBCC Bảo hiểm"
                           value="{{$course->doi_tuong}}">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Thời gian đào tạo: </label>
                <div class="col-sm-9">
                    <input type="text" name="thoi_gian" class="form-control" placeholder="VD: 1 tháng"
                           value="{{$course->thoi_gian}}">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Danh mục: </label>
                <div class="col-sm-9">
                    <select name="category" class="js-example-basic-single form-control">
                        @foreach($categories as $cate)
                            <option value="{{$cate->id}}" {{$cate->id == $course->category?'selected':''}}>{{$cate->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label">Mô tả: </label>
                <div class="col-sm-9">
                    {!! Form::textarea('summary', $course->summary,
                        array('class'=>'form-control myTextEditor',
                              'placeholder'=>'Tóm tắt nội dung')) !!}
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label">Tài liệu đính kèm: </label>
                <div class="col-sm-9">
                    {!! Form::file('docs', array('class'=>'form-control')) !!}
                </div>
            </div>
        </div>
    </div>

    <div class="row text-center">
        {!! Form::submit('Cập nhật',
          array('class'=>'btn btn-primary')) !!}
        <a href="{{URL::previous()}}" class="btn btn-default">Quay lại</a>
    </div>
    {!! Form::close() !!}

@stop