@section('styles')
    <link rel="stylesheet" href="{{ URL::to('assets/backend/default/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}" />
@stop

@section('content')
    <div class="row-fluid">
        <div class="span12">
            <!-- BEGIN FORM widget-->
            <div class="widget box light-gray tabbable">
                <div class="blue widget-title">
                    <h4>
                        <i class="icon-user"></i>
                        @if (!isset($menu))
                            <span class="hidden-480">Create New Menu Entry</span>
                        @else
                            <span class="hidden-480">Edit Existing Menu Entry</span>
                        @endif
                        &nbsp;
                    </h4>

                </div>
                <div class="widget-body form">
                    <div class="tabbable widget-tabs">
                        <div class="tab-content">
                            <div class="tab-pane active" id="widget_tab1">
                                <!-- BEGIN FORM-->
                                @if (!isset($menu))
                                {{ Form::open(array('route'=>$link_type . '.menu-manager.store', 'method'=>'POST', 'files'=>true, 'class'=>'form-horizontal')) }}
                                @else
                                {{ Form::open(array('route' => array($link_type . '.menu-manager.update', $menu->id), 'method'=>'PUT', 'files'=>true, 'class'=>'form-horizontal')) }}
                                @endif

                                    @if ($errors->has())
                                         <div class="alert alert-error hide" style="display: block;">
                                           <button data-dismiss="alert" class="close">×</button>
                                           You have some form errors. Please check below.
                                        </div>
                                    @endif


                                    <div class="control-group {{{ $errors->has('title') ? 'error' : '' }}}">
                                        <label class="control-label">Title <i class="red">*</i></label>
                                        <div class="controls">
                                            {{ Form::text('title', (!isset($menu)) ? Input::old('title') : $menu->title, array('class' => 'input-xlarge'))}}
                                            {{ $errors->first('title', '<span class="help-inline">:message</span>') }}
                                        </div>
                                    </div>

                                    <div class="control-group {{{ $errors->has('alias') ? 'error' : '' }}}">
                                        <label class="control-label">Alias </label>
                                        <div class="controls">
                                            {{ Form::text('alias', (!isset($menu)) ? Input::old('alias') : $menu->alias, array('class' => 'input-xlarge'))}}
                                            <span class="help-inline">Leave blank for automatic alias</span>
                                            {{ $errors->first('alias', '<span class="help-inline">:message</span>') }}
                                        </div>
                                    </div>

                                    <div class="control-group {{{ $errors->has('link') ? 'error' : '' }}} {{{ $errors->has('link') ? 'wrapper_width' : '' }}} {{{ $errors->has('wrapper_height') ? 'error' : '' }}}">
                                        <label class="control-label">Link <i class="red">*</i></label>
                                        <div class="controls">
                                            {{ Form::select('link', Menu::menu_lists(), (!isset($menu)) ? Input::old('link') : $menu->link, array('id'=>'link', 'class' => 'chosen span6 m-wrap', 'style'=>'width:285px')) }}
                                            {{ $errors->first('link', '<span class="help-inline">:message</span>') }}
                                        </div>
                                        <div id="manual-link" class="controls">
                                            {{ Form::text('link_manual', (!isset($menu)) ? Input::old('link_manual') : $menu->link_manual, array('class' => 'input-xlarge'))}}
                                            {{ Form::hidden('is_wrapper', false) }}
                                            {{ Form::checkbox('is_wrapper', true, (!isset($menu)) ? false : $menu->is_wrapper) }}
                                            Wrapper
                                            <br><br>
                                            {{ Form::text('wrapper_width', (!isset($menu)) ? Input::old('wrapper_width') : $menu->wrapper_width, array('placeholder'=>'Wrapper width', 'style'=>'width:100px')) }} px
                                            {{ $errors->first('wrapper_width', '<span class="help-inline">:message</span>') }}
                                            <span class="help-inline">Leave blank for automatic width</span>
                                            <br>
                                            {{ Form::text('wrapper_height', (!isset($menu)) ? Input::old('wrapper_height') : $menu->wrapper_height, array('placeholder'=>'Wrapper height', 'style'=>'width:100px')) }} px
                                            {{ $errors->first('wrapper_height', '<span class="help-inline">:message</span>') }}
                                            <span class="help-inline">Leave blank for automatic height</span>
                                        </div>
                                    </div>

                                    <div class="control-group {{{ $errors->has('icon') ? 'error' : '' }}}">
                                        <label class="control-label">Menu Icon</label>
                                        <div class="controls">
                                            {{ Form::file('icon', Input::old('icon'), array('class' => 'input-xlarge')) }}
                                            {{ $errors->first('icon', '<span class="help-inline">:message</span>') }}
                                        </div>
                                    </div>

                                    <div class="control-group {{{ $errors->has('display_text') ? 'error' : '' }}}">
                                        <label class="control-label">Display Text</label>
                                        <div class="controls">
                                            {{ Form::text('display_text', (!isset($menu)) ? Input::old('display_text') : $menu->display_text, array('class' => 'input-xlarge'))}}
                                            {{ $errors->first('display_text', '<span class="help-inline">:message</span>') }}
                                        </div>
                                    </div>

                                    <div class="control-group {{{ $errors->has('same_window') ? 'error' : '' }}}">
                                        <label class="control-label">Display to</label>
                                        <div class="controls line">
                                            {{ Form::radio('same_window', 'same', (isset($menu)) ? $menu->same_window : true) }}
                                            <span class="inline">Same Window</span>
                                            {{ Form::radio('same_window', 'different', (isset($menu)) ? !$menu->same_window : false) }}
                                            <span class="inline">New Window</span>
                                            {{ $errors->first('same_window', '<span class="help-inline">:message</span>') }}
                                        </div>
                                    </div>

                                    <div class="control-group {{{ $errors->has('show_image') ? 'error' : '' }}}">
                                        <label class="control-label">Show image</label>
                                        <div class="controls line">
                                            {{ Form::hidden('show_image', false) }}
                                            {{ Form::checkbox('show_image', true, (!isset($menu)) ? true : $menu->show_image) }}
                                            {{ $errors->first('show_image', '<span class="help-inline">:message</span>') }}
                                        </div>
                                    </div>

                                    <div class="control-group {{{ $errors->has('status') ? 'error' : '' }}}">
                                        <label class="control-label">Status <i class="red">*</i></label>
                                        <div class="controls line">
                                            {{ Form::select('status', Menu::all_status(), (!isset($menu)) ? Input::old('status') : $menu->status, array('class'=>'chosen span6 m-wrap', 'style'=>'width:285px')) }}
                                            {{ $errors->first('status', '<span class="help-inline">:message</span>') }}
                                        </div>
                                    </div>

                                    <div class="control-group {{{ $errors->has('access_groups') ? 'error' : '' }}}">
                                        <label class="control-label">Access Group(s) </label>
                                        <div class="controls line">
                                            {{ Form::select('access_groups[]', UserGroup::all_groups(), (!isset($menu)) ? Input::old('access_groups') : $menu->selected_groups(), array('class'=>'chosen span6 m-wrap', 'multiple', 'data-placeholder'=>'Select access group(s)', 'style'=>'width:285px')) }}
                                            <span class="help-inline">If no group is selected, the menu will be publicly accessible</span>
                                            {{ $errors->first('access_groups', '<span class="help-inline">:message</span>') }}
                                        </div>
                                    </div>

                                    <div class="control-group {{{ $errors->has('target') ? 'error' : '' }}}">
                                        <label class="control-label">Target <i class="red">*</i></label>
                                        <div class="controls line">
                                            {{ Form::select('target', Menu::all_targets(), (!isset($menu)) ? Input::old('target') : $menu->target, array('class'=>'chosen span6 m-wrap', 'style'=>'width:285px')) }}
                                            {{ $errors->first('target', '<span class="help-inline">:message</span>') }}
                                        </div>
                                    </div>

                                    <div class="control-group {{{ $errors->has('order') ? 'error' : '' }}}">
                                        <label class="control-label">Display Order</label>
                                        <div class="controls">
                                            {{ Form::text('order', (!isset($menu)) ? Input::old('order') : $menu->order, array('class' => 'input-xlarge'))}}
                                            {{ $errors->first('order', '<span class="help-inline">:message</span>') }}
                                        </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label">Parent Menu Entry</label>
                                        <div class="controls">
                                            @if (isset($menu))
                                                {{Form::select('parent', Menu::menu_entries($menu->id), $menu->parent, array('class'=>'chosen input-xlarge', 'style'=>'width:285px')) }}
                                            @else
                                                {{Form::select('parent', Menu::menu_entries(), 0, array('class'=>'chosen input-xlarge', 'style'=>'width:285px')) }}
                                            @endif
                                        </div>
                                    </div>

                                    <div class="control-group {{{ $errors->has('category') ? 'error' : '' }}}">
                                        <label class="control-label">Menu Category <i class="red">*</i></label>
                                        <div class="controls">
                                            @if (isset($menu))
                                                {{Form::select('category', MenuCategory::lists('name', 'id'), $menu->category, array('class'=>'chosen input-xlarge', 'style'=>'width:285px', 'data-placeholder'=>'Select a category')) }}
                                            @else
                                                {{Form::select('category', MenuCategory::lists('name', 'id'), Input::old('category'), array('class'=>'chosen input-xlarge', 'style'=>'width:285px', 'data-placeholder'=>'Select a category')) }}
                                            @endif

                                            {{ HTML::link("$link_type/menu-categories/create", "Add Category", array('class'=>'btn btn-mini mb-15')) }}

                                            {{ $errors->first('category', '<span class="help-inline">:message</span>') }}
                                        </div>
                                    </div>

                                    <div class="control-group {{{ $errors->has('publish_start') ? 'error' : '' }}}">
                                        <label class="control-label">Publish Start</label>
                                        <div class="controls line">
                                            <div id="datetimepicker_start" class="input-append">
                                                {{ Form::text('publish_start', (!isset($menu)) ? '' : $menu->publish_start, array('data-format'=>'yyyy-MM-dd hh:mm:ss')) }}
                                                <span class="add-on">
                                                    <i data-time-icon="icon-time" data-date-icon="icon-calendar">
                                                    </i>
                                                </span>
                                            </div>
                                            <span class="help-inline">Leave blank to start publishing immediately.</span>
                                            {{ $errors->first('publish_start', '<span class="help-inline">:message</span>') }}
                                        </div>
                                    </div>

                                    <div class="control-group {{{ $errors->has('publish_end') ? 'error' : '' }}}">
                                        <label class="control-label">Publish End</label>
                                        <div class="controls line">
                                            <div id="datetimepicker_end" class="input-append">
                                                {{ Form::text('publish_end', (!isset($menu)) ? '' : $menu->publish_end, array('data-format'=>'yyyy-MM-dd hh:mm:ss')) }}
                                                <span class="add-on">
                                                    <i data-time-icon="icon-time" data-date-icon="icon-calendar">
                                                    </i>
                                                </span>
                                            </div>
                                            <span class="help-inline">Leave blank to never stop publishing.</span>
                                            {{ $errors->first('publish_end', '<span class="help-inline">:message</span>') }}
                                        </div>
                                    </div>

                                    <div class="control-group {{{ $errors->has('meta_description') ? 'error' : '' }}}">
                                        <label class="control-label">Meta Description</label>
                                        <div class="controls line">
                                           <textarea class="span12 m-wrap" name="meta_description" rows="3">{{ (!isset($menu)) ? Input::old('meta_description') : $menu->meta_description }}</textarea>
                                           {{ $errors->first('meta_description', '<span class="help-inline">:message</span>') }}
                                        </div>
                                    </div>

                                    <div class="control-group {{{ $errors->has('meta_keywords') ? 'error' : '' }}}">
                                        <label class="control-label">Meta Keywords</label>
                                        <div class="controls line">
                                           <textarea class="span12 m-wrap" name="meta_keywords" rows="2">{{ (!isset($menu)) ? Input::old('meta_keywords') : $menu->meta_keywords }}</textarea>
                                           {{ $errors->first('meta_keywords', '<span class="help-inline">:message</span>') }}
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

@section('scripts')
    <script type="text/javascript" src="{{ URL::to("assets/backend/default/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js") }}"></script>
    @parent
    <script>
        function showOrHide() {
            value = $('#link').val();
            if (value == 'manual') {
                $('#manual-link').show();
            } else {
                $('#manual-link').hide();
            }
        }
        jQuery(document).ready(function() {
            $.uniform.restore("input[type=radio]");
            // $('input[type=checkbox]').uniform();
            showOrHide();
            $('#link').on('change', function() {
                showOrHide();
            });
            $('#datetimepicker_start').datetimepicker({
                language: 'en',
                pick12HourFormat: false
            });
            $('#datetimepicker_end').datetimepicker({
                language: 'en',
                pick12HourFormat: false
            });
        });
    </script>
@stop
