@section('content')
    <div class="row-fluid">
        <div class="span12">
            <!-- BEGIN FORM widget-->
            <div class="widget light-gray box tabbable">
                <div class="blue widget-title">
                    <h4>
                        <i class="icon-user"></i>
                        <span class="hidden-480">User Information</span>
                        &nbsp;
                    </h4>
                </div>
                <div class="widget-body widget-container form">
                    <div class="tabbable widget-tabs">
                        <div class="tab-content">
                            <div class="tab-pane active" id="widget_tab1">
                                <form class="form-horizontal">
                                    <div class="control-group {{{ $errors->has('username') ? 'error' : '' }}}">
                                        <label class="control-label">Username</label>
                                        <div class="controls">
                                            {{ $user->username }}
                                        </div>
                                    </div>
                                    <div class="control-group {{{ $errors->has('first_name') ? 'error' : '' }}}">
                                        <label class="control-label">First Name</label>
                                        <div class="controls">
                                            {{ $user->first_name }}
                                        </div>
                                    </div>
                                    <div class="control-group {{{ $errors->has('last_name') ? 'error' : '' }}}">
                                        <label class="control-label">Last Name</label>
                                        <div class="controls">
                                            {{ $user->last_name }}
                                        </div>
                                    </div>

                                    <div class="control-group {{{ $errors->has('photo') ? 'error' : '' }}}">
                                        <label class="control-label">Profile Photo</label>
                                        <div class="controls">
                                            {{ HTML::image(url($user->photo)) }}
                                        </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label">User Group</label>
                                        <div class="controls">
                                            {{ Sentry::findGroupById(User::user_group($user))->name }}
                                        </div>
                                    </div>
                                    @if (Request::is('*profile*'))
                                        <div class="form-actions">
                                            <a href="{{ url("$link_type/profile/edit") }}" class="btn btn-primary">Edit Profile</a>
                                        </div>
                                    @endif
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END FORM widget-->
        </div>
    </div>
@stop
