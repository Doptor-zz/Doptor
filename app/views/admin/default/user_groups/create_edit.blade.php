@section('styles')
    <style>
    .tabbable {
        margin: 0 0 0 180px;
    }
        #inner_tab .controls {
            margin: 0;
        }
    </style>
@stop
@section('content')
    <div class="row-fluid">
        <div class="span12">
            <!-- BEGIN FORM widget-->
            <div class="widget box blue">
                <div class="blue widget-title">
                    <h4>
                        <i class="icon-user"></i>
                        @if (!isset($user_group))
                            <span class="hidden-480">Create New User Group</span>
                        @else
                            <span class="hidden-480">Edit User Group Information</span>
                        @endif
                        &nbsp;
                    </h4>
                </div>
                <div class="widget-body form">
                    <div class="widget-tabs">
                        <div class="tab-content">
                            <div class="tab-pane active" id="widget_tab1">
                                <!-- BEGIN FORM-->
                                @if (!isset($user_group))
                                {{ Form::open(array('route'=>$link_type . '.user-groups.store', 'method'=>'POST', 'class'=>'form-horizontal')) }}
                                @else
                                {{ Form::open(array('route' => array($link_type . '.user-groups.update', $user_group->id), 'method'=>'PUT', 'class'=>'form-horizontal')) }}
                                @endif

                                    @if ($errors->has())
                                         <div class="alert alert-error hide" style="display: block;">
                                           <button data-dismiss="alert" class="close">×</button>
                                           You have some form errors. Please check below.
                                        </div>
                                    @endif


                                    <div class="control-group {{{ $errors->has('name') ? 'error' : '' }}}">
                                        <label class="control-label">Name <span class="red">*</span></label>
                                        <div class="controls">
                                            {{ Form::text('name', (!isset($user_group)) ? Input::old('name') : $user_group->name, array('class' => 'input-xlarge'))}}
                                            {{ $errors->first('name', '<span class="help-inline">:message</span>') }}
                                        </div>
                                    </div>
                                    <div class="control-group {{{ $errors->has('permissions') ? 'error' : '' }}}">
                                        <label class="control-label">Permissions <span class="red">*</span></label>
                                        <div class="controls line">
                                            <label class="checkbox">
                                            @if ($current_user->hasAccess('superuser'))
                                                <input type="checkbox" value="1" name="superuser" id="all-access" {{ (isset($user_group->permissions['superuser'])) ? 'checked' : '' }}/> All Access
                                            @endif
                                            </label>
                                        </div>
                                        <div class="controls line">
                                            <label class="checkbox">
                                            @if ($current_user->hasAccess('backend'))
                                                <input type="checkbox" value="1" name="backend" {{ (isset($user_group->permissions['backend'])) ? 'checked' : '' }}/> Backend Access
                                            @endif
                                            </label>
                                        </div>
                                        <br>

                                    <br><br>
                                    <div class="tabbable tabbable-custom" id="inner_tab">
                                    <ul class="nav nav-tabs pull-left">
                                       <li><a href="#tab_1_2" data-toggle="tab">{{ trans('cms.modules') }}</a></li>
                                       <li class="active"><a href="#tab_1_1" data-toggle="tab">Basic</a></li>
                                    </ul>
                                    <div class="tab-content">
                                       <div class="tab-pane active" id="tab_1_1">
                                            @foreach ($access_areas['resourceful'] as $abbr => $full)
                                                @if (can_access_menu($current_user, $abbr))
                                                <div class="controls line">
                                                    <b>{{ $full }}</b><br>
                                                    <label class="checkbox">
                                                    @if ($current_user->hasAccess($abbr.'.index'))
                                                        <input type="checkbox" value="1" name="{{ $abbr }}.index" {{ (isset($user_group->permissions[$abbr.'.index'])) ? 'checked' : '' }}/> List All Records
                                                    @endif
                                                    </label>
                                                    <label class="checkbox">
                                                    @if ($current_user->hasAccess($abbr.'.show'))
                                                        <input type="checkbox" value="1" name="{{ $abbr }}.show" {{ (isset($user_group->permissions[$abbr.'.show'])) ? 'checked' : '' }}/> View Individual Records
                                                    @endif
                                                    </label>
                                                    <label class="checkbox">
                                                    @if ($current_user->hasAccess($abbr.'.create'))
                                                        <input type="checkbox" value="1" name="{{ $abbr }}.create" {{ (isset($user_group->permissions[$abbr.'.create'])) ? 'checked' : '' }}/> Create New Record
                                                    @endif
                                                    </label>
                                                    <label class="checkbox">
                                                    @if ($current_user->hasAccess($abbr.'.edit'))
                                                        <input type="checkbox" value="1" name="{{ $abbr }}.edit" {{ (isset($user_group->permissions[$abbr.'.edit'])) ? 'checked' : '' }}/> Edit Record
                                                    @endif
                                                    </label>
                                                    <label class="checkbox">
                                                    @if ($current_user->hasAccess($abbr.'.destroy'))
                                                        <input type="checkbox" value="1" name="{{ $abbr }}.destroy" {{ (isset($user_group->permissions[$abbr.'.destroy'])) ? 'checked' : '' }}/> Delete Record
                                                    @endif
                                                    </label>
                                                    <label class="checkbox">
                                                        @if ((isset($user_group->permissions[$abbr.'.index'])) && (isset($user_group->permissions[$abbr.'.show'])) && (isset($user_group->permissions[$abbr.'.create'])) && (isset($user_group->permissions[$abbr.'.edit'])) && (isset($user_group->permissions[$abbr.'.destroy'])))
                                                            <input type="checkbox" class="select_all" checked /> All
                                                        @else
                                                            <input type="checkbox" class="select_all" /> All
                                                        @endif
                                                    </label>
                                                </div>
                                                <br>
                                                @endif
                                            @endforeach

                                            @foreach ($access_areas['others'] as $name => $permissions)
                                                @if (can_access_menu($current_user, $name))
                                                <div class="controls line">
                                                <b>{{ Str::title(str_replace('-', ' ', $name)) }}</b><br>

                                                @foreach ((array)$permissions as $permission => $desc)
                                                    <label class="checkbox">
                                                    @if ($current_user->hasAccess("{$name}.{$permission}"))
                                                        <input type="checkbox" value="1" name="{{ $name }}_{{ $permission }}" {{ (isset($user_group->permissions["{$name}.{$permission}"])) ? 'checked' : '' }}/> {{ $desc }}
                                                    @endif
                                                    </label>
                                                @endforeach
                                                    <label class="checkbox"><input type="checkbox" class="select_all" /> All</label>
                                                </div>
                                                <br>
                                                @endif
                                            @endforeach
                                       </div>
                                       <div class="tab-pane" id="tab_1_2">
                                                @foreach ($access_areas['modules'] as $abbr => $full)
                                                    @if (can_access_menu($current_user, $abbr))
                                                    <div class="controls line">
                                                        <b>{{ $full }}</b><br>
                                                        <label class="checkbox">
                                                        @if ($current_user->hasAccess('modules.'.$abbr.'.index'))
                                                            <input type="checkbox" value="1" name="modules.{{ $abbr }}.index" {{ (isset($user_group->permissions['modules.'.$abbr.'.index'])) ? 'checked' : '' }}/> List All Records
                                                        @endif
                                                        </label>
                                                        <label class="checkbox">
                                                        @if ($current_user->hasAccess('modules.'.$abbr.'.show'))
                                                            <input type="checkbox" value="1" name="modules.{{ $abbr }}.show" {{ (isset($user_group->permissions['modules.'.$abbr.'.show'])) ? 'checked' : '' }}/> View Individual Records
                                                        @endif
                                                        </label>
                                                        <label class="checkbox">
                                                        @if ($current_user->hasAccess('modules.'.$abbr.'.create'))
                                                            <input type="checkbox" value="1" name="modules.{{ $abbr }}.create" {{ (isset($user_group->permissions['modules.'.$abbr.'.create'])) ? 'checked' : '' }}/> Create New Record
                                                        @endif
                                                        </label>
                                                        <label class="checkbox">
                                                        @if ($current_user->hasAccess('modules.'.$abbr.'.edit'))
                                                            <input type="checkbox" value="1" name="modules.{{ $abbr }}.edit" {{ (isset($user_group->permissions['modules.'.$abbr.'.edit'])) ? 'checked' : '' }}/> Edit Record
                                                        @endif
                                                        </label>
                                                        <label class="checkbox">
                                                        @if ($current_user->hasAccess('modules.'.$abbr.'.destroy'))
                                                            <input type="checkbox" value="1" name="modules.{{ $abbr }}.destroy" {{ (isset($user_group->permissions['modules.'.$abbr.'.destroy'])) ? 'checked' : '' }}/> Delete Record
                                                        @endif
                                                        </label>
                                                        <label class="checkbox">
                                                            @if ((isset($user_group->permissions['modules.'.$abbr.'.index'])) && (isset($user_group->permissions['modules.'.$abbr.'.show'])) && (isset($user_group->permissions['modules.'.$abbr.'.create'])) && (isset($user_group->permissions['modules.'.$abbr.'.edit'])) && (isset($user_group->permissions['modules.'.$abbr.'.destroy'])))
                                                                <input type="checkbox" class="select_all" checked /> All
                                                            @else
                                                                <input type="checkbox" class="select_all" /> All
                                                            @endif
                                                        </label>
                                                    </div>
                                                    <br>
                                                    @endif
                                                @endforeach
                                            </div>
                                       </div>
                                    </div>
                                 </div>

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

@section('scripts')
    @parent
    <script type="text/javascript">
        jQuery(document).ready(function() {
            $('#all-access').change(function() {
                var checkboxes = $(this).closest('.control-group').find(':checkbox');

                if ($(this).is(':checked')) {
                    checkboxes.attr('checked', 'checked');
                    restore_uniformity();
                } else {
                    checkboxes.removeAttr('checked');
                    restore_uniformity();
                }
            });
            $('.select_all').change(function() {
                var checkboxes = $(this).closest('.controls').find(':checkbox');

                if ($(this).is(':checked')) {
                    checkboxes.attr('checked', 'checked');
                    restore_uniformity();
                } else {
                    checkboxes.removeAttr('checked');
                    restore_uniformity();
                }
            });
        });
        function restore_uniformity() {
            $.uniform.restore("input[type=checkbox]");
            $('input[type=checkbox]').uniform();
        }
    </script>
@stop
