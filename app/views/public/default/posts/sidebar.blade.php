<aside id="sidebar" class="grid_4">

    <div class="prefix_1_2">
        <?php $type = ($type == 'News') ? 'post' : 'page' ?>
        @if ($type == 'post' || $post->type == 'post')
            <!-- BEGIN CUSTOM MENU WIDGET -->
            <div class="widget custom-menu-widget">
                <h4>Recent {{ Str::plural('post') }}:</h4>
                <ul>
                    @foreach (Post::type('post')->target('public')->published()->recent()->take(5)->get(array('title', 'permalink')) as $post)
                        <li>
                            {{ HTML::link(url('posts/'.$post->permalink), $post->title) }}
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="widget custom-menu-widget">
                <h4>{{ $type }} Categories</h4>
                <ul>
                    @foreach (Category::type($type)->published()->get() as $category)
                        <li>
                            {{ HTML::link(url('posts/category/'.$category->alias), $category->name) }}
                        </li>
                    @endforeach
                </ul>
            </div>
            <!-- END WIDGET -->
        @else
            <div class="widget custom-menu-widget">
                <h4>Main Menu</h4>
                {{ Services\MenuManager::generate('public-top-menu', 'sf-menu') }}
            </div>
        @endif

    </div>

</aside>
