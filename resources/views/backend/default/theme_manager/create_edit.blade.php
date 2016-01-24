@section('content')
    <div class="row-fluid">
        <div class="span12">
            <!-- BEGIN FORM widget-->
            <div class="widget box blue tabbable">
                <div class="blue widget-title">
                    <h4>
                        <i class="icon-user"></i>
                        @if (!isset($theme))
                            <span class="hidden-480">{!! trans('options.install_new') !!} {!! trans('fields.theme') !!}</span>
                        @else
                            <span class="hidden-480">{!! trans('options.edit') !!} {!! trans('fields.theme') !!}</span>
                        @endif
                        &nbsp;
                    </h4>
                </div>
                <div class="widget-body form">
                    <div class="tabbable widget-tabs">
                        <div class="tab-content">
                            <div class="tab-pane active" id="widget_tab1">
                                <!-- BEGIN FORM-->
                                @if (!isset($theme))
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

                                        <div class="form-actions">
                                            <button type="submit" class="btn btn-primary"><i class="icon-ok"></i> {!! trans('options.install_new') !!}</button>
                                        </div>

                                    {!! Form::close() !!}
                                @else
                                    {!! Form::open(array('route' => array($link_type . '.theme-manager.update', $theme->id), 'method'=>'PUT', 'class'=>'form-horizontal')) !!}

                                        {!! Form::text('id', $theme->id, array('class' => 'hide')) !!}

                                        {!! HTML::image($theme->image, '', array('width'=>'500')) !!}

                                        <br><br>

                                        <div class="control-group {!! $errors->has('caption') ? 'error' : '' !!}">
                                            <label class="control-label">{!! trans('fields.caption') !!}</label>
                                            <div class="controls">
                                                {!! Form::text('caption', $theme->caption, array('class' => 'input-xlarge'))!!}
                                                {!! $errors->first('caption', '<span class="help-inline">:message</span>') !!}
                                            </div>
                                        </div>

                                        <div class="form-actions">
                                            <button type="submit" class="btn btn-primary"><i class="icon-ok"></i> {!! trans('options.save') !!}</button>
                                        </div>
                                    {!! Form::close() !!}
                                @endif
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
