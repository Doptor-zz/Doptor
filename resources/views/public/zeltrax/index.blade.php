@section('styles')
    <!-- Flexslider -->

@stop

@section('scripts')

@stop

@section('slider')
    @if ($slides->count() > 0)
    <div class="container_full">
        <div class="tp-banner-container">
            <div class="tp-banner" >

                <ul>
                    @foreach ($slides as $slide)
                        <li>
                            <!-- MAIN IMAGE -->
                            <img src="{!! URL::to($slide->image) !!}" alt=""  data-bgfit="cover" data-bgposition="center top" data-bgrepeat="no-repeat" alt="{!! $slide->caption !!}">

                        </li>
                    @endforeach
                </ul>

            </div>
        </div><!-- end slider -->
    </div>
    @endif
@stop

@section('content')
    <div class="features_sec1">
        <div class="container">
            <div class="grid_12">
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

        <div class="clearfix"></div>
    </div>
@stop
