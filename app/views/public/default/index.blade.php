@section('styles')
    <!-- Flexslider -->
    {{ HTML::style("assets/public/default/css/flexslider.css") }}
@stop

@section('scripts')
    <!-- Flexslider -->
    {{ HTML::script("assets/public/default/js/jquery.flexslider.js") }}

    <!-- Flexslider Init -->
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
        <section id="slider" class="loading">

            <div class="container">
                <div class="grid_12">

                    <div class="flexslider">
                        <ul class="slides">
                            <!-- Begin Single Slide -->
                            @foreach ($slides as $slide)
                                <li>
                                    <img src="{{ URL::to($slide->image) }}" />
                                    <div class="slide-caption">
                                        {{ $slide->caption }}
                                    </div>
                                </li>
                            @endforeach
                            <!-- End Single Slide -->
                        </ul>
                    </div>

                </div>
            </div>

        </section>
        <!-- END SLIDER -->
    @endif
@stop

@section('content')
    <section class="indent">
        <div class="container">
            <div class="grid_12">
                @if (isset($page))
                    <h2>{{ $page->title }}</h2>

                    {{ $page->content }}
                @else
                    <h2>Welcome</h2>

                    <p>The CMS public section can now be viewed at {{ HTML::link(url('/'), url('/')) }}</p>

                    <p>The CMS admin can now be viewed at {{ HTML::link(url('admin'), url('admin')) }}</p>

                    <p>The CMS backend can now be viewed at {{ HTML::link(url('backend'), url('backend')) }}</p>
                @endif
            </div>
        </div>
    </section>
@stop
