@extends('layout')

@section('page-title')
    Thêm học viên
@stop

@section('content')
    <div class="page-title">Thêm học viên</div>
    @if (Session::has('message'))
        <div class="alert alert-info">{!!  Session::get('message') !!}</div>
    @endif
    {!! Form::open(array('route' => 'hocvien-add', 'class' => 'form-horizontal')) !!}
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label class="col-sm-2 control-label">Họ tên <span class="required">(*)</span></label>
                <div class="col-sm-9">
                    <input type="text" name="name" class="form-control" required>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Email <span class="required">(*)</span></label>
                <div class="col-sm-9">
                    <input type="text" name="email" class="form-control" required>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label">Ngày sinh</label>
                <div class="col-sm-9">
                    <input type="text" name="birthday" class="form-control datepicker2" placeholder="dd/mm/yyyy">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Giới tính</label>
                <div class="col-sm-9" style="margin-top: 6px">
                    <input type="radio" name="sex" value="male" checked> Nam&nbsp;&nbsp;&nbsp;
                    <input type="radio" name="sex" value="male"> Nữ
                </div>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="form-group">
                <label class="col-sm-3 control-label">Đơn vị <span class="required">(*)</span></label>
                <div class="col-sm-9">
                    <select name="donvi" class="form-control js-example-basic-single" required>
                        @foreach($donvi as $dv)
                            <option value="{{$dv->id}}">{{$dv->ten_donvi}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3">Vị trí công tác</label>
                <div class="col-sm-9">
                    <input type="text" name="chucvu" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Chức danh</label>
                <div class="col-sm-9">
                    <input type="text" name="chucdanh" class="form-control">
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 text-center">
            <div class="form-group">
                {!! Form::submit('Hoàn tất',
                  array('class'=>'btn btn-primary')) !!}
            </div>
        </div>
    </div>
    {!! Form::close() !!}
    <style>
        label {
            min-width: 100px;
        }
    </style>
@stop