@extends('layout')

@section('page-title')
    Tra cứu
@stop

@section('content')
    <div class="page-title">Tra cứu</div>
    <form method="get">
        <div class="form-group form-inline">
            <label>Khóa đào tạo:</label>
            <select class="js-example-basic-single form-control">
                <option value=""></option>
                @foreach($courses as $row)
                    <option value="{{$row->id}}">{{$row->fullname}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group form-inline">
            <label>Năm:</label>
            <input type="text" class="form-control datepicker">
        </div>
        <div class="form-group form-inline">
            <label>Các đơn vị:</label>
            <div class="form-group">
                <input  type="radio" value="1" name="status"> đã đào tạo &ensp;
                <input  type="radio" value="0" name="status"> chưa đào tạo
            </div>
        </div>
        <input type="submit" class="btn btn-primary" value="Tra cứu">
    </form>
    <style>
        label {
            min-width: 150px;
        }
    </style>
@stop