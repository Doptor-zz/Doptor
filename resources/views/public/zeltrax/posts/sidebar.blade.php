<div class="right_sidebar">


    <?php $type = ($type == 'News') ? 'post' : 'page' ?>
    @if ($type == 'post' || $post->type == 'post')
        <div class="sidebar_widget">
            <div class="sidebar_title"><h3>{!! Str::plural('post') !!}</h3></div>
            <ul class="arrows_list1">
                @foreach (Post::type('post')->target('public')->published()->recent()->take(5)->get(array('title', 'permalink')) as $post)
                    <li>
                        {!! HTML::link(url('posts/'.$post->permalink), $post->title) !!}
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="clearfix margin_top4"></div>

        <div class="sidebar_widget">
            <div class="sidebar_title"><h3>{!! $type !!} Categories</h3></div>
            <ul class="arrows_list1">
                @foreach (Category::type($type)->published()->get() as $category)
                    <li>
                        {!! HTML::link(url('posts/category/'.$category->alias), $category->name) !!}
                    </li>
                @endforeach
            </ul>
        </div>
    @else
        <div class="widget custom-menu-widget">
            <h4>Main Menu</h4>
            {!! Services\MenuManager::generate('public-top-menu', 'nav navbar-nav') !!}
        </div>
    @endif

</div>
