<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->

    <!-- Basic Page Needs
  ================================================== -->
    <meta charset="utf-8">
    <title>{!! Services\MenuManager::getTitle($title) !!}</title>
    @section('meta_description')
        {{-- Here goes the meta_description --}}
    @show
    @section('meta_keywords')
        {{-- Here goes the meta_keywords --}}
    @show

    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

    <!-- CSS
  ================================================== -->
    @include("public.$current_theme._layouts._StylesPartial")

    <!-- Favicons
    ================================================== -->
    <link rel="shortcut icon" href="{!!URL::to("assets/favicon.ico")!!}">

</head>
<body class="corporate">
    <!-- Primary Page Layout
    ================================================== -->

    <!-- BEGIN HEADER -->
    @include("public.$current_theme._layouts._HeaderPartial")
    <!-- END HEADER -->

    @section('slider')
        {{-- Here goes the slider --}}
    @show

    @section('heading')
        {{-- Here goes the heading --}}
    @show

    <!-- BEGIN CONTENT HOLDER -->
    <div class="main">

        @yield('content')

    </div>
    <!-- END CONTENT HOLDER -->

    @include("public.$current_theme._layouts._FooterPartial")

    <!-- Javascript Files
    ================================================== -->
    @include("public.$current_theme._layouts._ScriptsPartial")

</body>
</html>
