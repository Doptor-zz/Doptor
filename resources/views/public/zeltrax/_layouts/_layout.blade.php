<!doctype html>
<!--[if IE 7 ]>    <html lang="en-gb" class="isie ie7 oldie no-js"> <![endif]-->
<!--[if IE 8 ]>    <html lang="en-gb" class="isie ie8 oldie no-js"> <![endif]-->
<!--[if IE 9 ]>    <html lang="en-gb" class="isie ie9 no-js"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html lang="en-gb" class="no-js"> <!--<![endif]-->

<head>

    <title>{!! Services\MenuManager::getTitle($title) !!}</title>
    @section('meta_description')
    {{-- Here goes the meta_description --}}
    @show
    @section('meta_keywords')
    {{-- Here goes the meta_keywords --}}
    @show

    <!-- Favicon -->
    <link rel="shortcut icon" href="images/favicon.ico">

    <!-- this styles only adds some repairs on idevices  -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Google fonts - witch you want to use - (rest you can just remove) -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300,300italic,400,400italic,600,600italic,700,700italic,800,800italic' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Raleway:100,200,300,400,500,600,700,800,900' rel='stylesheet' type='text/css'>

    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- ######### CSS STYLES ######### -->
    @include("public.{$current_theme}._layouts._StylesPartial")

</head>

<body>
    <div class="site_wrapper">

        @include("public.{$current_theme}._layouts._HeaderPartial")

        <!-- Slider
        ======================================= -->
        @section('slider')
        {{-- Here goes the slider --}}
        @show

        @yield('content')

        @include("public.{$current_theme}._layouts._FooterPartial")

        <!-- ######### JS FILES ######### -->
        @include("public.{$current_theme}._layouts._ScriptsPartial")
    </div>

</body>
</html>
