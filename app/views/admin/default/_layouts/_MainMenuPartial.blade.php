<div class="leftbar leftbar-close clearfix">
    <div class="admin-info clearfix">
        <div class="admin-thumb">
            {{ HTML::image(url($current_user->photo)) }}
        </div>
        <div class="admin-meta">
            <ul>
                <li class="admin-username">{{ $current_user->username }}</li>
                <li>{{ HTML::link("admin/profile/edit", "Edit Profile") }}</li>
                <li>{{ HTML::link("admin/profile", "View Profile") }}</li>
                <li><a href="{{ url('logout') }}"><i class="icon-lock"></i> Logout</a></li>
            </ul>
        </div>
    </div>
    <div class="left-nav clearfix">
        <div class="responsive-leftbar">
            <i class="icon-list"></i>
        </div>
        <div class="left-secondary-nav tab-content">
            <div class="tab-pane active" id="main">
                <h4 class="side-head">Menus</h4>
                {{ Services\MenuManager::generate('admin-main-menu', 'accordion-nav') }}
            </div>
        </div>
    </div>
</div>
