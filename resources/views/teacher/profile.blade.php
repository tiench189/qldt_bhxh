@extends('layout')

@section('page-title')
    Quá trình giảng dạy | {{$teacher->firstname}}
@stop

@section('content')

    <div class="breadcrumbs">
        {!! Breadcrumbs::render('giang-vien-profile', $teacher, $from_class) !!}
    </div>

    <div class="segment-header">
        <span>Thông tin Giảng viên</span>
    </div>

    <div class="user-info">
        <table class="table table-bordered">
            <tbody>
            <tr>
                <td>Họ và tên</td>
                <td><strong>{{$teacher->firstname}} {{$teacher->lastname}}</strong></td>
            </tr>
            <tr>
                <td>Ngày sinh</td>
                <td>{{\App\Utils::toTimeFormat($teacher->birthday)}}</td>
            </tr>
            <tr>
                <td>Giới tính</td>
                <td>{{\App\Utils::formatSex($teacher->sex)}}</td>
            </tr>
            <tr>
                <td>Email</td>
                <td>{{$teacher->email}}</td>
            </tr>
            <tr>
                <td>Chức danh</td>
                <td>{{$teacher->chucdanh}}</td>
            </tr>
            <tr>
                <td>Vị trí công tác</td>
                <td>{{$teacher->chucvu}}</td>
            </tr>
            <tr>
                <td>Đơn vị</td>
                <td>{{$teacher->getDonvi->ten_donvi}}</td>
            </tr>
            <?php
            if ($teacher->getDonvi->trucThuoc != null) {
                echo "<tr><td>Trực thuộc </td>";

                $s = '';
                $tructhuoc = $teacher->getDonvi->trucThuoc;
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
        <span>Lịch sử Giảng dạy</span>
    </div>
    <table class="table table-bordered" id="table" data-export="[0,1,2,3,4,5,6]">
        <thead>
        <tr>
            <th class="stt">#</th>
            <th>Khóa học</th>
            <th>Lớp</th>
        </tr>
        </thead>
        <tbody>
        <?php $i = 0; ?>
        @foreach($classes as $item)
            <tr>
                <td>{{$i = $i + 1}}</td>
                <td>
                    <a href="{{route('course-classes', ["c" => $item->course->id])}}">
                        {{$item->course->fullname}}
                    </a>
                </td>
                <td>
                    <a href="{{route('course-result', ["class" => $item->pivot->lop_id])}}">
                        {{$item->ten_lop}}
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@stop
