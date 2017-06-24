@extends('layout')

@section('page-title')
    Quản lý Khóa Học
@stop

@section('content')
    <div class="page-title">Danh sách Khóa đào tạo</div>
    <table id="table" class="table table-bordered table-hover">
        <thead>
        <tr>

            <th width="20">#
            </th>
            <th width="15%">Tên khóa học
            </th>
            <th width="15%">Tên khóa học (đầy đủ)
            </th>
            <th>Mô Tả
            </th>
            <th>Hiển thị
            </th>
            <th width="10%">Ngày kết thúc
            </th>
            <th width="10%">Ngày tạo / Ngày sửa
            </th>
            <th width="10%">
            </th>
        </tr>
        </thead>
        <tbody>
        @foreach ($course as $row)
            <tr>
                <td> {{$row->id}} </td>
                <td> <strong>{{$row->shortname}}</strong> </td>
                <td> {{$row->fullname}} </td>
                <td> {!! $row->summary !!} </td>
                <td> @if ($row->visible === 1)
                        <span class="label label-success">Hiện</span>
                    @else
                        <span class="label label-success">Ẩn</span>
                    @endif </td>
                <td> {{\App\Utils::toTimeFormat($row->enddate)}} </td>
                <td>  {{\App\Utils::toTimeFormat($row->timecreated)}}
                    <br/> {{\App\Utils::toTimeFormat($row->timemodified)}} </td>
                <td>
                    <a href="{{env('ALIAS')}}/course/update?id={{$row->id}}" title="Chỉnh sửa khóa đào tạo">
                        <div class="ico-action edit"></div>
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@stop
