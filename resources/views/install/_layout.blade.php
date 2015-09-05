<!DOCTYPE html>
<head>
    <meta name="viewport" content="width=device-width" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{!! $title !!} - Setup Configuration</title>
    <link rel="stylesheet" href="{!! url('assets/shared/install/styles.css') !!}" type="text/css" />
    <link rel="shortcut icon" href="{!!URL::to("assets/favicon.ico")!!}">

    @section('style')
    @show
</head>
<body>
    <div id="wrapper">
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
    </div>

    @section('scripts')
    @show
</body>
</html>
