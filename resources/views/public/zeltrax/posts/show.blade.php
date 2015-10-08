{{-- Update the Meta Description --}}
@section('meta_description')
    @if ($post->meta_description)
        <meta name="description" content="{!! $post->meta_description !!}" />
    @endif
@stop

{{-- Update the Meta Keywords --}}
@section('meta_keywords')
    @if ($post->meta_keywords)
        <meta name="keywords" content="{!! $post->meta_keywords !!}" />
    @endif
@stop

@section('heading')

    <!-- BEGIN PAGE HEADING -->
        <section id="heading">

            <div class="container">

                <div class="grid_8">
                    <!-- BEGIN PAGE HEADING -->
                    <header class="page-heading">
                        <?php
                            $menu = Menu::published()
                                    ->where(function($query) {
                                        $query->where('link', '=', Request::path())
                                                ->orWhere('link_manual', '=', Request::path());
                                    })
                                    ->first();
                            if ($menu) {
                                $type = $menu->title;
                            } else {
                                $type = 'News';
                            }
                        ?>
                        <h1>{!! $type !!}</h1>
                        <nav class="breadcrumbs">
                            <ul>
                                <li><a href="{!! url('/') !!}">home</a></li>
                                @if (Request::is('pages/*'))
                                    <li><a href="{!! url('pages') !!}">pages</a></li>
                                @else
                                    <li><a href="{!! url('posts') !!}">{!! $type !!}</a></li>
                                @endif
                                <li class="current">{!! $post->permalink !!}</li>
                            </ul>
                        </nav>
                    </header>
                    <!-- END PAGE HEADING -->
                </div>

            </div>

        </section>
    <!-- END PAGE HEADING -->
@stop

@section('content')
    <div class="container">

        <div class="content_left">

            <div class="blog_post">
                <div class="blog_postcontent">
                    @if ($post->image)
                        <div class="image_frame">
                            <img src="{!! url($post->image) !!}" alt="" width="636" height="179" border="0" />
                        </div>
                    @endif
                    @if ($type == 'post')
                        <strong>{!! $post->date() !!}</i>
                    @endif
                    <h3>
                        {!! HTML::link('posts/'.$post->permalink, $post->title) !!}
                    </h3>

                    <div class="post_info_content">
                        {!! $post->content !!}
                    </div>
                </div>
            </div><!-- /# end post -->

            <div class="clearfix divider_dashed9"></div>

            <div class="clearfix mar_top2"></div>

        </div><!-- end content left side -->

        <!-- BEGIN SIDEBAR -->
        @include("public.{$current_theme}.posts.sidebar")
        <!-- END SIDEBAR -->

    </div>
@stop

@section('scripts')
    @if ($post->type != 'post')
    <script>
        $(function() {
            $('.custom-menu-widget').find(".navbar-nav").removeClass('navbar-nav');

            $header_menu = $('header .navbar-nav>li');

            for (i=0; i<=($header_menu.length/2)-1; i++) {
                $header_menu[i].remove();
            }
        });
    </script>
    @endif
@stop
