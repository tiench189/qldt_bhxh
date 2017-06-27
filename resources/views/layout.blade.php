<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="{{env('ALIAS')}}/img/favicon.ico">
    <script src="{{env('ALIAS')}}/js/jquery-3.1.1.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src="{{env('ALIAS')}}/js/bootstrap.min.js"></script>
    <script src="{{env('ALIAS')}}/js/select2.js"></script>
    <script src="{{$_ENV['ALIAS']}}/js/bootstrap-datepicker.js"></script>

    <link href="{{env('ALIAS')}}/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="{{env('ALIAS')}}/css/main.css" rel="stylesheet" type="text/css">
    <link href="{{env('ALIAS')}}/css/select2.css" rel="stylesheet" type="text/css">
    <link href="{{$_ENV['ALIAS']}}/css/datepicker.css" rel="stylesheet">

    <!-- Datatable -->
    <link rel="stylesheet" type="text/css"
          href="{{env('ALIAS')}}/js/datatables/DataTables-1.10.13/css/dataTables.bootstrap.min.css"/>
    <script type="text/javascript"
            src="{{env('ALIAS')}}/js/datatables/DataTables-1.10.13/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript"
            src="{{env('ALIAS')}}/js/datatables/DataTables-1.10.13/js/dataTables.bootstrap.min.js"></script>
    <title>@section('page-title')
        @show</title>
</head>
<body>
<div id="wrapper" class="container no-padding">
    <header id="page-header" class="clearfix">
        <div class="container-fluid">
            <a class="logo" href="/">
                <img src="{{env('ALIAS')}}/img/logo.png" class="logo">
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
                        <a href="{{env('ALIAS')}}/course" class="dropdown-toggle" data-toggle="dropdown">Khóa đào tạo <b
                                    class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <?php $categories = \App\Utils::listCategories()?>
                            @foreach($categories as $idx=>$cate)
                                @if($idx > 0)
                                    <li class="divider"></li>
                                @endif
                                <li><a href="#">{{$cate->name}}</a></li>
                            @endforeach
                        </ul>
                    </li>
                    <li><a href="{{env('ALIAS')}}/teacher">Giảng viên</a></li>
                    <li><a href="{{env('ALIAS')}}/hocvien">Học viên</a></li>
                    <li><a href="#">Tra cứu</a></li>
                    <li><a href="#">Báo cáo</a></li>
                    <li><a href="#">Phiếu khảo sát</a></li>
                </ul>
                <form class="navbar-form navbar-left hidden" role="search">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Search">
                    </div>
                    <button type="submit" class="btn btn-default">Submit</button>
                </form>
                <ul class="nav navbar-nav navbar-right hidden">
                    <li><a href="#">Link</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="#">Action</a></li>
                            <li><a href="#">Another action</a></li>
                            <li><a href="#">Something else here</a></li>
                            <li class="divider"></li>
                            <li><a href="#">Separated link</a></li>
                        </ul>
                    </li>
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
    $(document).ready(function () {

        //Datatables
        table = $('#table').DataTable({
            autoWidth: false,
            bSort: false,
            bLengthChange: false,
            "pageLength": 20,
            "language": {
                "url": "{{$_ENV['ALIAS']}}/js/datatables/Vietnamese.json"
            },
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
    });
</script>
</html>