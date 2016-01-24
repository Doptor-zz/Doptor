@section('styles')
<style>
    .featured-thumbnail img {
        width: 636px !important;
        height: 179px !important;
    }
</style>
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
                        @if (Request::is('posts/category*'))
                        <li><a href="{!! url('posts') !!}">{!! $type !!}</a></li>
                        <li>category</li>
                        <li class="current">{!! $category->name !!}</li>
                        @elseif (Request::is('pages/category*'))
                        <li><a href="{!! url('pages') !!}">pages</a></li>
                        <li>category</li>
                        <li class="current">{!! $category->name !!}</li>
                        @elseif (Request::is('pages*'))
                        <li class="current">pages</li>
                        @else
                        <li class="current">posts</li>
                        @endif
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
<div class="content_fullwidth">

    <div class="container">

        <div class="content_left"><!-- BEGIN POST -->
            @if (sizeof($posts) != 0)
            @foreach ($posts as $post)
                <div class="blog_post">
                    <div class="blog_postcontent">
                    <div class="image_frame small">
                        <a href="{!! url('posts/'.$post->permalink) !!}">
                            <img src="{!! url($post->thumb) !!}" border="0" height="200" />
                        </a>
                    </div>
                    <div class="post_info_content_small">
                    <h3>
                        {!! HTML::link(url('posts/'.$post->permalink), $post->title) !!}
                    </h3>
                    <ul class="post_meta_links_small">
                        <li class="post_categoty">
                            Categories:
                            @foreach ($post->categories as $category)
                            {!! HTML::link(url('posts/category/'.$category->alias), $category->name) !!}
                            @endforeach
                        </li>
                    </ul>

                    <div class="clearfix"></div>

                    {!! $post->excerpt(300) !!}

                    </div>
                    </div>
                </div>
            @endforeach
            @else
                <div class="one_fourth">
                    <div class="box">
                        <article class="post">

                            <!-- begin post heading -->
                            <header class="entry-header">
                                <h2 class="entry-title">
                                    Sorry! No posts was found
                                </h2>
                            </header>
                            <!-- end post heading -->

                        </article>
                    </div>
                </div>
            @endif

            <!-- BEGIN PAGINATION -->
            {!! $posts->render() !!}
        </div>
        <!-- END PAGINATION -->

        <!-- BEGIN SIDEBAR -->
        @include("public.{$current_theme}.posts.sidebar")
        <!-- END SIDEBAR -->

    </div>

</div>
@stop
