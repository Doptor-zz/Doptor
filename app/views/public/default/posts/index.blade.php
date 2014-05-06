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
                            <h1>{{ $type }}</h1>
                            <nav class="breadcrumbs">
                                <ul>
                                    <li><a href="{{ url('/') }}">home</a></li>
                                    @if (Request::is('posts/category*'))
                                        <li><a href="{{ url('posts') }}">{{ $type }}</a></li>
                                        <li>category</li>
                                        <li class="current">{{ $category->name }}</li>
                                    @elseif (Request::is('pages/category*'))
                                        <li><a href="{{ url('pages') }}">pages</a></li>
                                        <li>category</li>
                                        <li class="current">{{ $category->name }}</li>
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
    <section class="indent">

        <div class="container">

            <div id="content" class="grid_8">


                <!-- BEGIN POST -->
                @if (sizeof($posts) != 0)
                    @foreach ($posts as $post)
                        <article class="post">

                            <!-- begin post heading -->
                            <header class="entry-header">
                                <h2 class="entry-title">
                                    {{ HTML::link(url('posts/'.$post->permalink), $post->title) }}
                                </h2>
                            </header>
                            <!-- end post heading -->

                            <!-- begin post content -->
                            <div class="entry-content">
                                <!-- begin post image -->
                                <figure class="featured-thumbnail full-width">
                                    <span class="meta-date">
                                        <span class="meta-date-inner">
                                            {{ $post->date() }}
                                        </span>
                                    </span>
                                    <a href="{{ url('posts/'.$post->permalink) }}"><img src="{{ url($post->thumb) }}" alt="" width="636" height="179" border="0" /></a>
                                    @if ($post->image)
                                    @endif
                                </figure>
                                <!-- end post image -->
                                {{ $post->excerpt(540) }}
                            </div>
                            <!-- end post heading -->

                            <!-- begin post meta -->
                            <footer class="entry-footer">
                                <div class="fleft">
                                    Categories:
                                    @foreach ($post->categories as $category)
                                        {{ HTML::link(url('posts/category/'.$category->alias), $category->name) }}
                                    @endforeach
                                </div>
                                <div class="fright">
                                    <a href="{{ url('posts/'.$post->permalink) }}" class="full-post-link">read more</a>
                                </div>
                            </footer>
                            <!-- end post meta -->

                        </article>
                    @endforeach
                @else
                    <article class="post">

                        <!-- begin post heading -->
                        <header class="entry-header">
                            <h2 class="entry-title">
                                Sorry! No posts was found
                            </h2>
                        </header>
                        <!-- end post heading -->

                    </article>
                @endif
                <!-- END POST -->


                <!-- BEGIN PAGINATION -->
                {{ $posts->links() }}
                <!-- END PAGINATION -->


            </div>

            <!-- BEGIN SIDEBAR -->
            @include('public.default.posts.sidebar')
            <!-- END SIDEBAR -->

        </div>

    </section>
@stop
