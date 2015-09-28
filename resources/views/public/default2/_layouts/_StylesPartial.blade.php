<!-- Fonts START -->
<link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700|PT+Sans+Narrow|Source+Sans+Pro:200,300,400,600,700,900&amp;subset=all" rel="stylesheet" type="text/css">
<!-- Fonts END -->

<!-- Global styles START -->
{!!HTML::style("assets/public/$current_theme/plugins/font-awesome/css/font-awesome.min.css")!!}
{!!HTML::style("assets/public/$current_theme/plugins/bootstrap/css/bootstrap.min.css")!!}
<!-- Global styles END -->

<!-- Theme styles START -->
{!!HTML::style("assets/public/$current_theme/css/components.css")!!}
{!!HTML::style("assets/public/$current_theme/css/style.css")!!}
{!!HTML::style("assets/public/$current_theme/css/style-responsive.css")!!}
{!!HTML::style("assets/public/$current_theme/css/themes/red.css")!!}
{!!HTML::style("assets/public/$current_theme/css/custom.css")!!}

@section('styles')
    {{-- Here goes the page level styles --}}
@show
