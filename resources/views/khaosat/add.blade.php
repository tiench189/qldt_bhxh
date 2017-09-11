@extends('layout')

@section('page-title')
    Thêm Phiếu Khảo Sát Chất Lượng Đào Tạo
@stop

@section('content')

    <div class="breadcrumbs">
        {!! Breadcrumbs::render('khaosat',"Thêm mới") !!}
    </div>

    @if ( $errors->count() > 0 )
        @foreach( $errors->all() as $message )
            <p  class="alert alert-danger">{{ $message }}</p>
        @endforeach
    @endif

    @if (Session::has('message'))
        <div class="alert alert-info">{!!  Session::get('message') !!}</div>
    @endif
    {!! Form::open(array('route' => 'khaosat-create', 'class' => 'form')) !!}

    <div class="form-group form-inline">
        <label>Chọn khóa học<span class="required">(*)</span> :</label>
        <select name="course" id="lstcourse" class="form-control js-example-basic-single" required>
            @foreach ($course as $idx=>$row)
            <option value="{{ $row->id }}">{{ $row->fullname }}</option>
            @endforeach
        </select>
    </div>


    <div class="form-group form-inline">
        <label>Chọn lớp<span class="required">(*)</span> :</label>
        <select name="class" id="lstclass" class="form-control js-example-basic-single" required>
            @foreach ($class as $idx=>$row)
                <option value="{{ $row->id }}" data-course="{{$row->course_id}}">{{ $row->ten_lop }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group form-inline">
        <label>Nội dung khảo sát<span class="required">(*)</span> :</label>
        <input type="text" name="ten_donvi" class="form-control" value="{{ isset($donvi) ? $donvi->ten_donvi : ''}}" required>
    </div>

    <div class="form-group">
        {!! Form::submit('Hoàn tất',
          array('class'=>'btn btn-primary')) !!}
    </div>
    {!! Form::close() !!}
    <script language="javascript">
        $(document).ready(function () {
            $("#lstcourse").change(function() {
                if($("#lstcourse option").attr("data-course") == $(this).val()) {
                    
                }
                // $(this).val() will work here
            });
        });
    </script>
@stop