@extends('layout')

@section('page-title')
    Thêm khóa đào tạo mới
@stop

@section('content')
    <div class="page-title">Tạo khóa đào tạo mới</div>

    @if (Session::has('message'))
        <div class="alert alert-info">{!!  Session::get('message') !!}</div>
    @endif

    @if ( $errors->count() > 0 )
        @foreach( $errors->all() as $message )
            <p  class="alert alert-danger">{{ $message }}</p>
        @endforeach
    @endif

    {!! Form::open(array('route' => 'course-createCourse', 'class' => 'form')) !!}
    <div class="form-group">
        <label>Tên khóa học (rút gọn): <span class="required">(*)</span></label>
        {!! Form::text('shortname', '',
            array('class'=>'form-control',
                  'placeholder'=>'Tên khóa học rút gọn')) !!}
    </div>
    <div class="form-group">
        <label>Tên khóa học: <span class="required">(*)</span></label>
        {!! Form::text('fullname', '',
            array('class'=>'form-control',
                  'placeholder'=>'Tên khóa học ')) !!}
    </div>
    <div class="form-group form-inline">
        <label>Danh mục:</label>
        <select name="categoryid" class="js-example-basic-single form-control">
            <option value=""></option>
            @foreach($cate as $row)
                <option value="{{$row->id}}" >{{$row->name}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label>Mô tả: <span class="required">(*)</span></label>
        {!! Form::textarea('summary', '',
            array('class'=>'form-control',
                  'placeholder'=>'Tóm tắt nội dung')) !!}
    </div>
    <div class="form-group form-inline">
        <label>Thời gian bắt đầu:</label>
        <input type="text" name="startdate" class="form-control datepicker2">
    </div>
    <div class="form-group form-inline">
        <label>Thời gian kết thúc:</label>
        <input type="text" name="enddate"  class="form-control datepicker2">
    </div>

    <div class="form-group">
        {!! Form::submit('Cập nhật',
          array('class'=>'btn btn-primary')) !!}
    </div>
    {!! Form::close() !!}


@stop