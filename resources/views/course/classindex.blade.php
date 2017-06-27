@extends('layout')

@section('page-title')
    {{ $course->shortname }} | Danh sách lớp học
@stop
@section('content')
    <div class="page-title">Danh sách lớp {{ $course->shortname }}</div>
    <table id="table" class="table table-bordered table-hover">
        <thead>
        <tr>

            <th width="20">#
            </th>
            <th>Tên lớp
            </th>
        </tr>
        </thead>
        <tbody>
        @foreach ($class as $row)
            <tr>
                <td> {{$row->id}} </td>
                <td>{{$row->ten_lop}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@stop