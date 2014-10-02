<!DOCTYPE HTML>
<html lang="en">
<head>
<meta charset="utf-8">
<title>{{ $title }} :: {{ trans('cms.admin_dashboard') }}</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="Admin Panel Template">
<meta name="author" content="Westilian: Kamrujaman Shohel">
<!-- styles -->
<link href="{{url("assets/admin/default/css/bootstrap.css")}}" rel="stylesheet">
<link href="{{url("assets/admin/default/css/bootstrap-responsive.css")}}" rel="stylesheet">
<link rel="stylesheet" href="{{url("assets/admin/default/css/font-awesome.css")}}">
<!--[if IE 7]>
            <link rel="stylesheet" href="{{url("assets/admin/default/css/font-awesome-ie7.min.css")}}">
        <![endif]-->
<link href="{{url("assets/admin/default/css/styles.css")}}" rel="stylesheet">
<link href="{{url("assets/admin/default/css/theme-blue.css")}}" rel="stylesheet">

<!--[if IE 7]>
            <link rel="stylesheet" type="text/css" href="{{url("assets/admin/default/css/ie/ie7.css")}}" />
        <![endif]-->
<!--[if IE 8]>
            <link rel="stylesheet" type="text/css" href="{{url("assets/admin/default/css/ie/ie8.css")}}" />
        <![endif]-->
<!--[if IE 9]>
            <link rel="stylesheet" type="text/css" href="{{url("assets/admin/default/css/ie/ie9.css")}}" />
        <![endif]-->
<link href="{{url("assets/admin/default/css/aristo-ui.css")}}" rel="stylesheet">
<link href="{{url("assets/admin/default/css/elfinder.css")}}" rel="stylesheet">
<link href='http://fonts.googleapis.com/css?family=Dosis' rel='stylesheet' type='text/css'>
<!--fav and touch icons -->
<link rel="shortcut icon" href="{{URL::to("assets/favicon.ico")}}">
<!--============j avascript===========-->
<script src="{{url("assets/admin/default/js/jquery.js")}}"></script>
<script src="{{url("assets/admin/default/js/jquery-ui-1.10.1.custom.min.js")}}"></script>
<script src="{{url("assets/admin/default/js/bootstrap.js")}}"></script>
</head>
<body>
<div class="layout">
    <!-- Navbar================================================== -->
    <div class="navbar navbar-inverse top-nav">
        <div class="navbar-inner">
            <div class="container">
                <span class="home-link"><a href="{{ URL::to('admin') }}" class="icon-home"></a></span><a class="brand" href="{{ URL::to('admin') }}"><img src="{{url("assets/admin/default/images/logo.png")}}" alt="Doptor"></a>
                <div class="btn-toolbar pull-right notification-nav">
                    <div class="btn-group">
                        <div class="dropdown">
                            <a class="btn btn-notification"><i class="icon-reply"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @yield('content')
</div>
</body>
</html>
