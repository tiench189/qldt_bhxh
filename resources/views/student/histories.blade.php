@extends('layout')

@section('page-title')
    Lịch sử đào tạo {{$user->firstname}} {{$user->lastname}} ({{$user->email}})
@stop

@section('content')

    <div class="breadcrumbs">
        {!! Breadcrumbs::render('hocvien',"Thông tin",$user) !!}
    </div>

    <div class="segment-header">
        <span>Thông tin học viên</span>
    </div>

    <div class="user-info">
        <table class="table table-bordered">
            <tbody>
            <tr>
                <td>Họ và tên</td>
                <td><strong>{{$user->firstname}} {{$user->lastname}}</strong></td>
            </tr>
            <tr>
                <td>Ngày sinh</td>
                <td>{{\App\Utils::toTimeFormat($user->birthday)}}</td>
            </tr>
            <tr>
                <td>Giới tính</td>
                <td>{{\App\Utils::formatSex($user->sex)}}</td>
            </tr>
            <tr>
                <td>Email</td>
                <td>{{$user->email}}</td>
            </tr>
            <tr>
                <td>Học vấn</td>
                <td>{{($user->st_hocvan) ? $user->st_hocvan->hocvan : ''}}</td>
            </tr>
            <tr>
                <td>Chức danh</td>
                <td>{{$user->chucdanh}}</td>
            </tr>
            <tr>
                <td>Vị trí công tác</td>
                <td>{{$user->chucvu}}</td>
            </tr>
            <tr>
                <td>Đơn vị</td>
                <td>{{$user->getDonvi->ten_donvi}}</td>
            </tr>
            <?php
            if ($user->getDonvi->trucThuoc != null) {
                echo "<tr><td>Trực thuộc </td>";

                $s = '';
                $tructhuoc = $user->getDonvi->trucThuoc;
                while ($tructhuoc != null) {
                    $s .= $tructhuoc->ten_donvi . ', ';
                    $tructhuoc = $tructhuoc->trucThuoc;
                }

                echo "<td>" . trim($s, ', ') . "</td>";
                echo "</tr>";
            }
            ?>
            </tbody>
        </table>
    </div>

    <div class="segment-header">
        <span>Lịch sử đào tạo</span>
    </div>
    <table class="table table-bordered" id="table" data-export="[0,1,2,3,4,5,6]">
        <thead>
        <tr>
            <th class="stt">#</th>
            <th>Khóa học</th>
            <th>Lớp</th>
            <th>Trạng thái</th>
            <th>Điểm</th>
            <th>Xếp loại</th>
            <th>Ngày hoàn thành</th>
        </tr>
        </thead>
        <tbody>
        @foreach($histories as $idx=>$row)
            <tr>
                <td>{{$idx + 1}}</td>
                <td>@if(!empty($lop[$row->lop_id])) {{$lop[$row->lop_id]->course_name}} @endif</td>
                <td>@if(!empty($lop[$row->lop_id])) {{$lop[$row->lop_id]->ten_lop}} @endif</td>
                <td>{{\app\Utils::getStatus($row->status)}}</td>
                <td>{{$row->grade}}</td>
                <td>{{$xeploai[$row->xeploai]->name}}</td>
                <td>{{\app\Utils::formatTimestamp($row->complete_at)}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@stop
