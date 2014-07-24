@extends($link_type . '.default._layouts._layout')

@section('content')
    <div id="page" class="dashboard">
        <h1>Welcome</h1>
        <div class="row-fluid">

            <div class="span3">
                <div class="board-widgets black small-widget">
                    <a href="{{ url('backend/users') }}">
                        <span class="widget-icon icon-user"></span>

                        <span class="widget-label">User Manager</span>
                    </a>
                </div>
            </div>

            <div class="span3">
                <div class="board-widgets black small-widget">
                    <a href="{{ url('backend/menu-manager') }}">
                        <span class="widget-icon icon-th-list"></span>

                        <span class="widget-label">Menu Manager</span>
                    </a>
                </div>
            </div>

            <div class="span3">
                <div class="board-widgets black small-widget">
                    <a href="{{ url('backend/slideshow') }}">
                        <span class="widget-icon icon-picture"></span>

                        <span class="widget-label">Slideshow</span>
                    </a>
                </div>
            </div>

            <div class="span3">
                <div class="board-widgets black small-widget">
                    <a href="{{ url('backend/pages') }}">
                        <span class="widget-icon icon-book"></span>

                        <span class="widget-label">Pages</span>
                    </a>
                </div>
            </div>

        </div>
        <div class="row-fluid">

            <div class="span3">
                <div class="board-widgets black small-widget">
                    <a href="{{ url('backend/posts') }}">
                        <span class="widget-icon icon-book"></span>

                        <span class="widget-label">Posts</span>
                    </a>
                </div>
            </div>

            <div class="span3">
                <div class="board-widgets black small-widget">
                    <a href="{{ url('backend/media-manager') }}">
                        <span class="widget-icon icon-camera"></span>

                        <span class="widget-label">Media Manager</span>
                    </a>
                </div>
            </div>

            <div class="span3">
                <div class="board-widgets black small-widget">
                    <a href="{{ url('backend/contact-manager') }}">
                        <span class="widget-icon icon-group"></span>

                        <span class="widget-label">Contact Manager</span>
                    </a>
                </div>
            </div>

            <div class="span3">
                <div class="board-widgets black small-widget">
                    <a href="{{ url('backend/theme-manager') }}">
                        <span class="widget-icon icon-eye-open"></span>

                        <span class="widget-label">Theme Manager</span>
                    </a>
                </div>
            </div>

        </div>
        <div class="row-fluid">

            <div class="span3">
                <div class="board-widgets black small-widget">
                    <a href="{{ url('backend/form-builder') }}">
                        <span class="widget-icon icon-table"></span>

                        <span class="widget-label">Builders</span>
                    </a>
                </div>
            </div>

            <div class="span3">
                <div class="board-widgets black small-widget">
                    <a href="{{ url('backend/modules') }}">
                        <span class="widget-icon icon-cog"></span>

                        <span class="widget-label">Extensions</span>
                    </a>
                </div>
            </div>

            <div class="span3">
                <div class="board-widgets black small-widget">
                    <a href="{{ url('backend/synchronize') }}">
                        <span class="widget-icon icon-refresh"></span>

                        <span class="widget-label">Synchronize</span>
                    </a>
                </div>
            </div>

            <div class="span3">
                <div class="board-widgets black small-widget">
                    <a href="{{ url('backend/config') }}">
                        <span class="widget-icon icon-cogs"></span>

                        <span class="widget-label">Settings</span>
                    </a>
                </div>
            </div>

        </div>
    </div>
@stop
