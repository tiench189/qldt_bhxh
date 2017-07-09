@extends('layout')

@section('page-title')
    Cập nhật nhóm quyền
@stop

@section('content')
    <div class="page-title">Cập nhật nhóm quyền<br><strong>{{$user->firstname}} {{$user->lastname}} ({{$user->email}})</strong></div>

    {!! Form::open(array('route' => 'user-update-role', 'class' => 'form')) !!}
    <input type="hidden" name="uid" value="{{$user->id}}">
    <div class="form-group form-inline">
        <label>Nhóm quyền:</label>
        <select name="group_permission" class="js-example-basic-single form-control">
            <option value=""></option>
            @foreach($groups as $row)
                <option value="{{$row->id}}" {{ ($user->group_permission == $row->id) ? "selected" : '' }} >{{$row->name}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        {!! Form::submit('Cập nhật',
          array('class'=>'btn btn-primary')) !!}
    </div>
    {!! Form::close() !!}
    <style>
        label{
            width: 100px;
        }
    </style>
@stop