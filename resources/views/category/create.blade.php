@extends('layout')

@section('page-title')
    Thêm nội dung đào tạo
@stop

@section('content')
    <div class="page-title">Thêm nội dung đào tạo</div>

    @if (Session::has('message'))
        <div class="alert alert-info">{!!  Session::get('message') !!}</div>
    @endif

    @if ( $errors->count() > 0 )
        @foreach( $errors->all() as $message )
            <p class="alert alert-danger">{{ $message }}</p>
        @endforeach
    @endif

    {!! Form::open(array('route' => 'category-create', 'class' => 'form', 'files'=>'true')) !!}
    <div class="form-group">
        <label>Tên nội dung: <span class="required">(*)</span></label>
        {!! Form::text('name', '',
            array('class'=>'form-control',
                  'placeholder'=>'Nội dung đào tạo')) !!}
    </div>
    <div class="form-group form-inline">
        <label>Danh mục:</label>
        <select name="parent" class="js-example-basic-single form-control">
            @foreach($parents as $row)
                <option value="{{$row->id}}" >{{$row->name}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label>Mô tả: </label>
        {!! Form::textarea('description', '',
            array('class'=>'form-control',
                  'placeholder'=>'Tóm tắt nội dung',
                  'rows'=>5)) !!}
    </div>

    <div class="form-group">
        {!! Form::submit('Hoàn tất',
          array('class'=>'btn btn-primary')) !!}
    </div>
    {!! Form::close() !!}
@stop