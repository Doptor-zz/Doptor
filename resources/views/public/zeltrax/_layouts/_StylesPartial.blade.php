{!! HTML::style("assets/public/{$current_theme}/css/reset.css") !!}
{!! HTML::style("assets/public/{$current_theme}/css/style.css") !!}

{!! HTML::style("assets/public/{$current_theme}/css/font-awesome/css/font-awesome.min.css") !!}

<!-- responsive devices styles -->
{!! HTML::style("assets/public/{$current_theme}/css/responsive-leyouts.css", array('media'=>'screen')) !!}

<!-- mega menu -->
{!! HTML::style("assets/public/{$current_theme}/js/mainmenu/sticky.css") !!}
{!! HTML::style("assets/public/{$current_theme}/js/mainmenu/bootstrap.css") !!}
{!! HTML::style("assets/public/{$current_theme}/js/mainmenu/fhmm.css") !!}

<!-- REVOLUTION SLIDER -->
{!! HTML::style("assets/public/{$current_theme}/js/revolutionslider/rs-plugin/css/settings.css", array('media'=>'screen')) !!}
{!! HTML::style("assets/public/{$current_theme}/js/revolutionslider/css/slider_main.css", array('media'=>'screen')) !!}

@section('styles')
    {{-- Here goes the page level styles --}}
@show
