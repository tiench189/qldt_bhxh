@extends('layout')

@section('page-title')
    Danh sách học viên
@stop

@section('content')
    <table id="table" class="table table-bordered table-hover" data-export="[0,1,2,3,4,5,6]">
        <thead>
        <tr>
            <th class="stt">#</th>
            <th>Họ tên<br><input type="text"></th>
            <th>Email<br><input type="text"></th>
            <th>Đơn vị<br><input type="text"> </th>
            <th>Giới tính<br>
                <select>
                    <option></option>
                    <option value="nam">Nam</option>
                    <option value="nữ">Nữ</option>
                </select>
            </th>
            <th>Chức danh<br><input type="text"></th>
            <th>Vị trí công tác<br><input type="text"></th>
        </tr>
        </thead>
        <tbody>
        @foreach ($users as $idx=>$row)
            <tr>
                <td>{{$idx + 1}}</td>
                <td> {{$row->firstname}} {{$row->lastname}}</td>
                <td> {{$row->email}} </td>
                <td>

                    <a href="{{route('hocvien-index', ['donvi' => $row->donvi])}}">
                        {{array_key_exists($row->donvi, $donvi)?$donvi[$row->donvi]->ten_donvi:''}}
                    </a>
                </td>
                <td>{{\App\Utils::formatSex($row->sex)}}</td>
                <td>{{$row->chucdanh}}</td>
                <td>{{$row->chucvu}}</td>
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