@if (Sentry::check())
    <div id="sidebar" class="nav-collapse collapse">
        <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
        <div class="sidebar-toggler hidden-phone"></div>
        <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
        <!-- BEGIN RESPONSIVE QUICK SEARCH FORM -->
        <div class="navbar-inverse">
            <form class="navbar-search visible-phone">
                <input type="text" class="search-query" placeholder="Search" />
            </form>
        </div>
        <!-- END RESPONSIVE QUICK SEARCH FORM -->
        <!-- BEGIN SIDEBAR MENU -->
        <ul>
            <li class="start {{ Request::is('backend') ? 'active' : null }} ">
                <a href="{{ URL::to('backend') }}">
                    <i class="icon-home"></i>
                    <span class="title">Dashboard</span>
                </a>
            </li>

            @if (can_access_menu($current_user, array('users', 'user-groups')))
                <li class="has-sub {{ Request::is('backend/users*') ? 'active' : null }} {{ Request::is('backend/user-groups*') ? 'active' : null }} ">
                    <a href="javascript:;">
                        <i class="icon-user"></i>
                        <span class="title">User Manager</span>
                        <span class="arrow "></span>
                    </a>
                    <ul class="sub">
                        @if (can_access_menu($current_user, array('user-groups')))
                            <li><a href="{{ URL::to('backend/user-groups') }}">All User Groups</a></li>
                        @endif
                        @if (can_access_menu($current_user, array('users')))
                            <li><a href="{{ URL::to('backend/users') }}">All Users</a></li>
                        @endif
                    </ul>
                </li>
            @endif
            @if (can_access_menu($current_user, array('menu-manager', 'menu-categories')))
                <li class="has-sub {{ Request::is('backend/menu-manager*') || Request::is('backend/menu-categories*') ? 'active' : null }} ">
                    <a href="javascript:;">
                        <i class="icon-th-list"></i>
                        <span class="title">Menu Manager</span>
                        <span class="arrow "></span>
                    </a>
                    <ul class="sub">
                        @if (can_access_menu($current_user, array('menu-categories')))
                            <li><a href="{{ URL::to('backend/menu-categories') }}">All Menu Categories</a></li>
                        @endif
                        @if (can_access_menu($current_user, array('menu-manager')))
                            <li><a href="{{ URL::to('backend/menu-manager') }}">All Menu Entries</a></li>
                        @endif
                    </ul>
                </li>
            @endif
            @if (can_access_menu($current_user, array('slideshow')))
                <li class="{{ Request::is('backend/slideshow') ? 'active' : null }}">
                   <a href="{{ URL::to('backend/slideshow') }}">
                       <i class="icon-picture"></i>
                       <span class="title">Slideshow</span>
                   </a>
                </li>
            @endif
            @if (can_access_menu($current_user, array('pages', 'page-categories')))
            <li class="has-sub {{ Request::is('backend/pages*') || Request::is('backend/page-categories*') ? 'active' : null }} ">
                <a href="javascript:;">
                    <i class="icon-book"></i>
                    <span class="title">Pages</span>
                    <span class="arrow "></span>
                </a>
                <ul class="sub">
                    @if (can_access_menu($current_user, array('pages')))
                        <li class="{{ Request::is('backend/pages') ? 'active' : null }}">
                           <a href="{{ URL::to('backend/pages') }}">
                               Pages
                           </a>
                        </li>
                    @endif
                    @if (can_access_menu($current_user, array('page-categories')))
                        <li class="{{ Request::is('backend/page-categories') ? 'active' : null }}">
                           <a href="{{ URL::to('backend/page-categories') }}">
                               Page Categories
                           </a>
                        </li>
                    @endif
                </ul>
            </li>
            @endif
            @if (can_access_menu($current_user, array('posts')))
            <li class="has-sub {{ Request::is('backend/posts*') || Request::is('backend/post-categories*') ? 'active' : null }} ">
                <a href="javascript:;">
                    <i class="icon-book"></i>
                    <span class="title">Posts</span>
                    <span class="arrow "></span>
                </a>
                <ul class="sub">
                    @if (can_access_menu($current_user, array('posts')))
                        <li class="{{ Request::is('backend/posts') ? 'active' : null }}">
                           <a href="{{ URL::to('backend/posts') }}">
                               Posts
                           </a>
                        </li>
                    @endif
                    @if (can_access_menu($current_user, array('post-categories')))
                        <li class="{{ Request::is('backend/post-categories') ? 'active' : null }}">
                           <a href="{{ URL::to('backend/post-categories') }}">
                               Post Categories
                           </a>
                        </li>
                    @endif
                </ul>
            </li>
            @endif
            @if (can_access_menu($current_user, array('media-manager')))
            <li class="{{ Request::is('backend/media-manager*') ? 'active' : null }}">
               <a href="{{ URL::to('backend/media-manager') }}">
                   <i class="icon-camera"></i>
                   <span class="title">Media Manager</span>
               </a>
            </li>
            @endif
            @if (can_access_menu($current_user, array('theme-manager')))
            <li class="hide {{ Request::is('backend/theme-manager*') ? 'active' : null }}">
               <a href="{{ URL::to('backend/theme-manager') }}">
                   <i class="icon-eye-open"></i>
                   <span class="title">Theme Manager</span>
               </a>
            </li>
            @endif
            @if (can_access_menu($current_user, array('form-categories', 'form-builder', 'module-builder')))
            <li class="has-sub {{ Request::is('backend/form-builder*') || Request::is('backend/form-categories*') || Request::is('backend/module-builder*') ? 'active' : null }} ">
                <a href="javascript:;">
                    <i class="icon-table"></i>
                    <span class="title">Builders</span>
                    <span class="arrow "></span>
                </a>
                <ul class="sub">
                    @if (can_access_menu($current_user, array('form-categories')))
                        <li><a href="{{ URL::to('backend/form-categories') }}">Form Categories</a></li>
                    @endif
                    @if (can_access_menu($current_user, array('form-builder')))
                        <li><a href="{{ URL::to('backend/form-builder') }}">Form Builder</a></li>
                    @endif
                    @if (can_access_menu($current_user, array('module-builder')))
                        <li><a href="{{ URL::to('backend/module-builder') }}">Module Builder</a></li>
                    @endif
                    @if (can_access_menu($current_user, array('report-builder')))
                        <li><a href="{{ URL::to('backend/report-builder') }}">Report Builder</a></li>
                    @endif
                </ul>
            </li>
            @endif
            @if (can_access_menu($current_user, array('modules')))
            <li class="has-sub {{ Request::is('backend/modules*') ? 'active' : null }} ">
                <a href="javascript:;">
                    <i class="icon-cog"></i>
                    <span class="title">Extensions</span>
                    <span class="arrow "></span>
                </a>
                <ul class="sub">
                    @if (can_access_menu($current_user, array('modules')))
                        <li class="{{ Request::is('backend/modules/*') ? 'active' : null }}">
                           <a href="{{ URL::to('backend/modules') }}">
                               <span class="title">Modules</span>
                           </a>
                        </li>
                    @endif
                </ul>
            </li>
            @endif
            @if (can_access_menu($current_user, array('synchronize')))
            <li class="{{ Request::is('backend/synchronize') ? 'active' : null }}">
               <a href="{{ URL::to('backend/synchronize') }}">
                   <i class="icon-refresh"></i>
                   <span class="title">Synchronize</span>
               </a>
            </li>
            @endif
            @if (can_access_menu($current_user, array('config')))
            <li class="{{ Request::is('backend/config') ? 'active' : null }}">
               <a href="{{ URL::to('backend/config') }}">
                   <i class="icon-cogs"></i>
                   <span class="title">Settings</span>
               </a>
            </li>
            @endif
        </ul>
        <!-- END SIDEBAR MENU -->
    </div>
@endif
