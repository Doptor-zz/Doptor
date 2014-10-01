<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
    <meta charset="utf-8" />
    <title>{{ $title }} :: {{ trans('cms.backend_dashboard') }}</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="{{ URL::to("assets/backend/default/plugins/bootstrap/css/bootstrap.min.css") }}" rel="stylesheet" />
    <link href="{{ URL::to("assets/backend/default/plugins/bootstrap/css/bootstrap-responsive.min.css") }}" rel="stylesheet" />
    <link href="{{ URL::to("assets/backend/default/plugins/font-awesome/css/font-awesome.css") }}" rel="stylesheet" />
    <link href="{{ URL::to("assets/backend/default/css/style.css") }}" rel="stylesheet" />
    <link href="{{ URL::to("assets/backend/default/css/style-responsive.css") }}" rel="stylesheet" />
    <link href="{{ URL::to("assets/backend/default/css/themes/default.css") }}" rel="stylesheet" id="style_color" />
    <link href="{{ URL::to("assets/backend/default/plugins/uniform/css/uniform.default.css") }}" rel="stylesheet" type="text/css" />
    <link href="#" rel="stylesheet" id="style_metro" />
    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN PAGE LEVEL STYLES -->
    <link href="{{ URL::to("assets/backend/default/css/pages/login.css") }}" rel="stylesheet" type="text/css" />
    <link rel="shortcut icon" href="{{URL::to("assets/favicon.ico")}}">
    <!-- END PAGE LEVEL STYLES -->
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body>
    <!-- BEGIN LOGO -->
    <div id="logo" class="center">
        <img src="{{ URL::to("assets/backend/default/img/logo.png") }}" alt="logo" class="center" />
    >
    </div>
    <!-- END LOGO -->
    <!-- BEGIN LOGIN -->
    <div id="login">

        <div id="notifications">
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

        @yield('content')

    </div>
    <!-- END LOGIN -->
    <!-- BEGIN COPYRIGHT -->
    <div id="login-copyright">
        {{ Setting::value('footer_text') }}
    </div>
    <!-- END COPYRIGHT -->
    <!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
    <!-- BEGIN CORE PLUGINS -->
    <script src="{{ URL::to("assets/backend/default/plugins/jquery-1.8.3.min.js") }}" type="text/javascript"></script>
    <!-- IMPORTANT! Load jquery-ui-1.10.1.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
    <script src="{{ URL::to("assets/backend/default/plugins/jquery-ui/jquery-ui-1.10.1.custom.min.js") }}" type="text/javascript"></script>
    <script src="{{ URL::to("assets/backend/default/plugins/bootstrap/js/bootstrap.min.js") }}" type="text/javascript"></script>
    <!--[if lt IE 9]>
    <script src="{{ URL::to("assets/backend/default/plugins/excanvas.js") }}"></script>
    <script src="{{ URL::to("assets/backend/default/plugins/respond.js") }}"></script>
    <![endif]-->
    <script src="{{ URL::to("assets/backend/default/plugins/breakpoints/breakpoints.js") }}" type="text/javascript"></script>
    <script src="{{ URL::to("assets/backend/default/plugins/jquery.blockui.js") }}" type="text/javascript"></script>
    <script src="{{ URL::to("assets/backend/default/plugins/jquery.cookie.js") }}" type="text/javascript"></script>
    <script src="{{ URL::to("assets/backend/default/plugins/uniform/jquery.uniform.min.js") }}" type="text/javascript"></script>
    <!-- END CORE PLUGINS -->
    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <script src="{{ URL::to("assets/backend/default/scripts/app.js") }}"></script>
    <script src="{{ URL::to("assets/backend/default/scripts/login.js") }}"></script>
    <!-- END PAGE LEVEL SCRIPTS -->
    <script>
        jQuery(document).ready(function () {
            // initiate layout and plugins
            App.init();
            Login.init();
        });
    </script>
    <!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>
