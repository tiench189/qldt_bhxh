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
            <p class="alert alert-danger">{{ $message }}</p>
        @endforeach
    @endif

    {!! Form::open(array('route' => 'course-createCourse', 'class' => 'form')) !!}
    <div class="form-group">
        <label>Tên khóa học: <span class="required">(*)</span></label>
        {!! Form::text('fullname', '',
            array('class'=>'form-control',
                  'placeholder'=>'Tên khóa đào tạo ')) !!}
    </div>
    <div class="form-group form-inline">
        <label>Đối tượng đào tạo: </label>
        <input type="text" name="doi_tuong" class="form-control" placeholder="VD: CBCC Bảo hiểm">
    </div>
    <div class="form-group form-inline">
        <label>Thời gian đào tạo: </label>
        <input type="text" name="thoi_gian" class="form-control" placeholder="VD: 1 tháng">
    </div>
    <div class="form-group form-inline">
        <label>Danh mục:</label>
        <select name="categoryid" class="js-example-basic-single form-control">
            @foreach($cate as $row)
                <option value="{{$row->id}}" >{{$row->name}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label>Mô tả: </label>
        {!! Form::textarea('summary', '',
            array('class'=>'form-control',
                  'placeholder'=>'Tóm tắt nội dung',
                  'rows'=>5)) !!}
    </div>

    <div class="form-group">
        {!! Form::submit('Cập nhật',
          array('class'=>'btn btn-primary')) !!}
    </div>
    {!! Form::close() !!}
@stop