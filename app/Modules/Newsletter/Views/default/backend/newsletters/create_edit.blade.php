@section('content')
    <div class="row-fluid">
        <div class="span12">
            <!-- BEGIN FORM widget-->
            <div class="widget box blue tabbable">
                <div class="blue widget-title">
                    <h4>
                        <i class="icon-user"></i>
                        Send newsletter
                        &nbsp;
                    </h4>
                </div>
                <div class="widget-body form">
                    <div class="tabbable widget-tabs">
                        <div class="tab-content">
                            <div class="tab-pane active" id="widget_tab1">
                                <!-- BEGIN FORM-->
                                {!! Form::open(array('route'=>$link_type . '.modules.newsletters.store', 'method'=>'POST', 'class'=>'form-horizontal')) !!}

                                    @if ($errors->has())
                                         <div class="alert alert-error hide" style="display: block;">
                                           <button data-dismiss="alert" class="close">×</button>
                                           {!! trans('errors.form_errors') !!}
                                        </div>
                                    @endif

                                    <div class="control-group {{ $errors->has('subject') ? 'error' : '' }}">
                                        <label class="control-label">Subject <span class="red">*</span></label>
                                        <div class="controls">
                                            {!! Form::text('subject', Input::old('subject'), array('class' => 'input-xlarge'))!!}
                                            {!! $errors->first('subject', '<span class="help-inline">:message</span>') !!}
                                        </div>
                                    </div>

                                    <div class="control-group {{ $errors->has('content') ? 'error' : '' }}">
                                        <label class="control-label">Content <span class="red">*</span></label>
                                        <div class="controls">
                                            {!! Form::textarea('content', Input::old('content'), array('class' => 'input-xlarge ckeditor'))!!}
                                            {!! $errors->first('content', '<span class="help-inline">:message</span>') !!}
                                        </div>
                                    </div>

                                    <div class="form-actions">
                                        <button type="submit" class="btn btn-primary" name="form_save">Send</button>

                                        <button type="submit" class="btn btn-success" name="form_save_new">Send &amp; New</button>

                                        <button type="submit" class="btn btn-primary btn-danger" name="form_close">Close</button>
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
    {!! HTML::script("assets/backend/default/plugins/ckeditor/ckeditor.js") !!}">

    @parent
@stop
