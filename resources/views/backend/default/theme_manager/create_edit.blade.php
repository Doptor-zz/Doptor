@section('content')
    <div class="row-fluid">
        <div class="span12">
            <!-- BEGIN FORM widget-->
            <div class="widget box blue tabbable">
                <div class="blue widget-title">
                    <h4>
                        <i class="icon-user"></i>
                        <span class="hidden-480">{!! trans('options.install_new') !!} {!! trans('fields.theme') !!}</span>
                        &nbsp;
                    </h4>
                </div>
                <div class="widget-body form">
                    <div class="tabbable widget-tabs">
                        <div class="tab-content">
                            <div class="tab-pane active" id="widget_tab1">
                                <!-- BEGIN FORM-->
                                {!! Form::open(array('route'=>$link_type . '.theme-manager.store', 'method'=>'POST', 'class'=>'form-horizontal', 'files'=>true)) !!}

                                    @if ($errors->has())
                                         <div class="alert alert-error hide" style="display: block;">
                                           <button data-dismiss="alert" class="close">×</button>
                                           {!! trans('errors.form_errors') !!}
                                        </div>
                                    @endif

                                    <div class="control-group">
                                        <label class="control-label">{!! trans('fields.theme_file') !!} <span class="red">*</span></label>
                                        <div class="controls">
                                            <input type="file" class="default" name="file" />
                                        </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label">{!! trans('fields.target') !!} <i class="red">*</i></label>
                                        <div class="controls line">
                                            {!! Form::select('target', Theme::all_targets(), Input::old('target'), array('class'=>'chosen span6 m-wrap', 'style'=>'width:285px')) !!}
                                        </div>
                                    </div>
                                    <br>

                                    <div class="control-group">
                                       <label class="control-label">Install sample data?</label>
                                       <div class="controls">
                                            {!! Form::hidden('install_sample_data', false) !!}
                                            {!! Form::checkbox('install_sample_data', true, Input::old('install_sample_data', false)) !!}
                                       </div>
                                    </div>

                                    <div class="form-actions">
                                        <button type="submit" class="btn btn-primary"><i class="icon-ok"></i> {!! trans('options.install_new') !!}</button>
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
