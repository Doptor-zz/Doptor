@section('styles')
    <style>
    </style>
@stop

@section('content')
    <div class="container">

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
        <ul class="breadcrumb">
            <li><a href="{!! url('/') !!}">Home</a></li>
            @if (Request::is('posts/category*'))
                <li><a href="{!! url('posts') !!}">{!! ucwords($type) !!}</a></li>
                <li>Category</li>
                <li class="current">{!! ucwords($category->name) !!}</li>
            @elseif (Request::is('pages/category*'))
                <li><a href="{!! url('pages') !!}">Pages</a></li>
                <li>category</li>
                <li class="current">{!! ucwords($category->name) !!}</li>
            @elseif (Request::is('pages*'))
                <li class="current">Pages</li>
            @else
                <li class="current">Posts</li>
            @endif
        </ul>

        <div class="row margin-bottom-40">

            <div class="col-md-12 col-sm-12">

                <div class="content-page">
                    <!-- BEGIN POST -->
                    <div class="row">
                        <div class="col-md-9 col-sm-9 blog-posts">
                            @if (sizeof($posts) != 0)
                                @foreach ($posts as $post)
                                    <div class="row">
                                    @if ($post->image)
                                        <div class="col-md-4 col-sm-4">
                                            <img class="img-responsive" src="{!! url($post->thumb) !!}" />
                                        </div>
                                        <div class="col-md-8 col-sm-8">
                                    @else
                                        <div class="col-md-12 col-sm-12">
                                    @endif
                                        {!! HTML::link(url('posts/'.$post->permalink), $post->title) !!}
                                        <ul class="blog-info">
                                            <li><i class="fa fa-calendar"></i> {!! $post->created_at->toDateString() !!}</li>
                                            <li>
                                                <i class="fa fa-tags"></i>
                                                @foreach ($post->categories as $category)
                                                {!! HTML::link(url('posts/category/'.$category->alias), $category->name) !!}
                                                @endforeach
                                            </li>
                                        </ul>
                                        <p>{!! $post->excerpt(540) !!}</p>
                                        <a href="{!! url('posts/'.$post->permalink) !!}" class="more">read more <i class="fa fa-angle-right"></i></a>
                                      </div>
                                    </div>
                                @endforeach

                                <!-- BEGIN PAGINATION -->
                                {!! $posts->render() !!}
                                <!-- END PAGINATION -->
                            @else
                                <div class="row">

                                    <!-- begin post heading -->
                                    <header class="entry-header">
                                        <h2 class="entry-title">
                                            Sorry! No posts was found
                                        </h2>
                                    </header>
                                    <!-- end post heading -->

                                </div>
                            @endif
                        </div>

                        <!-- BEGIN SIDEBAR -->
                        @include("public.$current_theme.posts.sidebar")
                        <!-- END SIDEBAR -->
                    </div>
                    <!-- END POST -->
                </div>

            </div>

        </div>

    </div>
@stop
