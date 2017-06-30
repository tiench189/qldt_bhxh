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
                    <li class="dropdown active">
                        <a href="{{route('index')}}/course" class="dropdown-toggle" data-toggle="dropdown">Khóa đào tạo <b
                                    class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <?php $categories = \App\Utils::listCategories()?>
                            @foreach($categories as $idx=>$cate)
                                @if($idx > 0)
                                    <li class="divider"></li>
                                @endif
                                <li><a href="{{route('course-index', ['c' => $cate->id])}}">{{$cate->name}}</a></li>
                            @endforeach
                        </ul>
                    </li>
                    <li><a href="{{route('teacher-index')}}">Giảng viên</a></li>
                    <li><a href="{{route('hocvien-index')}}">Học viên</a></li>
                    <li><a href="{{route('tracuu')}}">Tra cứu</a></li>
                    <li><a href="#">Báo cáo</a></li>
                    <li><a href="#">Phiếu khảo sát</a></li>
                </ul>
                <form class="navbar-form navbar-left hidden" role="search">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Search">
                    </div>
                    <button type="submit" class="btn btn-default">Submit</button>
                </form>
                @if(\Illuminate\Support\Facades\Session::get('isAuth', false))
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
                @endif
            </div>
        </div>
    </nav>

    <div id="content" class="container">
        @yield('content')
    </div>
</div>
</body>
<script>
    function formatExport(data) {
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
    });
</script>
</html>