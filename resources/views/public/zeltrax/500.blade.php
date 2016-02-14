@extends("public.{$current_theme}._layouts._layout")

@section('content')
    <div class="container">

        <div class="content_fullwidth">

            <div class="error_pagenotfound">

                <strong>404</strong>
                <br />

                <em>{!! trans('public.500_message') !!}</em>

                <div class="clearfix margin_top3"></div>

            </div><!-- end error page notfound -->
        </div>
    </div>
@stop
