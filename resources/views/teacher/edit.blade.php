@extends('layout')

@section('page-title')
    Giảng viên: {{$teacher->lastname . ' ' . $teacher->firstname}}
@stop

@section('content')
    <div class="page-title">Cập nhật giáo viên</div>
    @if ( $errors->count() > 0 )
        @foreach( $errors->all() as $message )
            <p class="alert alert-danger">{{ $message }}</p>
        @endforeach
    @endif

    {!! Form::open(array('route' => 'teacher-update', 'class' => 'form-horizontal')) !!}
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group ">
                <label class="col-sm-2  control-label">Họ tên <span class="required">(*)</span></label>
                <div class="col-sm-9">
                    <input type="text" name="name" class="form-control" value="{{$teacher->firstname or ''}}" required>
                    <input type="hidden" name="teacher_id" value="{{$teacher->id}}">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Email <span class="required">(*)</span></label>
                <div class="col-sm-9">
                    <input type="text" name="email" class="form-control" value="{{$teacher->email or ''}}" required>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2">Đơn vị <span class="required">(*)</span></label>
                <div class="col-sm-9">
                    <select name="donvi" class="form-control js-example-basic-single" required>
                        @foreach($donvi as $dv)
                            <option @if($teacher->donvi == $dv->id) selected @endif value="{{$dv->id}}">{{$dv->ten_donvi}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2">Ngày sinh</label>
                <div class="col-sm-9">
                    <input type="text" name="birthday" class="form-control datepicker2"
                           value="{{isset($teacher->birthday) ? date('d/m/Y', strtotime($teacher->birthday)) : ''}}" placeholder="dd/mm/yyyy">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Giới tính</label>
                <div class="col-sm-9">
                    <input type="radio" name="sex" value="male" {{$teacher->sex == 'male'?'checked':''}}> Nam
                    <input type="radio" name="sex" value="female" {{$teacher->sex == 'female'?'checked':''}}> Nữ
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label class="control-label col-sm-3">Chức danh</label>
                <div class="col-sm-9">
                    <input type="text" name="chucdanh" class="form-control" value="{{$teacher->chucdanh}}">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3">Vị trí công tác</label>
                <div class="col-sm-9">
                    <input type="text" name="chucvu" class="form-control" value="{{$teacher->chucvu}}">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3">Học hàm</label>
                <div class="col-sm-9">
                    <input type="text" name="hocham" class="form-control" value="{{$teacher->getGiangVien->hoc_ham or ''}}">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3">Chuyên ngành</label>
                <div class="col-sm-9">
                    <input type="text" name="chuyennganh" class="form-control" value="{{$teacher->getGiangVien->chuyen_nganh or ''}}">
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 text-center">
            <div class="form-group">
                {!! Form::submit('Cập nhật',
                  array('class'=>'btn btn-primary')) !!}
                <a href="{{route('teacher-index')}}" class="btn btn-default" >Quay lại</a>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@stop