<div class="col-md-3 col-sm-3 blog-sidebar">

    <?php $type = ($type == 'News') ? 'post' : 'page' ?>
    @if ($type == 'post' || $post->type == 'post')
        <!-- BEGIN CUSTOM MENU WIDGET -->
        <h2 class="no-top-space">Recent {!! Str::plural('post') !!}</h2>
        <ul class="nav sidebar-categories margin-bottom-40">
            @foreach (Post::type('post')->target('public')->published()->recent()->take(5)->get(array('title', 'permalink')) as $post)
                <li>
                    {!! HTML::link(url('posts/'.$post->permalink), $post->title) !!}
                </li>
            @endforeach
        </ul>

        <h2>{!! ucwords($type) !!} Categories</h2>
        <ul class="nav sidebar-categories margin-bottom-40">
            @foreach (Category::type($type)->published()->get() as $category)
                <li>
                    {!! HTML::link(url('posts/category/'.$category->alias), $category->name) !!}
                </li>
            @endforeach
        </ul>
        <!-- END WIDGET -->
    @else
        <h2 class="no-top-space">Main Menu</h2>
        {!! Services\MenuManager::generate('public-top-menu', 'nav sidebar-categories margin-bottom-40') !!}
    @endif

</div>
