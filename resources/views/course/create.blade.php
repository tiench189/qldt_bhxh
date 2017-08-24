@extends('layout')

@section('page-title')
    Thêm khóa đào tạo mới
@stop

@section('content')
    <div class="breadcrumbs">
        {!! Breadcrumbs::render('category', 'Tạo khóa đào tạo mới') !!}
    </div>

    @if (Session::has('message'))
        <div class="alert alert-info">{!!  Session::get('message') !!}</div>
    @endif

    @if ( $errors->count() > 0 )
        @foreach( $errors->all() as $message )
            <p class="alert alert-danger">{{ $message }}</p>
        @endforeach
    @endif

    {!! Form::open(array('route' => 'course-createCourse', 'class' => 'form-horizontal', 'files'=>'true')) !!}
    <div class="row">
        <div class="col-md-offset-2 col-md-8">
            <div class="form-group">
                <label class="col-sm-3 control-label">Tên khóa học: <span class="required text-danger">(*)</span></label>

                <div class="col-sm-9">
                    {!! Form::text('fullname', '',
                    array('class'=>'form-control',
                          'placeholder'=>'Tên khóa học',
                          'required' => 'required')) !!}
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Đối tượng đào tạo: </label>
                <div class="col-sm-9">
                    <input type="text" name="doi_tuong" class="form-control" placeholder="VD: CBCC Bảo hiểm">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Thời gian đào tạo: </label>
                <div class="col-sm-9">
                    <input type="text" name="thoi_gian" class="form-control" placeholder="VD: 1 tháng">
                </div>
            </div>
            <div class="form-group ">
                <label class="col-sm-3 control-label">Danh mục:</label>
                <div class="col-sm-9">
                    <select name="categoryid" class="js-example-basic-single form-control">
                        @foreach($cate as $row)
                            <option @if($row->id == $cat) selected @endif    value="{{$row->id}}">{{$row->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Mô tả: </label>
                <div class="col-sm-9">
                    {!! Form::textarea('summary', '',
                        array('class'=>'form-control myTextEditor',
                              'placeholder'=>'Tóm tắt nội dung',
                              'rows'=>5)) !!}
                </div>
            </div>
            <div class="form-group ">
                <label class="col-sm-3 control-label">File đính kèm:</label>
                <div class="col-sm-9">
                    {!! Form::file('docs', array('class'=>'form-control')) !!}
                </div>
            </div>
        </div>
    </div>

    {{--<div class="form-group">--}}
    {{--<label>File đính kèm: </label>--}}
    {{--<input type="file" name="file" id="file">--}}
    {{--</div>--}}
    <div class="row text-center">
        {!! Form::submit('Cập nhật',
          array('class'=>'btn btn-primary')) !!}
        <a href="{{URL::previous()}}" class="btn btn-default">Quay lại</a>
    </div>
    {!! Form::close() !!}
@stop