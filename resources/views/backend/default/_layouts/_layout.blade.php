<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
    <meta charset="utf-8" />
    <title>{!! $title !!} :: {!! trans('cms.backend_dashboard') !!}</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />
    <meta name="csrf-token" content="{!! csrf_token() !!}">
    <!-- BEGIN STYLES -->
    @include("backend.default._layouts._StylesPartial")
    <link rel="shortcut icon" href="{!!URL::to("assets/favicon.ico")!!}">
    <!-- END STYLES -->
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="fixed-top">
    <!-- BEGIN HEADER -->
    @include("backend.default._layouts._HeaderPartial")
    <!-- END HEADER -->
    <!-- BEGIN CONTAINER -->
    <div id="container" class="row-fluid">
        <!-- BEGIN SIDEBAR -->
        @include("backend.default._layouts._MainMenuPartial")
        <!-- END SIDEBAR -->
        <!-- BEGIN PAGE -->
        <div id="body">
            <!-- BEGIN PAGE CONTAINER-->
            <div class="container-fluid">
                <!-- BEGIN PAGE HEADER-->
                <div class="row-fluid">
                    <div class="span12">
                        <!-- BEGIN STYLE CUSTOMIZER-->
                       <!--  <div id="styler" class="hidden-phone">
                            <i class="icon-cog"></i>
                            <span class="settings">
                                <span class="text">Style:</span>
                                <span class="colors">
                                    <span class="color-default" data-style="default">
                                    </span>
                                    <span class="color-grey" data-style="grey">
                                    </span>
                                    <span class="color-navygrey" data-style="navygrey">
                                    </span>
                                    <span class="color-red" data-style="red">
                                    </span>
                                </span>
                                <span class="layout">
                                    <label class="hidden-phone">
                                        <input type="checkbox" class="header" checked value="" />Sticky Header
                                    </label><br />
                                    <label><input type="checkbox" class="metro" value="" />Metro Style</label>
                                </span>
                            </span>
                        </div> -->
                        <!-- END STYLE CUSTOMIZER-->
                        <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                        <h3 class="page-title">
                            {!! $title !!}
                        </h3>
                        <ul class="breadcrumb">
                            <li>
                                <i class="icon-home"></i>
                                <a href="{!! URL::to('backend') !!}">{!! trans('cms.dashboard') !!}</a>
                                <i class="icon-angle-right"></i>
                            </li>
                            <li><a href="#">{!! $title !!}</a></li>
                        </ul>
                        <!-- END PAGE TITLE & BREADCRUMB-->
                    </div>
                </div>
                <!-- END PAGE HEADER-->
                <!-- BEGIN PAGE CONTENT-->
                <div id="errors-div">
                    @if (Session::has('error_message'))
                        <div class="alert alert-error">
                            <button data-dismiss="alert" class="close">×</button>
                            <strong>{!! trans('cms.error') !!}</strong> {!! Session::get('error_message') !!}
                        </div>
                    @endif
                    @if (Session::has('success_message'))
                        <div class="alert alert-success">
                            <button data-dismiss="alert" class="close">×</button>
                            <strong>{!! trans('cms.success') !!}</strong> {!! Session::get('success_message') !!}
                        </div>
                    @endif
                </div>
                @yield('content')

                <div id="ajax-insert-modal" class="modal hide fade page-container" tabindex="-1"></div>
                <div id="ajax-add-modal" class="modal hide fade page-container" tabindex="-1"></div>
                <!-- END PAGE CONTENT-->
            </div>
            <!-- END PAGE CONTAINER-->
        </div>
        <!-- END PAGE -->
    </div>
    <!-- END CONTAINER -->
    <!-- BEGIN FOOTER -->
    @include("backend.default._layouts._FooterPartial")
    <!-- END FOOTER -->
    <!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
    @include("backend.default._layouts._ScriptsPartial")
    {{-- @RenderSection("scripts", required: false) --}}
    <!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>
