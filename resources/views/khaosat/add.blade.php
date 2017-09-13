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

    <div class="form-group">
        <label>Chọn khóa học<span class="required">(*)</span> :</label>
        <select name="course" id="lstcourse" class="form-control" required>
            @foreach ($course as $idx=>$row)
            <option value="{{ $row->id }}">{{ $row->fullname }}</option>
            @endforeach
        </select>
    </div>


    <div class="form-group">
        <label>Chọn lớp<span class="required">(*)</span> :</label>
        <select name="class" id="lstclass" class="form-control" required>
            @foreach ($class as $idx=>$row)
                <option value="{{ $row->id }}" data-course="{{$row->course_id}}">{{ $row->ten_lop }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label>Nội dung khảo sát<span class="required">(*)</span> :</label>
        <input type="text" name="title" class="form-control" required>
    </div>

    <div class="form-group">
        {!! Form::submit('Tiếp theo',
          array('class'=>'btn btn-primary')) !!}
    </div>
    {!! Form::close() !!}
    <script language="javascript">
        $(document).ready(function () {

            $('#lstcourse').on('change', function () {
                $('#lstclass')
                    .val('')
                    .children()
                    .prop('disabled', true).addClass("hide")
                    .filter('[data-course="'+ $(this).val() +'"]')
                    .prop('disabled', false).removeClass("hide");
            })
                .trigger('change');
        });
    </script>
@stop