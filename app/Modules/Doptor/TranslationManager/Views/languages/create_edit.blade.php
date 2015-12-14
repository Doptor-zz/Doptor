@section('styles')
    {!! HTML::style('assets/backend/default/plugins/bootstrap/css/bootstrap-modal.css') !!}
    {!! HTML::style('assets/backend/default/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') !!}
@stop

@section('content')
    <div class="row-fluid">
        <div class="span12">
            <!-- BEGIN FORM widget-->
            <div class="widget box blue tabbable">
                <div class="blue widget-title">
                    <h4>
                        <i class="icon-user"></i>
                        @if (!isset($language))
                            <span class="hidden-480">Create New Language</span>
                        @else
                            <span class="hidden-480">Edit Language Info</span>
                        @endif
                        &nbsp;
                    </h4>
                </div>
                <div class="widget-body form">
                    <div class="tabbable widget-tabs">
                        <div class="tab-content">
                            <div class="tab-pane active" id="widget_tab1">
                                <!-- BEGIN FORM-->
                                @if (!isset($language))
                                {!! Form::open(array('route'=>$link_type . '.modules.doptor.translation_manager.languages.store', 'method'=>'POST', 'class'=>'form-horizontal', 'files'=>true)) !!}
                                @else
                                {!! Form::open(array('route' => array($link_type . '.modules.doptor.translation_manager.languages.update', $language->id), 'method'=>'PUT', 'class'=>'form-horizontal', 'files'=>true)) !!}
                                @endif

                                    @if ($errors->has())
                                         <div class="alert alert-error hide" style="display: block;">
                                           <button data-dismiss="alert" class="close">×</button>
                                           You have some form errors. Please check below.
                                        </div>
                                    @endif

                                    <div class="control-group {{ $errors->has('name') ? 'error' : '' }}">
                                        <label class="control-label">Name <span class="red">*</span></label>
                                        <div class="controls line">
                                        {!! Form::text('name', (!isset($language)) ? Input::old('name') : $language->name) !!}
                                           {!! $errors->first('name', '<span class="help-inline">:message</span>') !!}
                                        </div>
                                    </div>

                                    <div class="control-group {{ $errors->has('code') ? 'error' : '' }}">
                                        <label class="control-label">Code <span class="red">*</span></label>
                                        <div class="controls line">
                                        {!! Form::text('code', (!isset($language)) ? Input::old('code') : $language->code) !!}
                                        <span class="help-inline">
                                            (Example: en for English)
                                        </span>
                                        {!! $errors->first('code', '<span class="help-inline">:message</span>') !!}
                                        </div>
                                    </div>

                                    <br>

                                    <div class="form-actions">
                                        <button type="submit" class="btn btn-primary"><i class="icon-ok"></i> Save</button>
                                    </div>
                                {!! Form::close() !!}
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
    {!! HTML::script('assets/backend/default/plugins/bootstrap/js/bootstrap-modalmanager.js') !!}
    {!! HTML::script('assets/backend/default/plugins/bootstrap/js/bootstrap-modal.js') !!}
    {!! HTML::script("assets/backend/default/plugins/ckeditor/ckeditor.js") !!}
    {!! HTML::script("assets/backend/default/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js") !!}
    {!! HTML::script("assets/backend/default/scripts/media-selection.js") !!}
    @parent
    <script>
        // jQuery(document).ready(function() {
        //     $('#datetimepicker_start').datetimepicker({
        //         language: 'en',
        //         pick12HourFormat: false
        //     });
        //     $('#datetimepicker_end').datetimepicker({
        //         language: 'en',
        //         pick12HourFormat: false
        //     });
        // });

        MediaSelection.init('image');
    </script>
@stop
