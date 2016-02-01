@section('styles')
    <style>
        #styler { top:0; }
        .form-group {
            border: 1px solid #d3d3d3;
            border-radius: 3px;
            padding: 10px;
            margin-left: 0 !important;
            margin-right: 20px !important;
            margin-bottom: 20px !important;
        }
    </style>
@stop

@section('content')
    <div class="row-fluid">
        <div class="span12">
            <div class="widget box blue" id="form_wizard_1">
                <div class="blue widget-title">
                    <h4>
                        <i class="icon-reorder"></i> {!! trans('cms.module_builder') !!} - <span class="step-title">Step 1 of 3</span>
                    </h4>
                </div>
                <div class="widget-body form">
                    @if (!isset($module))
                    {!! Form::open(array('route'=>$link_type . '.module-builder.store', 'method'=>'POST', 'class'=>'form-horizontal', 'id'=>'module-builder')) !!}
                    @else
                    {!! Form::open(array('route' => array($link_type . '.module-builder.update', $module->id), 'method'=>'PUT', 'class'=>'form-horizontal')) !!}
                    @endif

                    @if ($errors->has())
                        <div class="alert alert-error hide" style="display: block;">
                            <button data-dismiss="alert" class="close">×</button>
                            {!! trans('errors.form_errors') !!}
                        </div>
                    @endif

                    <div class="form-wizard">
                        <div class="navbar steps">
                            <div class="navbar-inner">
                                <ul class="row-fluid">
                                    <li class="span3">
                                        <a href="#tab1" data-toggle="tab" class="step active">
                                            <span class="number">1</span>
                                            <span class="desc"><i class="icon-ok"></i> Module Details</span>
                                        </a>
                                    </li>
                                    <li class="span3">
                                        <a href="#tab2" data-toggle="tab" class="step">
                                            <span class="number">2</span>
                                            <span class="desc"><i class="icon-ok"></i> Form Selection</span>
                                        </a>
                                    </li>
                                    <li class="span3">
                                        <a href="#tab3" data-toggle="tab" class="step">
                                            <span class="number">3</span>
                                            <span class="desc"><i class="icon-ok"></i> {!! trans('options.confirm') !!}</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div id="bar" class="progress progress-success progress-striped">
                            <div class="bar"></div>
                        </div>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab1">
                                <h4>Provide module details</h4>
                                <div class="control-group {!! $errors->has('name') ? 'error' : '' !!}">
                                    <label class="control-label">{!! trans('fields.name') !!} <i class="red">*</i></label>
                                    <div class="controls">
                                        {!! Form::text('name', (!isset($module)) ? Input::old('name') : $module->name, array('class' => 'span6', (isset($module) && !$module->is_author ? 'readonly' : '')))!!}
                                        {!! $errors->first('name', '<span class="help-inline">:message</span>') !!}
                                    </div>
                                </div>
                                <div class="control-group {!! $errors->has('version') ? 'error' : '' !!}">
                                    <label class="control-label">{!! trans('fields.version') !!} <i class="red">*</i></label>
                                    <div class="controls">
                                        {!! Form::text('version', (!isset($module)) ? Input::old('version') : $module->version, array('class' => 'span6', (isset($module) && !$module->is_author ? 'readonly' : '')))!!}
                                        {!! $errors->first('version', '<span class="help-inline">:message</span>') !!}
                                    </div>
                                </div>
                                <div class="control-group {!! $errors->has('author') ? 'error' : '' !!}">
                                    <label class="control-label">{!! trans('fields.author') !!} <i class="red">*</i></label>
                                    <div class="controls">
                                        {!! Form::text('author', (!isset($module)) ? Input::old('author') : $module->author, array('class' => 'span6', (isset($module) && !$module->is_author ? 'readonly' : '')))!!}
                                        {!! $errors->first('author', '<span class="help-inline">:message</span>') !!}
                                    </div>
                                </div>
                                <div class="control-group {!! $errors->has('vendor') ? 'error' : '' !!}">
                                    <label class="control-label">Vendor {!! trans('fields.name') !!} <i class="red">*</i></label>
                                    <div class="controls">
                                        {!! Form::text('vendor', (!isset($module)) ? Input::old('vendor') : $module->vendor, array('class' => 'span6', (isset($module) && !$module->is_author ? 'readonly' : '')))!!}
                                        <span class="help-inline">Shouldn't contain spaces or special characters</span>
                                        {!! $errors->first('vendor', '<span class="help-inline">:message</span>') !!}
                                    </div>
                                </div>
                                <div class="control-group {!! $errors->has('website') ? 'error' : '' !!}">
                                    <label class="control-label">{!! trans('fields.website') !!} {!! trans('fields.address') !!}</label>
                                    <div class="controls">
                                        {!! Form::text('website', (!isset($module)) ? Input::old('website') : $module->website, array('class' => 'span6', (isset($module) && !$module->is_author ? 'readonly' : '')))!!}
                                        {!! $errors->first('website', '<span class="help-inline">:message</span>') !!}
                                    </div>
                                </div>
                                <div class="control-group {!! $errors->has('description') ? 'error' : '' !!}">
                                    <label class="control-label">Module {!! trans('fields.description') !!}</label>
                                    <div class="controls">
                                        {!! Form::textarea('description', (!isset($module)) ? Input::old('description') : $module->description, array('class' => 'span6', 'rows'=>2, (isset($module) && !$module->is_author ? 'readonly' : '')))!!}
                                        {!! $errors->first('description', '<span class="help-inline">:message</span>') !!}
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab2">
                                <h4>Select form(s)</h4>
                                <div class="control-group">
                                    <label class="control-label">Form(s) <i class="red">*</i></label>
                                    <div class="controls">
                                        @for ($i = 0; $i < count($selected_forms); $i++)
                                            <div class="form-list pull-left form-group">
                                                <p>
                                                    {!! Form::select('selected-forms[]', BuiltForm::all_forms(), $selected_forms[$i], array('class'=>'chosen module-form')) !!}
                                                </p>
                                                <p>
                                                    Fields to show in data list: <br>
                                                    {!! Form::select('form-fields-'.$i.'[]', [], '', array('class'=>'chosen form-fields', 'multiple')) !!}
                                                </p>
                                                <p class="pull-right">
                                                    <a href="#" class="btn btn-add"><i class="icon-plus"></i></a>
                                                    <a href="#" class="btn btn-remove"><i class="icon-remove"></i></a>
                                                </p>
                                                <div class="clearfix"></div>
                                            </div>
                                        @endfor

                                        <div class="pull-right">{!! HTML::link("$link_type/form-builder/create", trans('options.create_new'). " " . trans('fields.form'), array('class'=>'pull-right btn btn-mini mb-15')) !!}</div>

                                        <div class="clearfix"></div>
                                    </div>
                                </div>

                                <div class="control-group {!! $errors->has('target') ? 'error' : '' !!}">
                                    <label class="control-label">{!! trans('fields.target') !!} <i class="red">*</i></label>
                                    <div class="controls line">
                                        {!! Form::select('target[]', Menu::all_targets(), (!isset($module)) ? Input::old('target') : $module->selected_targets(), array('class'=>'chosen span6 m-wrap', 'style'=>'width:285px', 'multiple', 'data-placeholder'=>'Select target')) !!}
                                        {!! $errors->first('target', '<span class="help-inline">:message</span>') !!}
                                    </div>
                                </div>

                                <div class="control-group hide" id="form-dropdowns">
                                    <label class="control-label">Source for form dropdowns</label>
                                    {!! Form::select('', $select, '', array('id'=>'dropdown-options', 'class'=>'hide')) !!}
                                </div>

                                <div class="control-group {!! $errors->has('requires') ? 'error' : '' !!}">
                                    <label class="control-label">Depends on modules</label>
                                    <div class="controls line">
                                        {!! Form::select('requires[]', $all_modules, (!isset($module)) ? Input::old('requires') : $module->required_modules(), array('class'=>'chosen span6 m-wrap', 'style'=>'width:285px', 'multiple', 'data-placeholder'=>'Select modules required for this module')) !!}
                                        {!! $errors->first('requires', '<span class="help-inline">:message</span>') !!}
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab3">
                                <h4>{!! trans('options.confirm') !!} options</h4>
                                <div class="control-group">
                                    <label class="control-label">Module {!! trans('fields.name') !!}:</label>
                                    <div class="controls">
                                        <span class="text" id="name"></span>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Module {!! trans('fields.version') !!}:</label>
                                    <div class="controls">
                                        <span class="text" id="version"></span>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Module {!! trans('fields.author') !!}:</label>
                                    <div class="controls">
                                        <span class="text" id="author"></span>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Module {!! trans('fields.website') !!}:</label>
                                    <div class="controls">
                                        <span class="text" id="website"></span>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Module {!! trans('fields.description') !!}:</label>
                                    <div class="controls">
                                        <span class="text" id="description"></span>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label"></label>
                                    <div class="controls">
                                        <label class="checkbox">
                                            <input type="checkbox" name="confirmed" value="true" /> I confirm my options
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions clearfix">
                            <a href="javascript:;" class="btn button-previous">
                                <i class="icon-angle-left"></i> Back
                            </a>
                            <a href="javascript:;" class="btn btn-primary blue button-next">
                                Continue <i class="icon-angle-right"></i>
                            </a>
                            {!! Form::submit('Submit', array('class'=>'btn btn-success button-submit')) !!}
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@stop

@section('scripts')
    @include('backend.default.module_builders.scripts')
@stop
