@extends('layout')

@section('page-title')
    Quản lý Học Viên
@stop

@section('content')
    <div class="col-lg-12">
    <h1>Danh sách học viên</h1>


    <table id="table" class="table table-bordered table-hover">
        <thead>
        <tr>
            <th>Fullname</th>
            <th>Username</th>
            <th>Email</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($users as $row)
            <tr>
                <td> {{$row->firstname}} {{$row->lastname}} </td>
                <td> {{$row->username}} </td>
                <td> {{$row->email}} </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    </div>
@stop
