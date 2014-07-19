@section('content')
    <div class="row-fluid">
        <div class="span12">
            <!-- BEGIN FORM widget-->
            <div class="widget light-gray box tabbable">
                <div class="blue widget-title">
                    <h4>
                        <i class="icon-user"></i>
                        @if (!isset($user))
                            <span class="hidden-480">Create New User</span>
                        @else
                            <span class="hidden-480">Edit User Information</span>
                        @endif
                        &nbsp;
                    </h4>
                </div>

                <div class="widget-body widget-container form">
                    <div class="tabbable widget-tabs">
                        <div class="tab-content">
                            <div class="tab-pane active" id="widget_tab1">
                                <!-- BEGIN FORM-->
                                @if (!isset($user))
                                {{ Form::open(array('route'=>$link_type.'.users.store', 'method'=>'POST', 'files'=>true, 'class'=>'form-horizontal')) }}
                                @else
                                {{ Form::open(array('route' => array($link_type.'.users.update', $user->id), 'method'=>'PUT', 'files'=>true, 'class'=>'form-horizontal')) }}
                                @endif

                                    @if ($errors->has())
                                         <div class="alert alert-error hide" style="display: block;">
                                           <button data-dismiss="alert" class="close">×</button>
                                           You have some form errors. Please check below.
                                        </div>
                                    @endif


                                    <div class="control-group {{{ $errors->has('username') ? 'error' : '' }}}">
                                        <label class="control-label">Username <span class="red">*</span></label>
                                        <div class="controls">
                                            {{ Form::text('username', (!isset($user)) ? Input::old('username') : $user->username, array('class' => 'input-xlarge'))}}
                                            {{ $errors->first('username', '<span class="help-inline">:message</span>') }}
                                        </div>
                                    </div>
                                    <div class="control-group {{{ $errors->has('email') ? 'error' : '' }}}">
                                        <label class="control-label">Email Address <span class="red">*</span></label>
                                        <div class="controls">
                                            {{ Form::text('email', (!isset($user)) ? Input::old('email') : $user->email, array('class' => 'input-xlarge'))}}
                                            {{ $errors->first('email', '<span class="help-inline">:message</span>') }}
                                        </div>
                                    </div>
                                    <div class="control-group {{{ $errors->has('first_name') ? 'error' : '' }}}">
                                        <label class="control-label">First Name <span class="red">*</span></label>
                                        <div class="controls">
                                            {{ Form::text('first_name', (!isset($user)) ? Input::old('first_name') : $user->first_name, array('class' => 'input-xlarge'))}}
                                            {{ $errors->first('first_name', '<span class="help-inline">:message</span>') }}
                                        </div>
                                    </div>
                                    <div class="control-group {{{ $errors->has('last_name') ? 'error' : '' }}}">
                                        <label class="control-label">Last Name <span class="red">*</span></label>
                                        <div class="controls">
                                            {{ Form::text('last_name', (!isset($user)) ? Input::old('last_name') : $user->last_name, array('class' => 'input-xlarge'))}}
                                            {{ $errors->first('last_name', '<span class="help-inline">:message</span>') }}
                                        </div>
                                    </div>
                                    <div class="control-group {{{ $errors->has('password') ? 'error' : '' }}}">
                                        <label class="control-label">Password {{ (!isset($user)) ? '<span class="red">*</span>' : '' }}</label>
                                        <div class="controls">
                                            {{ Form::password('password', array('class' => 'input-xlarge'))}}
                                            {{ $errors->first('password', '<span class="help-inline">:message</span>') }}
                                        </div>
                                    </div>
                                    <div class="control-group {{{ $errors->has('password_confirmation') ? 'error' : '' }}}">
                                        <label class="control-label">Confirm Password {{ (!isset($user)) ? '<span class="red">*</span>' : '' }}</label>
                                        <div class="controls">
                                            {{ Form::password('password_confirmation', array('class' => 'input-xlarge'))}}
                                            {{ $errors->first('password_confirmation', '<span class="help-inline">:message</span>') }}
                                        </div>
                                    </div>

                                    @if (!Request::is('*profile*'))
                                        {{-- Don't show status selection while editing profile --}}
                                        <div class="control-group">
                                            <label class="control-label">Status</label>
                                            <div class="controls">
                                                @if (isset($user))
                                                    {{ Form::select('status', User::status(), ($user->is_banned)?'0':'1', array('class'=>'chosen input-xlarge')) }}
                                                @else
                                                    {{ Form::select('status', User::status(), 1, array('class'=>'chosen input-xlarge')) }}
                                                @endif
                                            </div>
                                        </div>
                                        {{-- Don't show user group selection while editing profile --}}
                                        <div class="control-group">
                                            <label class="control-label">User Group</label>
                                            <div class="controls">
                                                @if (isset($user))
                                                    {{ Form::select('user-group', Group::lists('name', 'id'), User::user_group($user), array('class'=>'chosen input-xlarge')) }}
                                                @else
                                                    {{ Form::select('user-group', UserGroup::all_groups(), '', array('class'=>'chosen input-xlarge')) }}
                                                @endif

                                                {{ HTML::link("$link_type/user-groups/create", "Add User Group", array('class'=>'btn btn-mini mb-15')) }}
                                            </div>
                                        </div>
                                    @endif

                                    <div class="control-group {{{ $errors->has('photo') ? 'error' : '' }}}">
                                        <label class="control-label">Profile Photo</label>
                                        <div class="controls">
                                            {{ Form::file('photo', array('class' => 'input-xlarge')) }}
                                            {{ $errors->first('photo', '<span class="help-inline">:message</span>') }}
                                        </div>
                                    </div>

                                    <br>
                                    <div class="form-actions">
                                        <button type="submit" class="btn btn-primary"><i class="icon-ok"></i> Save</button>
                                    </div>
                                {{ Form::close() }}
                                <!-- END FORM-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END FORM widget-->
        </div>
    </div>
@stop
