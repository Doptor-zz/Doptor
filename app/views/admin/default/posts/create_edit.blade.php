@section('styles')
    {{ HTML::style('assets/backend/default/plugins/bootstrap/css/bootstrap-modal.css') }}
    {{ HTML::style('assets/backend/default/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}
    {{ HTML::style('assets/backend/default/plugins/jquery-ui/jquery-ui.css') }}
    <style>
        .modal.fade.in {
        }
        #ajax-modal {
            left: 20px;
            margin: 0 auto !important;
            max-height: 400px;
            overflow-x: hidden;
            overflow-y: auto;
            padding: 15px;
            position: absolute;
            top: 20% !important;
            width: 95%;
        }
    </style>
@stop

@section('content')
    <div class="row-fluid">
        <div class="span12">
            <!-- BEGIN FORM widget-->
            <div class="widget box light-gray tabbable">
                <div class="blue widget-title">
                    <h4>
                        <i class="icon-user"></i>
                        @if (!isset($post))
                            <span class="hidden-480">Create New {{ Str::title($type) }}</span>
                        @else
                            <span class="hidden-480">Edit {{ Str::title($type) }}</span>
                        @endif
                        &nbsp;
                    </h4>
                </div>
                <div class="widget-body form">
                    <div class="tabbable widget-tabs">
                        <div class="tab-content">
                            <div class="tab-pane active" id="widget_tab1">
                                <!-- BEGIN FORM-->
                                @if (!isset($post))
                                {{ Form::open(array('route'=>$link_type . '.'. $type . 's.store', 'method'=>'POST', 'class'=>'form-horizontal', 'files'=>true)) }}
                                @else
                                {{ Form::open(array('route' => array($link_type . '.'. $type . 's.update', $post->id), 'method'=>'PUT', 'class'=>'form-horizontal', 'files'=>true)) }}
                                @endif

                                    @if ($errors->has())
                                         <div class="alert alert-error hide" style="display: block;">
                                           <button data-dismiss="alert" class="close">×</button>
                                           You have some form errors. Please check below.
                                        </div>
                                    @endif

                                    @if (isset($post))
                                        {{ Form::hidden('id', $post->id) }}
                                    @endif
                                    {{ Form::hidden('type', $type) }}
                                    <br>
                                    <div class="control-group {{{ $errors->has('title') ? 'error' : '' }}}">
                                        <label class="control-label">Title <span class="red">*</span></label>
                                        <div class="controls">
                                            {{ Form::text('title', (!isset($post)) ? Input::old('title') : $post->title, array('class' => 'input-xlarge'))}}
                                            {{ $errors->first('title', '<span class="help-inline">:message</span>') }}
                                        </div>
                                    </div>

                                    <div class="control-group {{{ $errors->has('permalink') ? 'error' : '' }}}">
                                        <label class="control-label">Alias</label>
                                        <div class="controls">
                                            {{ Form::text('permalink', (!isset($post)) ? Input::old('permalink') : $post->permalink, array('class' => 'input-xlarge'))}}
                                            <div class="help-inline">Leave blank for automatic alias</div>
                                            {{ $errors->first('permalink', '<span class="help-inline">:message</span>') }}
                                        </div>
                                    </div>

                                    <div class="control-group {{{ $errors->has('image') ? 'error' : '' }}}">
                                        <label class="control-label">Image <span class="red">*</span></label>
                                        <div class="controls">
                                            {{-- Form::file('image', array('class' => 'input-xlarge')) --}}
                                            {{ Form::hidden('image') }}
                                            <a class="btn btn-primary insert-media" id="insert-main-image" href="#"> Select main image</a>
                                            <span class="file-name">
                                                {{ $post->image or '' }}
                                            </span>
                                            {{ $errors->first('image', '<span class="help-inline">:message</span>') }}
                                        </div>
                                    </div>

                                    <div class="control-group">
                                        <div class="controls line">
                                            <a class="btn btn-primary insert-media" id="insert-media" href="#"> Insert Media</a>
                                        </div>
                                    </div>

                                    <div class="control-group {{{ $errors->has('content') ? 'error' : '' }}}">
                                        <label class="control-label">Description <span class="red">*</span></label>
                                        <div class="controls line">
                                           <textarea class="span12 ckeditor m-wrap" id="content" name="content" rows="6">{{ (!isset($post)) ? Input::old('content') : $post->content }}</textarea>
                                           {{ $errors->first('content', '<span class="help-inline">:message</span>') }}
                                        </div>
                                    </div>

                                    <div class="control-group {{{ $errors->has('categories') ? 'error' : '' }}}">
                                        <label class="control-label">Category</label>
                                        <div class="controls line">
                                            {{ Form::select('categories[]', Category::all_categories($type), (!isset($post)) ? Input::old('categories') : $post->selected_categories(), array('class'=>'chosen span6 m-wrap', 'style'=>'width:285px', 'multiple')) }}
                                            {{ $errors->first('categories', '<span class="help-inline">:message</span>') }}
                                        </div>
                                    </div>

                                    <div class="control-group {{{ $errors->has('target') ? 'error' : '' }}}">
                                        <label class="control-label">Target <span class="red">*</span></label>
                                        <div class="controls line">
                                            {{ Form::select('target', Post::all_targets(), (!isset($post)) ? Input::old('target') : $post->target, array('class'=>'chosen span6 m-wrap', 'style'=>'width:285px')) }}
                                            {{ $errors->first('target', '<span class="help-inline">:message</span>') }}
                                        </div>
                                    </div>

                                    <div class="control-group {{{ $errors->has('status') ? 'error' : '' }}}">
                                        <label class="control-label">Status <span class="red">*</span></label>
                                        <div class="controls line">
                                            {{ Form::select('status', Post::all_status(), (!isset($post)) ? Input::old('status') : $post->status, array('class'=>'chosen span6 m-wrap', 'style'=>'width:285px')) }}
                                            {{ $errors->first('status', '<span class="help-inline">:message</span>') }}
                                        </div>
                                    </div>

                                    <div class="control-group {{{ $errors->has('featured') ? 'error' : '' }}}">
                                        <label class="control-label">Featured?</label>
                                        <div class="controls line">
                                            {{ Form::checkbox('featured', 'checked', (!isset($post)) ? Input::old('featured') : $post->featured, array('class'=>'span6 m-wrap')) }}
                                            {{ $errors->first('featured', '<span class="help-inline">:message</span>') }}
                                        </div>
                                    </div>

                                    <div class="control-group {{{ $errors->has('publish_start') ? 'error' : '' }}}">
                                        <label class="control-label">Publish Start</label>
                                        <div class="controls line">
                                            <div id="datetimepicker_start" class="input-append">
                                                {{ Form::text('publish_start', (!isset($post)) ? '' : $post->publish_start, array('data-format'=>'yyyy-MM-dd HH:mm:ss')) }}
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
                                                {{ Form::text('publish_end', (!isset($post)) ? '' : $post->publish_end, array('data-format'=>'yyyy-MM-dd HH:mm:ss')) }}
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
                                           <textarea class="span12 m-wrap" name="meta_description" rows="3">{{ (!isset($post)) ? Input::old('meta_description') : $post->meta_description }}</textarea>
                                           {{ $errors->first('meta_description', '<span class="help-inline">:message</span>') }}
                                        </div>
                                    </div>

                                    <div class="control-group {{{ $errors->has('meta_keywords') ? 'error' : '' }}}">
                                        <label class="control-label">Meta Keywords</label>
                                        <div class="controls line">
                                           <textarea class="span12 m-wrap" name="meta_keywords" rows="2">{{ (!isset($post)) ? Input::old('meta_keywords') : $post->meta_keywords }}</textarea>
                                           {{ $errors->first('meta_keywords', '<span class="help-inline">:message</span>') }}
                                        </div>
                                    </div>

                                    <br>

                                    <div class="form-actions">
                                        <button type="submit" class="btn btn-primary" name="form_save">Save</button>

                                        <button type="submit" class="btn btn-success" name="form_save_new">Save &amp; New</button>

                                        <button type="submit" class="btn btn-primary btn-danger" name="form_close">Close</button>
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
    <div id="ajax-add-modal" class="modal hide fade page-container" tabindex="-1"></div>
@stop

@section('scripts')
    {{ HTML::script('assets/backend/default/plugins/bootstrap/js/bootstrap-modalmanager.js') }}
    {{ HTML::script('assets/backend/default/plugins/bootstrap/js/bootstrap-modal.js') }}
    {{ HTML::script("assets/backend/default/plugins/ckeditor/ckeditor.js") }}">
    {{ HTML::script("assets/backend/default/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js") }}">
    {{ HTML::script("assets/admin/default/js/media-selection.js") }}
    @parent
    <script>
        jQuery(document).ready(function() {
            $('#datetimepicker_start').datetimepicker({
                language: 'en',
                pick12HourFormat: false
            });
            $('#datetimepicker_end').datetimepicker({
                language: 'en',
                pick12HourFormat: false
            });
        });

        MediaSelection.init('image');
    </script>
@stop
