@section('content')
    <div class="row-fluid">
        <div class="span12">
            <!-- BEGIN FORM widget-->
            <div class="widget box blue tabbable">
                <div class="blue widget-title">
                    <h4>
                        <i class="icon-user"></i>
                        <span class="hidden-480">{!! trans('options.install_new') !!} {!! trans('fields.language') !!}</span>
                        &nbsp;
                    </h4>
                </div>
                <div class="widget-body form">
                    <div class="tabbable widget-tabs">
                        <div class="tab-content">
                            <div class="tab-pane active" id="widget_tab1">
                                <!-- BEGIN FORM-->
                                {!! Form::open(['method'=>'POST', 'class'=>'form-horizontal', 'files'=>true]) !!}

                                    @if ($errors->has())
                                         <div class="alert alert-error hide" style="display: block;">
                                           <button data-dismiss="alert" class="close">×</button>
                                           {!! trans('errors.form_errors') !!}
                                        </div>
                                    @endif

                                    <div class="control-group">
                                       <label class="control-label">{!! trans('form_messages.select_lang_file') !!}</label>
                                       <div class="controls">
                                          <input type="file" class="default" name="file" />
                                       </div>
                                    </div>

                                    <div class="control-group">
                                       <label class="control-label">{!! trans('form_messages.overwrite_lang_file') !!}</label>
                                       <div class="controls">
                                            {!! Form::hidden('replace_existing', false) !!}
                                            {!! Form::checkbox('replace_existing', true, Input::old('replace_existing', true)) !!}
                                       </div>
                                    </div>

                                    <div class="form-actions">
                                        <button type="submit" class="btn btn-primary"><i class="icon-ok"></i> {!! trans('options.install') !!}</button>
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
