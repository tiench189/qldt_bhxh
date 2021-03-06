@extends('layout')

@section('page-title')
    Tra cứu
@stop

@section('content')
    {!! Form::open(array('route' => 'tracuu-donvi', 'class' => 'form')) !!}
    <div class="page-title">Tra cứu</div>
    <div class="form-group form-inline">
        <label>Khóa đào tạo:</label>
        <select name="course" class="js-example-basic-single form-control">
            <option value=""></option>
            @foreach($courses as $row)
                <option value="{{$row->id}}" {{ (isset ($cid) && $cid == $row->id) ? "selected" : '' }} >{{$row->fullname}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group form-inline">
        <label>Năm:</label>
        <input type="text" name="year" value="{{ (isset ($year)) ? $year : '' }}" class="form-control datepicker">
    </div>
    <div class="form-group form-inline">
        <label>Các đơn vị:</label>
        <div class="form-group">
            <input type="radio" value="1"
                   name="status" {{ (isset ($status) && $status == 1) ? "checked=checked" : '' }}> đã đào tạo &ensp;
            <input type="radio" value="0"
                   name="status" {{ (isset ($status) && $status == 0) ? "checked=checked" : '' }}> chưa đào tạo
        </div>
    </div>
    <div class="form-group">
        {!! Form::submit('Tra cứu',
          array('class'=>'btn btn-primary')) !!}
    </div>
    {!! Form::close() !!}

    <table id="table" class="table table-bordered table-hover" data-export="[0,1,2,3]">
        <thead>
        <tr>

            <th width="5%">#</th>
            <th width="15%">Cấp đơn vị</th>
            <th width="25%">Tên đơn vị</th>
            <th width="25%">Mã Đơn vị</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($donvi as $idx => $row)
            <tr>
                <td> {{$idx + 1}} </td>
                <td> {{\App\Utils::formatCapDV($row->cap_donvi)}} </td>
                <td>

                    <a href="{{route('hocvien-index', ['donvi' => $row->id])}}">
                        {{$row->ten_donvi}}
                    </a>


                </td>
                <td> {{$row->ma_donvi}} </td>
            </tr>
        @endforeach
        </tbody>
    </table>


    <style>
        label {
            min-width: 150px;
        }
    </style>
@stop