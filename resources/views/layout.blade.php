<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="{{route('index')}}/img/favicon.ico">
    <script src="{{route('index')}}/js/jquery-3.1.1.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src="{{route('index')}}/js/bootstrap.min.js"></script>
    <script src="{{route('index')}}/js/select2.js"></script>
    <script src="{{route('index')}}/js/bootstrap-datepicker.js"></script>

    <link href="{{route('index')}}/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="{{route('index')}}/css/main.css" rel="stylesheet" type="text/css">
    <link href="{{route('index')}}/css/select2.css" rel="stylesheet" type="text/css">
    <link href="{{route('index')}}/css/datepicker.css" rel="stylesheet">

    <!-- Datatable -->
    <link rel="stylesheet" type="text/css"
          href="{{route('index')}}/js/datatables/DataTables-1.10.13/css/dataTables.bootstrap.min.css"/>
    <link rel="stylesheet" type="text/css"
          href="{{route('index')}}/js/datatables/Buttons-1.2.4/css/buttons.bootstrap.min.css"/>

    <script type="text/javascript" src="{{route('index')}}/js/datatables/JSZip-2.5.0/jszip.min.js"></script>
    <script type="text/javascript" src="{{route('index')}}/js/datatables/pdfmake-0.1.18/build/pdfmake.min.js"></script>
    <script type="text/javascript" src="{{route('index')}}/js/datatables/pdfmake-0.1.18/build/vfs_fonts.js"></script>
    <script type="text/javascript"
            src="{{route('index')}}/js/datatables/DataTables-1.10.13/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript"
            src="{{route('index')}}/js/datatables/DataTables-1.10.13/js/dataTables.bootstrap.min.js"></script>
    <script type="text/javascript"
            src="{{route('index')}}/js/datatables/Buttons-1.2.4/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript"
            src="{{route('index')}}/js/datatables/Buttons-1.2.4/js/buttons.bootstrap.min.js"></script>
    <script type="text/javascript"
            src="{{route('index')}}/js/datatables/Buttons-1.2.4/js/buttons.flash.min.js"></script>
    <script type="text/javascript"
            src="{{route('index')}}/js/datatables/Buttons-1.2.4/js/buttons.html5.min.js"></script>
    <script type="text/javascript"
            src="{{route('index')}}/js/datatables/Buttons-1.2.4/js/buttons.print.min.js"></script>
    <!-- End Datatables -->
    <script src="https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=wzxwahk80h4vnnkhr82slopri73e74x1r2q5d6llmaj8kvhu"></script>
    <title>@section('page-title')
        @show</title>
</head>
<body>
<div id="wrapper" class="container no-padding">
    <header id="page-header" class="clearfix">
        <div class="container-fluid">
            <a class="logo" href="{{route('index')}}">
                <img src="{{route('index')}}/img/logo.png" class="logo">
            </a>
            <span class="logo-title">HỆ THỐNG QUẢN LÝ ĐÀO TẠO BHXH</span>
        </div>
    </header>
    <nav class="navbar navbar-bh" role="navigation">
        <div class="container-fluid no-padding">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse"
                        data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>

            <div class="collapse navbar-collapse no-padding" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav my-nav">
                    @if(\App\Roles::checkRole('index'))
                        <li class="dropdown active">
                            <a href="{{route('index')}}/course" class="dropdown-toggle" data-toggle="dropdown">Nội dung đào
                                tạo
                                <b
                                        class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <?php $categories = \App\Utils::listCategories()?>
                                @foreach($categories as $idx=>$cate)
                                    @if($idx > 0)
                                        <li class="divider"></li>
                                    @endif
                                    <li><a href="{{route('index', ['c' => $cate->id])}}">{{$cate->name}}</a></li>
                                @endforeach
                            </ul>
                        </li>
                    @endif
                    {{--<li><a href="{{route('teacher-index')}}">Giảng viên</a></li>--}}
                    @if(\App\Roles::checkRole('hocvien-index'))
                        <li><a href="{{route('hocvien-index')}}">Học viên</a></li>
                    @endif
                    @if(\App\Roles::checkRole('tracuu'))
                        <li class="dropdown ">
                            <a class="dropdown-toggle" data-toggle="dropdown">Tra cứu <b
                                        class="caret"></b></a>
                            <ul class="dropdown-menu">
                                @if(\App\Roles::checkRole('tracuu-donvi'))
                                    <li><a href="{{route('tracuu-donvi')}}">Theo đơn vị</a></li>
                                @endif
                            </ul>
                        </li>
                    @endif
                    @if(\App\Roles::checkRole('baocao'))
                        <li class="dropdown ">
                            <a class="dropdown-toggle" data-toggle="dropdown">Báo cáo <b
                                        class="caret"></b></a>
                            <ul class="dropdown-menu">
                                @if(\App\Roles::checkRole('baocao-tonghop'))
                                    <li><a href="{{route('baocao-tonghop')}}">Tổng hợp</a></li>
                                @endif
                            </ul>
                        </li>
                    @endif
                    @if(\App\Roles::checkRole('user-index'))
                        <li class="dropdown ">
                            <a class="dropdown-toggle" data-toggle="dropdown">Quản lý tài khoản <b
                                        class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="{{route('user-index')}}">Tài khoản</a></li>
                                @if(\App\Roles::checkRole('baocao-tonghop'))
                                    <li><a href="{{route('role-index')}}">Quản lý quyền</a></li>
                                @endif
                            </ul>
                        </li>

                    @endif
                    {{--<li><a href="#">Phiếu khảo sát</a></li>--}}

                </ul>
                <form class="navbar-form navbar-left hidden" role="search">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Search">
                    </div>
                    <button type="submit" class="btn btn-default">Submit</button>
                </form>
{{--                @if(\Illuminate\Support\Facades\Session::get('isAuth', false))
                    <ul class="nav navbar-nav my-nav navbar-right">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                {{\Illuminate\Support\Facades\Session::get('user')->firstname}} {{\Illuminate\Support\Facades\Session::get('user')->lastname}}
                                <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="{{route('logout')}}">Đăng xuất</a></li>
                            </ul>
                        </li>
                    </ul>
                @endif--}}

                <ul class="nav navbar-nav my-nav navbar-right">
                        @if (Auth::guest())
                            <li><a href="{{ route('login') }}">Đăng nhập</a></li>
                        @else
                            <li class="dropdown">
                                <a class="dropdown-toggle top-menu" data-toggle="dropdown"
                                   href="#">{{\Illuminate\Support\Facades\Auth::user()->username}}
                                    <span class="caret"></span></a>
                                <ul class="dropdown-menu">
{{--
                                    <li><a href="{{ route('user-changepass') }}" style="color: black !important;">Sửa mật khẩu</a></li>
--}}
                                    <li><a href="{{ route('logout') }}"
                                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"
                                           style="color: black !important;">Đăng xuất</a></li>

                                </ul>
                            </li>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        @endif
                    </ul>
            </div>
        </div>
    </nav>

    <div id="content" class="container">
        @yield('content')
    </div>
