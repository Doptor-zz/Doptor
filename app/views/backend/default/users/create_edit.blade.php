@section('styles')
    {{ HTML::style('assets/backend/default/plugins/bootstrap/css/bootstrap-modal.css') }}
@stop

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
                                            {{-- Form::file('photo', array('class' => 'input-xlarge')) --}}
                                            {{ Form::hidden('photo') }}
                                            <a class="btn btn-primary insert-media" id="insert-main-image" href="#"> Select image</a>
                                            <span class="file-name">
                                                {{ $user->photo or '' }}
                                            </span>
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

    <div id="ajax-insert-modal" class="modal hide fade page-container" tabindex="-1"></div>
@stop

@section('scripts')
    {{ HTML::script('assets/backend/default/plugins/bootstrap/js/bootstrap-modalmanager.js') }}
    {{ HTML::script('assets/backend/default/plugins/bootstrap/js/bootstrap-modal.js') }}
    @parent
    <script>
        var insert_modal = $('#ajax-insert-modal');
        var calling_div;

        $('.insert-media').on('click', function(event) {
            calling_div = event.target.id;
            $('body').modalmanager('loading');

            setTimeout(function(){
                insert_modal.load('{{ URL::to("backend/media-manager") }}', '', function(){
                    insert_modal.modal();
                });
            }, 1000);
        });

        $('.preview.processing img').live('click', function(event) {
            var folder_name = $('input[name=folder]').val();
            if ($(this).parent().find('.file-name').length) {
                var image = $(this).parent().find('.file-name').first().text();
            } else {
                var image = $(this).parent().find('.filename').text();

            }

            var image_path = folder_name+'/'+image;

            if (calling_div == 'insert-main-image') {

                $('input[name=photo]').val(image_path);
                // Display the name of the current selected file
                $('#'+calling_div).parent().find('.file-name').text(image_path);

            }
            insert_modal.modal('hide');
        });
    </script>
@stop