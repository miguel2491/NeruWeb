<head>
    <meta charset="utf-8">
    <title> NERU | @yield('htmlheader_title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet">

    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="msapplication-TileImage" content="/mstile-144x144.png">
    <meta name="theme-color" content="#ffffff">

    <!-- jqGrid -->
    <link href="{{ asset('css/plugins/jQueryUI/jquery-ui.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/plugins/slickgrid/slick.grid.css') }}" type="text/css"/>
    <link rel="stylesheet" href="{{ asset('css/plugins/slickgrid/slick-bootstrap.css') }}" type="text/css"/>

    <link href="{{ asset('css/plugins/dataTables/datatables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/plugins/dataTables/buttons.dataTables.min.css') }}" rel="stylesheet">

    <link href="{{ asset('css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">



    <!-- iCheck style incluir asset-->
    <link href="{{ asset('css/plugins/iCheck/skins/all.css') }}" rel="stylesheet">

    <!-- Toastr style -->
    <link href="{{ asset('css/plugins/toastr/toastr.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/css_select/bootstrap-select.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/autocompletar.css') }}" rel="stylesheet">

    <!-- <link href="{{ asset('css/plugins/datapicker/datepicker3.css') }}" rel="stylesheet"> -->
    <link href="{{ asset('css/plugins/select2/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/plugins/touchspin/jquery.bootstrap-touchspin.min.css') }}" rel="stylesheet">
</head>