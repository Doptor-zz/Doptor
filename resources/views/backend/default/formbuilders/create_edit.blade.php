@section('styles')
    {!! HTML::style('assets/backend/default/plugins/bootstrap-formbuilder/css/custom.css') !!}
    <style>
        #styler { top:0; }
    </style>
@stop

@section('content')
    <div class="row-fluid clearfix">
        <!-- Building Form. -->
        <div class="span6">
            <div class="widsget box blue clearfix">
                <div class="blue widget-title">
                    <h4>
                        <i class="icon-reorder"></i>
                        <span class="hidden-480">{!! trans('fields.form') !!}</span>
                        &nbsp;
                    </h4>
                </div>
                <div class="widget-body">
                    @if (!isset($form))
                    {!! Form::open(array('route'=>$link_type . '.form-builder.store', 'method'=>'POST', 'class'=>'form-horizontal', 'id'=>'form-builder')) !!}
                    @else
                    {!! Form::open(array('route'=>array($link_type . '.form-builder.update', $form->id), 'method'=>'PUT', 'class'=>'form-horizontal', 'id'=>'form-builder')) !!}
                    @endif

                        @if ($errors->has())
                             <div class="alert alert-error hide" style="display: block;">
                               <button data-dismiss="alert" class="close">×</button>
                               {!! trans('errors.form_errors') !!}
                               {!! $errors->first('name', '<br><span>:message</span>') !!}
                            </div>
                        @endif

                        <div class="control-group {!! $errors->has('category') ? 'error' : '' !!}">
                            <label class="control-label">{!! trans('fields.form') !!} {!! trans('cms.category') !!} <span class="red">*</span></label>
                            <div class="controls">

                                {!! Form::hidden('name', '', array('id'=>'form-name')) !!}
                                @if (isset($form))
                                {!! Form::select('category', FormCategory::all_categories(), $form->category, array('class'=>'chosen span6 m-wrap', 'style'=>'width:285px;')) !!}
                                @else
                                {!! Form::select('category', FormCategory::all_categories(), '', array('class'=>'chosen span6 m-wrap', 'style'=>'width:285px;')) !!}
                                @endif
                                {!! Form::hidden('rendered', '', array('id'=>'form-data')) !!}

                                {!! $errors->first('category', '<span class="help-inline">:message</span>') !!}

                                {!! HTML::link("$link_type/form-categories/create", "Add Category", array('class'=>'btn btn-mini')) !!}
                            </div>
                        </div>

                        <div class="control-group {!! $errors->has('description') ? 'error' : '' !!}">
                            <label class="control-label">{!! trans('fields.form') !!} {!! trans('fields.description') !!}</label>
                            <div class="controls">

                                @if (isset($form))
                                <textarea name="description" rows="3" class="input-xlarge">{!! $form->description !!}</textarea>
                                @else
                                <textarea name="description" rows="3" class="input-xlarge"></textarea>
                                @endif

                                {!! $errors->first('description', '<span class="help-inline">:message</span>') !!}

                            </div>
                        </div>

                        <div class="control-group {!! $errors->has('redirect_to') ? 'error' : '' !!}">
                            <label class="control-label">{!! trans('form_messages.redirect_to_after_saving') !!}</label>
                            <div class="controls">

                                @if (isset($form))
                                {!! Form::select('redirect_to', BuiltForm::redirect_to(), $form->redirect_to, array('class'=>'chosen span6 m-wrap', 'style'=>'width:285px;')) !!}
                                @else
                                {!! Form::select('redirect_to', BuiltForm::redirect_to(), '', array('class'=>'chosen span6 m-wrap', 'style'=>'width:285px;')) !!}
                                @endif

                                {!! $errors->first('redirect_to', '<span class="help-inline">:message</span>') !!}

                            </div>
                        </div>

                        <div class="control-group {!! $errors->has('redirect_to') ? 'error' : '' !!}">
                            <label class="control-label">{!! trans('form_messages.show_captcha') !!}</label>
                            <div class="controls line">
                                {!! Form::checkbox('show_captcha', 'checked', (!isset($form)) ? Input::old('show_captcha') : $form->show_captcha, array('class'=>'span6 m-wrap')) !!}
                                {!! $errors->first('show_captcha', '<span class="help-inline">:message</span>') !!}
                            </div>
                        </div>

                        <div class="control-group {!! $errors->has('extra_code') ? 'error' : '' !!}">
                            <label class="control-label">{!! trans('form_messages.extra_code') !!}</label>
                            <div class="controls">

                                @if (isset($form))
                                <textarea name="extra_code" rows="3" class="input-xlarge">{!! $form->extra_code !!}</textarea>
                                @else
                                <textarea name="extra_code" rows="3" class="input-xlarge"></textarea>
                                @endif

                                <span class="help-inline">{!! trans('form_messages.write_extra_code') !!}</span>

                                {!! $errors->first('extra_code', '<span class="help-inline">:message</span>') !!}

                            </div>
                        </div>

                        <div class="control-group {!! $errors->has('email') ? 'error' : '' !!}">
                            <label class="control-label">{!! trans('form_messages.send_to') !!} {!! trans('fields.email') !!}</label>
                            <div class="controls">
                                {!! Form::text('email', isset($form) ? $form->email : Input::old('email')) !!}

                                {!! $errors->first('email', '<span class="help-inline">:message</span>') !!}

                            </div>
                        </div>

                        @if (isset($form))
                        <textarea id="json-data" class="hide" name="data">{!! str_replace('\\', '', $form->data) !!}</textarea>
                        @else
                        <textarea id="json-data" class="hide" name="data"></textarea>
                        @endif

                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">{!! trans('options.save') !!} Form</button>
                        </div>

                    {!! Form::close() !!}
                    <div id="build">
                        <form id="target" class="form-horizontal">
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- / Building Form. -->

        <!-- Components -->
        <div class="span6">
            <div class="widget light-gray box">
                <div class="blue widget-title">
                    <h4>
                        <i class="icon-reorder"></i>
                        <span class="hidden-480">{!! trans('form_messages.drag_drop_components') !!}</span>
                        &nbsp;
                    </h4>
                </div>
                <div class="widget-body tabbable">
                    <ul class="nav nav-tabs" id="formtabs">
                        <!-- Tab nav -->
                    </ul>
                    <form class="form-horizontal" id="components">
                        <fieldset>
                            <div class="tab-content">
                                <!-- Tabs of snippets go here -->
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
        <!-- / Components -->

    </div>
@stop

@section('scripts')
    @include('backend.default.formbuilders.scripts')
@stop
