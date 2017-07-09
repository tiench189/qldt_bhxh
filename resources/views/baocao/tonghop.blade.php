@extends('layout')
@section('page-title')
    Báo cáo tổng hợp
@stop
@section('content')
    <div class="page-title">Báo cáo tổng hợp</div>
    <form method="get">
        <div class="form-group form-inline" id="form-filter">
            <label> Từ </label>
            <input required style="margin: 0px 10px" type="text" name="start"
                   value="{{ (isset ($start)) ? $start : '' }}" class="form-control datepicker">
            <label> Đến </label>
            <input required style="margin: 0px 10px" type="text" name="end" value="{{ (isset ($end)) ? $end : '' }}"
                   class="form-control datepicker">
            <input type="submit" class="btn btn-primary" value="Tổng hợp">
            @if(\App\Roles::checkRole('download-tonghop'))
                @if(count($data) > 0)
                    <a class="btn btn-primary" style="float: right"
                       href="{{route('download-tonghop', ['start' => $start, 'end' => $end])}}">Xuất ra excel</a>
                @endif
            @endif
        </div>
    </form>
    @if(count($data) > 0)
        <table class="table table-bordered" style="margin-top: 10px">
            <thead>
            <tr>
                <th rowspan="2">Năm</th>
                <th rowspan="2">Loại hình đào tạo</th>
                <th rowspan="2">Đối tượng đào tạo</th>
                <th rowspan="2" style="width: 50px">Số lớp</th>
                <th rowspan="2" style="width: 50px">Số lượng học viên</th>
                <th rowspan="2">Thời gian</th>
                <th colspan="{{count($xeploai)}}">Kết quả</th>
            </tr>
            <tr>
                @foreach($xeploai as $row)
                    <th class="col-kq">{!! $row->name !!}</th>
                @endforeach
            </tr>
            </thead>
            <tbody>
            @foreach($data as $year => $rowYear)
                <tr class="row-total">
                    <td colspan="3">Năm {{$year}}</td>
                    <td class="text-center">{{$rowYear['so_lop']}}</td>
                    <td class="text-center">{{$rowYear['so_hv']}}</td>
                    <td colspan="{{count($xeploai) + 1}}"></td>
                </tr>
                <?php $idx = 0?>
                @foreach($rowYear['course'] as $course)
                    <?php $idx++?>
                    <tr>
                        <td>{{$idx}}</td>
                        <td>{{$course['fullname']}}</td>
                        <td>{{$course['doi_tuong']}}</td>
                        <td class="bold text-center">{{$course['so_lop']}}</td>
                        <td class="bold text-center">{{$course['so_hv']}}</td>
                        <td class="bold text-center">{{$course['thoi_gian']}}</td>
                        @foreach($xeploai as $row)
                            <td class="bold text-center">{{array_key_exists($row->id, $course)?round($course[$row->id] * 100 / $course['so_hv']) . '%':''}}</td>
                        @endforeach
                    </tr>
                @endforeach
            @endforeach
            </tbody>
        </table>
    @endif
    <style>
        th {
            text-align: center;
            vertical-align: middle !important;
        }

        .col-kq {
            width: 60px;
        }

        .row-total > td {
            font-weight: bold;
            border: none !important;
            font-size: 1.1em;
        }

        .bold {
            font-weight: bold;
        }

        #form-filter {
            margin-top: 10px;
        }
    </style>
    <script>
        var strdata = '{{json_encode($data)}}';
        strdata = strdata.split("&quot;").join("");
        //        var data = JSON.parse(strdata);
        console.log(strdata);
    </script>
@stop