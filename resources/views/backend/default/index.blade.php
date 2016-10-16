@extends($link_type . '.default._layouts._layout')

@section('content')
    <div id="page" class="dashboard">
        <h1>{!! trans('cms.welcome') !!}</h1>
        <div class="row-fluid">

            <div class="span3">
                <div class="board-widgets black small-widget">
                    <span class="widget-icon icon-user"></span>

                    <span class="widget-label">{!! trans('cms.user_manager') !!}</span>

                    <ul class="board-sub">
                        @if (can_access_menu($current_user, array('user-groups')))
                            <li><a href="{!! URL::to('backend/user-groups') !!}">{!! trans('cms.user_groups') !!}</a></li>
                        @endif
                        @if (can_access_menu($current_user, array('users')))
                            <li><a href="{!! URL::to('backend/users') !!}">{!! trans('cms.users') !!}</a></li>
                        @endif
                    </ul>
                </div>
            </div>

            <div class="span3">
                <div class="board-widgets black small-widget">
                    <span class="widget-icon icon-th-list"></span>

                    <span class="widget-label">{!! trans('cms.menu_manager') !!}</span>

                    <ul class="board-sub">
                        @if (can_access_menu($current_user, array('menu-positions')))
                            <li><a href="{!! URL::to('backend/menu-positions') !!}">{!! trans('cms.menu_positions') !!}</a></li>
                        @endif
                        @if (can_access_menu($current_user, array('menu-categories')))
                            <li><a href="{!! URL::to('backend/menu-categories') !!}">{!! trans('cms.menu_categories') !!}</a></li>
                        @endif
                        @if (can_access_menu($current_user, array('menu-manager')))
                            <li><a href="{!! URL::to('backend/menu-manager') !!}">{!! trans('cms.menu_entries') !!}</a></li>
                        @endif
                    </ul>
                </div>
            </div>

            <div class="span3">
                <div class="board-widgets black small-widget">
                    <span class="widget-icon icon-book"></span>

                    <span class="widget-label">{!! trans('cms.pages') !!}</span>

                    <ul class="board-sub">
                        @if (can_access_menu($current_user, array('pages')))
                            <li class="{!! Request::is('backend/pages') ? 'active' : null !!}">
                               <a href="{!! URL::to('backend/pages') !!}">
                                   {!! trans('cms.pages') !!}
                               </a>
                            </li>
                        @endif
                        @if (can_access_menu($current_user, array('page-categories')))
                            <li class="{!! Request::is('backend/page-categories') ? 'active' : null !!}">
                               <a href="{!! URL::to('backend/page-categories') !!}">
                                   {!! trans('cms.page_categories') !!}
                               </a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>

            <div class="span3">
                <div class="board-widgets black small-widget">
                    <span class="widget-icon icon-book"></span>

                    <span class="widget-label">{!! trans('cms.posts') !!}</span>

                    <ul class="board-sub">
                        @if (can_access_menu($current_user, array('posts')))
                            <li class="{!! Request::is('backend/posts') ? 'active' : null !!}">
                               <a href="{!! URL::to('backend/posts') !!}">
                                   {!! trans('cms.posts') !!}
                               </a>
                            </li>
                        @endif
                        @if (can_access_menu($current_user, array('post-categories')))
                            <li class="{!! Request::is('backend/post-categories') ? 'active' : null !!}">
                               <a href="{!! URL::to('backend/post-categories') !!}">
                                   {!! trans('cms.post_categories') !!}
                               </a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>

        <div class="row-fluid">

            <div class="span3">
                <div class="board-widgets black small-widget">
                    <a href="{!! url('backend/media-manager') !!}">
                        <span class="widget-icon icon-camera"></span>

                        <span class="widget-label">{!! trans('cms.media_manager') !!}</span>
                    </a>
                </div>
            </div>

            <div class="span3">
                <div class="board-widgets black small-widget">
                    <span class="widget-icon icon-group"></span>

                    <span class="widget-label">{!! trans('cms.contact_manager') !!}</span>

                    <ul class="board-sub">
                        @if (can_access_menu($current_user, array('contact-manager')))
                            <li class="{!! Request::is('backend/contact-manager') ? 'active' : null !!}">
                               <a href="{!! URL::to('backend/contact-manager') !!}">
                                   {!! trans('cms.contact_manager') !!}
                               </a>
                            </li>
                        @endif
                        @if (can_access_menu($current_user, array('contact-categories')))
                            <li class="{!! Request::is('backend/contact-categories') ? 'active' : null !!}">
                               <a href="{!! URL::to('backend/contact-categories') !!}">
                                   {!! trans('fields.contact_categories') !!}
                               </a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>

            <div class="span3">
                <div class="board-widgets black small-widget">
                    <a href="{!! url('backend/theme-manager') !!}">
                        <span class="widget-icon icon-eye-open"></span>

                        <span class="widget-label">{!! trans('cms.theme_manager') !!}</span>
                    </a>
                </div>
            </div>

            <div class="span3">
                <div class="board-widgets black small-widget">
                    <span class="widget-icon icon-table"></span>

                    <span class="widget-label">{!! trans('cms.builders') !!}</span>

                    <ul class="board-sub">
                        @if (can_access_menu($current_user, array('form-categories')))
                            <li><a href="{!! URL::to('backend/form-categories') !!}">{!! trans('cms.form_categories') !!}</a></li>
                        @endif
                        @if (can_access_menu($current_user, array('form-builder')))
                            <li><a href="{!! URL::to('backend/form-builder') !!}">{!! trans('cms.form_builder') !!}</a></li>
                        @endif
                        @if (can_access_menu($current_user, array('module-builder')))
                            <li><a href="{!! URL::to('backend/module-builder') !!}">{!! trans('cms.module_builder') !!}</a></li>
                        @endif
                        @if (can_access_menu($current_user, array('report-builder')))
                            <li><a href="{!! URL::to('backend/report-builder') !!}">{!! trans('cms.report_builder') !!}</a></li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span3">
                <div class="board-widgets black small-widget">
                    <span class="widget-icon icon-download-alt"></span>

                    <span class="widget-label">{!! trans('cms.backup-and-restore') !!}</span>

                    <ul class="board-sub">
                        @if (can_access_menu($current_user, array('backup')))
                            <li class="{!! Request::is('backend/backup/*') ? 'active' : null !!}">
                               <a href="{!! URL::to('backend/backup') !!}">
                                   <span class="title">{!! trans('cms.backup') !!}</span>
                               </a>
                            </li>
                        @endif
                        @if (can_access_menu($current_user, array('restore')))
                            <li class="{!! Request::is('backend/restore/*') ? 'active' : null !!}">
                               <a href="{!! URL::to('backend/restore') !!}">
                                   <span class="title">{!! trans('cms.restore') !!}</span>
                               </a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>

            <div class="span3">
                <div class="board-widgets black small-widget">
                    <span class="widget-icon icon-cog"></span>

                    <span class="widget-label">{!! trans('cms.extensions') !!}</span>

                    <ul class="board-sub">
                        @if (can_access_menu($current_user, array('modules')))
                            <li class="{!! Request::is('backend/modules/*') ? 'active' : null !!}">
                               <a href="{!! URL::to('backend/modules') !!}">
                                   <span class="title">{!! trans('cms.modules') !!}</span>
                               </a>
                            </li>
                        @endif
                        @if (can_access_menu($current_user, array('report-generators')))
                            <li class="{!! Request::is('backend/report-generators/*') ? 'active' : null !!}">
                               <a href="{!! URL::to('backend/report-generators') !!}">
                                   <span class="title">{!! trans('cms.report_generators') !!}</span>
                               </a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>

            <div class="span3">
                <div class="board-widgets black small-widget">
                    <a href="{!! url('backend/synchronize') !!}">
                        <span class="widget-icon icon-refresh"></span>

                        <span class="widget-label">{!! trans('cms.synchronize') !!}</span>
                    </a>
                </div>
            </div>

            <div class="span3">
                <div class="board-widgets black small-widget">
                    <a href="{!! url('backend/config') !!}">
                        <span class="widget-icon icon-cogs"></span>

                        <span class="widget-label">{!! trans('cms.settings') !!}</span>
                    </a>
                </div>
            </div>
        </div>

        <div class="row-fluid">
            @if (can_access_menu($current_user, array('theme_settings')) && has_theme_settings())
            <div class="span3">
                <div class="board-widgets black small-widget">
                    <a href="{!! url('backend/theme_settings') !!}">
                        <span class="widget-icon icon-desktop"></span>

                        <span class="widget-label">{!! trans('cms.theme_settings') !!}</span>
                    </a>
                </div>
            </div>
            @endif
        </div>
    </div>
@stop

@section('scripts')
    @parent

    <script>
        $('.board-widgets').mouseover(function(e) {
            $(this).find('.board-sub').show();
        }).mouseout(function(e) {
            $(this).find('.board-sub').hide();
        });
    </script>
@stop
