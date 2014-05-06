<!DOCTYPE html>
<!--[if IE 7]>                  <html class="ie7 no-js" lang="en">     <![endif]-->
<!--[if lte IE 8]>              <html class="ie8 no-js" lang="en">     <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--> <html class="not-ie no-js" lang="en">  <!--<![endif]-->
<head>

    <!-- Basic Page Needs
  ================================================== -->
    <meta charset="utf-8">
    <title>{{ Services\MenuManager::getTitle($title) }}</title>
    @section('meta_description')
        {{-- Here goes the meta_description --}}
    @show
    @section('meta_keywords')
        {{-- Here goes the meta_keywords --}}
    @show

    <!-- Mobile Specific Metas
  ================================================== -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <!-- CSS
  ================================================== -->
    @include("public.default._layouts._StylesPartial")

    <!-- Favicons
    ================================================== -->
    <link rel="shortcut icon" href="{{URL::to("assets/favicon.ico")}}">

    <!-- For Old Browsers
    ================================================== -->
    <!--[if lt IE 8]>
    <div style=' clear: both; text-align:center; position: relative;'>
        <a href="http://www.microsoft.com/windows/internet-explorer/default.aspx?ocid=ie6_countdown_bannercode"><img src="http://storage.ie6countdown.com/assets/100/images/banners/warning_bar_0000_us.jpg" border="0" alt="" /></a>
    </div>
    <![endif]-->

</head>
<body class="page home-page">
    <!-- Primary Page Layout
    ================================================== -->

    <!-- BEGIN WRAPPER -->
    <div id="wrapper">

            <!-- BEGIN HEADER -->
            @include("public.default._layouts._HeaderPartial")
            <!-- END HEADER -->

            @section('slider')
                {{-- Here goes the slider --}}
            @show

            @section('heading')
                {{-- Here goes the heading --}}
            @show

            <!-- BEGIN CONTENT HOLDER -->
            <div id="content-wrapper" class="large-text">

                @yield('content')

            </div>
            <!-- END CONTENT HOLDER -->

            @include("public.default._layouts._FooterPartial")

    </div>
    <!-- END WRAPPER -->

    <!-- Javascript Files
    ================================================== -->
    @include("public.default._layouts._ScriptsPartial")

</body>
</html>
