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
                        @if (!isset($slide))
                            <span class="hidden-480">Create New Slide</span>
                        @else
                            <span class="hidden-480">Edit Slide</span>
                        @endif
                        &nbsp;
                    </h4>
                </div>
                <div class="widget-body form">
                    <div class="tabbable widget-tabs">
                        <div class="tab-content">
                            <div class="tab-pane active" id="widget_tab1">
                                <!-- BEGIN FORM-->
                                @if (!isset($slide))
                                {{ Form::open(array('route'=>$link_type . '.slideshow.store', 'method'=>'POST', 'class'=>'form-horizontal', 'files'=>true)) }}
                                @else
                                {{ Form::open(array('route' => array($link_type . '.slideshow.update', $slide->id), 'method'=>'PUT', 'class'=>'form-horizontal', 'files'=>true)) }}
                                @endif

                                    @if ($errors->has())
                                         <div class="alert alert-error hide" style="display: block;">
                                           <button data-dismiss="alert" class="close">×</button>
                                           You have some form errors. Please check below.
                                        </div>
                                    @endif

                                    @if (isset($slide))
                                        {{ Form::hidden('id', $slide->id) }}
                                    @endif

                                    <div class="control-group {{{ $errors->has('content') ? 'error' : '' }}}">
                                        <label class="control-label">Caption <span class="red">*</span></label>
                                        <div class="controls line">
                                           <textarea class="span12 ckeditor m-wrap" name="caption" rows="6">{{ (!isset($slide)) ? Input::old('caption') : $slide->caption }}</textarea>
                                           {{ $errors->first('caption', '<span class="help-inline">:message</span>') }}
                                        </div>
                                    </div>

                                    <div class="control-group {{{ $errors->has('image') ? 'error' : '' }}}">
                                        <label class="control-label">Image (940x470px) <span class="red">*</span></label>
                                        <div class="controls">
                                            {{ Form::file('image', array('class' => 'input-xlarge')) }}
                                            {{ $errors->first('image', '<span class="help-inline">:message</span>') }}
                                        </div>
                                    </div>

                                    <div class="control-group {{{ $errors->has('status') ? 'error' : '' }}}">
                                        <label class="control-label">Status <span class="red">*</span></label>
                                        <div class="controls line">
                                            {{ Form::select('status', {{ trans('cms.slideshow') }}::all_status(), (!isset($slide)) ? Input::old('status') : $slide->status, array('class'=>'chosen span6 m-wrap', 'style'=>'width:285px')) }}
                                            {{ $errors->first('status', '<span class="help-inline">:message</span>') }}
                                        </div>
                                    </div>

                                    <!-- <div class="control-group {{{ $errors->has('publish_start') ? 'error' : '' }}}">
                                        <label class="control-label">Publish Start</label>
                                        <div class="controls line">
                                            <div id="datetimepicker_start" class="input-append">
                                                {{ Form::text('publish_start', (!isset($slide)) ? '' : $slide->publish_start, array('data-format'=>'yyyy-MM-dd HH:mm:ss')) }}
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
                                                {{ Form::text('publish_end', (!isset($slide)) ? '' : $slide->publish_end, array('data-format'=>'yyyy-MM-dd HH:mm:ss')) }}
                                                <span class="add-on">
                                                    <i data-time-icon="icon-time" data-date-icon="icon-calendar">
                                                    </i>
                                                </span>
                                            </div>
                                            <span class="help-inline">Leave blank to never stop publishing.</span>
                                            {{ $errors->first('publish_end', '<span class="help-inline">:message</span>') }}
                                        </div>
                                    </div> -->

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
    <script type="text/javascript" src="{{ URL::to("assets/backend/default/plugins/ckeditor/ckeditor.js") }}"></script>
    <script type="text/javascript" src="{{ URL::to("assets/backend/default/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js") }}"></script>
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
    </script>
@stop
