<!-- Normalize default styles -->
<link rel="stylesheet" href="{{URL::to("assets/public/default/css/normalize.css")}}" media="screen" />
<!-- Fonts -->
<link rel="stylesheet" href="{{URL::to("assets/public/default/css/fonts.css")}}" media="screen" />
<!-- Skeleton grid system -->
<link rel="stylesheet" href="{{URL::to("assets/public/default/css/skeleton.css")}}" media="screen" />
<!-- Base Template Styles-->
<link rel="stylesheet" href="{{URL::to("assets/public/default/css/base.css")}}" media="screen" />
<!-- Superfish Menu-->
<link rel="stylesheet" href="{{URL::to("assets/public/default/css/superfish.css")}}" media="screen" />
<!-- Template Styles-->
<link rel="stylesheet" href="{{URL::to("assets/public/default/css/style.css")}}" media="screen" />
<!-- PrettyPhoto -->
<link rel="stylesheet" href="{{URL::to("assets/public/default/css/prettyPhoto.css")}}" media="screen" />
<!-- Layout and Media queries-->
<link rel="stylesheet" href="{{URL::to("assets/public/default/css/layout.css")}}" media="screen" />
<link rel="stylesheet" href="{{URL::to("assets/public/default/css/chosen.min.css")}}" media="screen" />
<!--[if lt IE 9]>
    <link rel="stylesheet" href="{{URL::to("assets/public/default/css/ie/ie8.css")}}" media="screen" />
<![endif]-->

<!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

@section('styles')
    {{-- Here goes the page level styles --}}
@show
