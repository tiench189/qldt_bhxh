@extends('layout')

@section('page-title')
    Thêm nội dung đào tạo
@stop

@section('content')
    <div class="breadcrumbs">
        {!! Breadcrumbs::render('category', 'Thêm Nội dung') !!}
    </div>

    @if (Session::has('message'))
        <div class="alert alert-info">{!!  Session::get('message') !!}</div>
    @endif

    @if ( $errors->count() > 0 )
        @foreach( $errors->all() as $message )
            <p class="alert alert-danger">{{ $message }}</p>
        @endforeach
    @endif

    {!! Form::open(array('route' => 'category-create', 'class' => 'form-horizontal', 'files'=>'true')) !!}
    <div class="row">
        <div class="col-md-offset-2 col-md-8">
            <div class="form-group">
                <label class="col-sm-3 control-label">Tên nội dung: <span class="required text-danger">(*)</span></label>
                <div class="col-sm-9">
                    {!! Form::text('name', '',
                        array('class'=>'form-control',
                        'placeholder'=>'Nội dung đào tạo',
                        'required' => 'required')) !!}
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Danh mục:</label>
                <div class="col-sm-9">
                    <select name="parent" class="js-example-basic-single form-control">
                        @foreach($parents as $row)
                            <option value="{{$row->id}}">{{$row->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Mô tả: </label>
                <div class="col-sm-9">
                    {!! Form::textarea('description', '',
                        array('class'=>'form-control',
                              'placeholder'=>'Tóm tắt nội dung',
                              'rows'=>5)) !!}
                </div>
            </div>
        </div>
    </div>

    <div class="row text-center">
        {!! Form::submit('Hoàn tất',
          array('class'=>'btn btn-primary')) !!}
        <a href="{{URL::previous()}}" class="btn btn-default">Quay lại</a>
    </div>
    {!! Form::close() !!}
@stop