</div>
</body>
<script>
    function formatExport(data, header) {
        if (header){
            data = data.split("<br>")[0];
        }
        return data.replace(/<(?:.|\n)*?>/gm, '').replace(/(\r\n|\n|\r)/gm, "").replace(/ +(?= )/g, '').replace(/&amp;/g, ' & ').replace(/&nbsp;/g, ' ');
    }
    $(document).ready(function () {

        //Datatables
        var colExport = $("#table").data('export');
        console.log(colExport);
        if (colExport == undefined) {
            table = $('#table').DataTable({
                autoWidth: false,
                bSort: false,
                bLengthChange: false,
                "pageLength": 20,
                "language": {
                    "url": "{{route('index')}}/js/datatables/Vietnamese.json"
                },
            });
        } else {
            table = $('#table').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        text: 'Xuất ra Excel',
                        stripHtml: true,
                        decodeEntities: true,
                        columns: ':visible',
                        modifier: {
                            selected: true
                        },
                        exportOptions: {
                            columns: colExport,
                            format: {
                                header: function (data, row, column, node) {
                                    return formatExport(data);
                                },
                                body: function (data, row, column, node) {
                                    return formatExport(data);
                                }
                            }
                        }
                    }
                ],
                autoWidth: false,
                bSort: false,
                bLengthChange: false,
                "pageLength": 20,
                "language": {
                    "url": "{{route('index')}}/js/datatables/Vietnamese.json"
                },
            });
        }
        table.columns().every(function () {

            var that = this;
            $('input', this.header()).on('keyup change changeDate', function () {
                if (that.search() !== this.value) {
                    that.search(this.value).draw();
                }
            });
            $('select', this.header()).on('change', function () {
                if (that.search() !== this.value) {
                    that.search(this.value ? '^' + this.value + '$' : '', true, false).draw();
                }
            });
        });
        //End Datatable

        //Select2
        $(".js-example-basic-single").select2();
        //End select2

        //Datepicker
        $('.datepicker').datepicker({
            format: " yyyy", // Notice the Extra space at the beginning
            viewMode: "years",
            minViewMode: "years"
        });
        $('.datepicker').on('changeDate', function (ev) {
            $(this).datepicker('hide');
        });
        //End datepicker
        $('.datepicker2').datepicker({
            format: 'dd/mm/yyyy',
            dateFormat: 'dd/mm/yyyy',
            monthNames: ['Tháng Một', 'Tháng Hai', 'Tháng Ba', 'Tháng Tư', 'Tháng Năm', 'Tháng Sáu',
                'Tháng Bảy', 'Tháng Tám', 'Tháng Chín', 'Tháng Mười', 'Th.Mười Một', 'Th.Mười Hai'],
            monthNamesShort: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6',
                'Tháng 7', 'Tháng 8', 'Tháng 9', 'TH 10', 'TH 11', 'TH 12'],
            dayNames: ['Chủ Nhật', 'Thứ Hai', 'Thứ Ba', 'Thứ Tư', 'Thứ Năm', 'Thứ Sáu', 'Thứ Bảy'],
            dayNamesShort: ['CN', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7'],
            dayNamesMin: ['CN', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7'],
        });

        //Html editor
        tinymce.init({
            selector: 'textarea.myTextEditor'
        });
    });
</script>
</html>