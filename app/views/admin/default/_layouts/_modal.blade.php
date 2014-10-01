<!DOCTYPE html>

<html lang="en">

<head id="Starter-Site">

    <title>{{{ $title }}} :: {{ trans('cms.admin_dashboard') }}</title>

    @section('styles')
        {{-- Here goes the page level styles --}}
    @show
    <link rel="shortcut icon" href="{{URL::to("assets/favicon.ico")}}">

</head>

<body>
    <!-- Container -->
    <div class="admin-modal modal-body">

        <div class="container-fluid">
            @yield('content')
        </div>

    </div>
    <!-- ./ container -->

    <!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
    @section('scripts')
        {{-- Here goes the page level scripts --}}
    @show

</body>

</html>
