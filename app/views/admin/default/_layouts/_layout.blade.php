<!DOCTYPE HTML>
<html lang="en">
<head>
<meta charset="utf-8">
<title>{{ $title }} :: {{ trans('cms.admin_dashboard') }}</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="description" content="Admin Panel Template">
<meta name="author" content="">
<!-- styles -->
@include("admin.default._layouts._StylesPartial")

<!--fav and touch icons -->
<link rel="shortcut icon" href="{{URL::to("assets/favicon.ico")}}">
<!--============ javascript ===========-->
</head>
<body>
<div class="layout">
    <!-- Navbar
    ================================================== -->
    @include("admin.default._layouts._HeaderPartial")

    @include("admin.default._layouts._MainMenuPartial")

    <div class="main-wrapper">
        <div class="container-fluid">
            <div class="row-fluid ">
                <div class="span12">
                    <div class="primary-head">
                        <h3 class="page-header">{{ trans('cms.dashboard') }}</h3>
                    </div>
                    <ul class="breadcrumb">
                        <li><a href="#" class="icon-home"></a><span class="divider "><i class="icon-angle-right"></i></span></li>
                        <li><a href="{{ URL::to('admin') }}">{{ trans('cms.dashboard') }}</a><span class="divider"><i class="icon-angle-right"></i></span></li>
                        <li class="active">{{ $title }}</li>
                    </ul>
                </div>
            </div>
            <div id="errors-div">
                @if (Session::has('error_message'))
                    <div class="alert alert-error">
                        <button data-dismiss="alert" class="close">×</button>
                        <strong>Error!</strong> {{ Session::get('error_message') }}
                    </div>
                @endif
                @if (Session::has('success_message'))
                    <div class="alert alert-success">
                        <button data-dismiss="alert" class="close">×</button>
                        <strong>Success!</strong> {{ Session::get('success_message') }}
                    </div>
                @endif
            </div>
            <br>
            @yield('content')
        </div>
    </div>
    <div id="ajax-insert-modal" class="modal hide fade page-container" tabindex="-1"></div>
    <div id="ajax-add-modal" class="modal hide fade page-container" tabindex="-1"></div>
    @include("admin.default._layouts._FooterPartial")
</div>
@include("admin.default._layouts._ScriptsPartial")
</body>
</html>
