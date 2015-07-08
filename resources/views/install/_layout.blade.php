<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta name="viewport" content="width=device-width" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{!! $title !!} - Setup Configuration</title>
    <link rel="stylesheet" href="{!! url('assets/shared/install/styles.css') !!}" type="text/css" />
    <link rel="shortcut icon" href="{!!URL::to("assets/favicon.ico")!!}">
</head>
<body>
    <h1 id="logo">
        {!! HTML::image('assets/shared/install/logo.png') !!}
    </h1>
    <div id="errors-div">
        @if (Session::has('error_message'))
            <div class="alert alert-error">
                <strong>Error!</strong> {!! Session::get('error_message') !!}
            </div>
        @endif
        @if (Session::has('success_message'))
            <div class="alert alert-success">
                <strong>Success!</strong> {!! Session::get('success_message') !!}
            </div>
        @endif
    </div>

    @yield('content')

    @section('scripts')
    @show
</body>
</html>
