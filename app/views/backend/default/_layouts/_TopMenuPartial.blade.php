<ul class="nav pull-right" id="top_menu">
    <li>{{ HTML::link('/', trans('cms.public'), array('target'=>'_blank')) }}</li>
    <li>{{ HTML::link('admin', trans('cms.admin'), array('target'=>'_blank')) }}</li>
    <li class="dropdown"><a href="{{ url('backend/config') }}" class="dropdown-toggle"><i class="icon-wrench"></i>&nbsp;&nbsp; </a></li>
    <li class="divider-vertical hidden-phone hidden-tablet"></li>
    <!-- BEGIN USER LOGIN DROPDOWN -->
    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            {{ $current_user->username }}
            {{ HTML::image($current_user->photo, '', array('height'=>'24px', 'width'=>'24px')) }}
            <b class="caret"></b>
        </a>
        <ul class="dropdown-menu">
            <li>
                <a href="{{ url('backend/profile') }}">
                    <i class="icon-user"></i> {{ trans('cms.profile') }}
                </a>
            </li>
            <li class="divider"></li>
            <li><a href="{{ url('logout') }}"><i class="icon-key"></i> {{ trans('cms.logout') }}</a></li>
        </ul>
    </li>
    <!-- END USER LOGIN DROPDOWN -->
</ul>
