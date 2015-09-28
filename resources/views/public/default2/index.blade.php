@section('styles')
    <!-- Page level plugin styles START -->
    {!! HTML::style("assets/public/$current_theme/plugins/flexslider/flexslider.css") !!}
    <!-- Page level plugin styles END -->
    <style>
        .flexslider {
            max-height: 550px;
        }
        .flexslider img {
            max-height: 550px;
        }
    </style>
@stop

@section('scripts')
    <!-- BEGIN RevolutionSlider -->

    {!! HTML::script("assets/public/$current_theme/plugins/flexslider/jquery.flexslider.js") !!}
    <!-- END RevolutionSlider -->

    <script type="text/javascript">

        $(window).load(function(){
            $('.flexslider').flexslider({
                animation: "fade",
                controlNav: false,
                // Callback API
                before: function(){},
                after: function(){},
                start: function(slider){
                   $('#slider').removeClass('loading');
                }
            });
        });

    </script>
@stop

@section('slider')
    @if ($slides->count() > 0)
        <!-- BEGIN SLIDER -->
        <div class="page-slider margin-bottom-40">
            <div class="fullwidthbanner-container">
                <div class="flexslider">
                        <ul class="slides">
                            <!-- Begin Single Slide -->
                            @foreach ($slides as $slide)
                                <li>
                                    <img src="{!! URL::to($slide->image) !!}" />
                                    <div class="slide-caption">
                                        {!! $slide->caption !!}
                                    </div>
                                </li>
                            @endforeach
                            <!-- End Single Slide -->
                        </ul>
                    </div>
            </div>
        </div>
        <!-- END SLIDER -->

    @endif
@stop

@section('content')
    <div class="container margin-bottom-40">
        <div class="row">
            <div class="col-md-12">
                @if (isset($page))
                    <h2>{!! $page->title !!}</h2>

                    {!! $page->content !!}
                @else
                    <h2>Welcome</h2>

                    <p>The CMS public section can now be viewed at {!! HTML::link(url('/'), url('/')) !!}</p>

                    <p>The CMS admin can now be viewed at {!! HTML::link(url('admin'), url('admin')) !!}</p>

                    <p>The CMS backend can now be viewed at {!! HTML::link(url('backend'), url('backend')) !!}</p>
                @endif
            </div>
        </div>
    </div>
@stop
