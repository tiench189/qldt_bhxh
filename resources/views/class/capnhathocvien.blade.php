@extends('layout')

@section('page-title')
    Cập nhật kết quả học viên
@stop

@section('content')
    <div class="page-title">Cập nhật kết quả học viên</div>

    @if ( $errors->count() > 0 )
        @foreach( $errors->all() as $message )
            <p  class="alert alert-danger">{{ $message }}</p>
        @endforeach
    @endif

    {!! Form::open(array('route' => 'class-capnhathocvien', 'class' => 'form')) !!}
    {{ Form::hidden('cid', $lhv->lop_id, array('cid' => 'cid')) }}
    {{ Form::hidden('uid', $lhv->user_id, array('uid' => 'uid')) }}

    <div class="form-group form-inline">
        <label>Điểm: <span class="required">(*)</span></label>
        {!! Form::text('grade', $lhv->grade,
            array('class'=>'form-control',
                  'placeholder'=>'Điểm')) !!}
    </div>
    <div class="form-group  form-inline">
        <label>Xếp loại: <span class="required">(*)</span></label>
        <select name="xeploai" class="form-control">
            @foreach($xeploai as $x)
                <option value="{{$x->id}}" {{($x->id != $lhv->xeploai)?'':'selected'}}>{{$x->name}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group  form-inline">
        <label>Trạng thái: <span class="required">(*)</span></label>
        <select name="status" class="form-control">
            <option value="inprogress" {{$lhv->status == 'inprogress'?'selected':''}}>Đang học</option>
            <option value="finished"  {{$lhv->status == 'finished'?'selected':''}}>Hoàn thành</option>
            <option value="cancel"  {{$lhv->status == 'cancel'?'selected':''}}>Hủy</option>
        </select>
    </div>


    <div class="form-group">
        {!! Form::submit('Cập nhật',
          array('class'=>'btn btn-primary')) !!}
    </div>
    {!! Form::close() !!}

<style>
    label{
        width: 120px;
    }
</style>
@stop