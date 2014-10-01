@section('styles')
    <style>
        #styler { top:0; }
        #AddMore, .removeclass { margin: 0 0 0 220px;}
    </style>
@stop

@section('content')
    <div class="row-fluid">
        <div class="span12">
            <div class="widget box blue" id="form_wizard_1">
                <div class="blue widget-title">
                    <h4>
                        <i class="icon-reorder"></i> {{ trans('cms.module_builder') }} - <span class="step-title">Step 1 of 3</span>
                    </h4>
                </div>
                <div class="widget-body form">
                    @if (!isset($module))
                    {{ Form::open(array('route'=>$link_type . '.module-builder.store', 'method'=>'POST', 'class'=>'form-horizontal', 'id'=>'module-builder')) }}
                    @else
                    {{ Form::open(array('route' => array($link_type . '.module-builder.update', $module->id), 'method'=>'PUT', 'class'=>'form-horizontal')) }}
                    @endif

                    @if ($errors->has())
                        <div class="alert alert-error hide" style="display: block;">
                            <button data-dismiss="alert" class="close">×</button>
                            You have some form errors. Please check below.
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
                                            <span class="desc"><i class="icon-ok"></i> Confirm</span>
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
                                <div class="control-group {{{ $errors->has('name') ? 'error' : '' }}}">
                                    <label class="control-label">Name <i class="red">*</i></label>
                                    <div class="controls">
                                        {{ Form::text('name', (!isset($module)) ? Input::old('name') : $module->name, array('class' => 'span6', (isset($module) && !$module->is_author ? 'disabled' : '')))}}
                                        {{ $errors->first('name', '<span class="help-inline">:message</span>') }}
                                    </div>
                                </div>
                                <div class="control-group {{{ $errors->has('version') ? 'error' : '' }}}">
                                    <label class="control-label">Version <i class="red">*</i></label>
                                    <div class="controls">
                                        {{ Form::text('version', (!isset($module)) ? Input::old('version') : $module->version, array('class' => 'span6', (isset($module) && !$module->is_author ? 'disabled' : '')))}}
                                        {{ $errors->first('version', '<span class="help-inline">:message</span>') }}
                                    </div>
                                </div>
                                <div class="control-group {{{ $errors->has('author') ? 'error' : '' }}}">
                                    <label class="control-label">Author <i class="red">*</i></label>
                                    <div class="controls">
                                        {{ Form::text('author', (!isset($module)) ? Input::old('author') : $module->author, array('class' => 'span6', (isset($module) && !$module->is_author ? 'disabled' : '')))}}
                                        {{ $errors->first('author', '<span class="help-inline">:message</span>') }}
                                    </div>
                                </div>
                                <div class="control-group {{{ $errors->has('website') ? 'error' : '' }}}">
                                    <label class="control-label">Website Address</label>
                                    <div class="controls">
                                        {{ Form::text('website', (!isset($module)) ? Input::old('website') : $module->website, array('class' => 'span6', (isset($module) && !$module->is_author ? 'disabled' : '')))}}
                                        {{ $errors->first('website', '<span class="help-inline">:message</span>') }}
                                    </div>
                                </div>
                                <div class="control-group {{{ $errors->has('description') ? 'error' : '' }}}">
                                    <label class="control-label">Module Description</label>
                                    <div class="controls">
                                        {{ Form::textarea('description', (!isset($module)) ? Input::old('description') : $module->description, array('class' => 'span6', 'rows'=>2, (isset($module) && !$module->is_author ? 'disabled' : '')))}}
                                        {{ $errors->first('description', '<span class="help-inline">:message</span>') }}
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab2">
                                <h4>Select form(s)</h4>
                                <div class="control-group">
                                    <label class="control-label">Form(s) <i class="red">*</i></label>
                                    <div class="controls" id="InputsWrapper">
                                        @if (isset($selected_forms))
                                            <input name="form-count" type="hidden" value="{{ count($selected_forms) }}">
                                            @for ($i = 1; $i <= count($selected_forms); $i++)
                                                <p>

                                                    {{ Form::select("form-{$i}", BuiltForm::all_forms(), $selected_forms[$i-1], array('class'=>'chosen module-form')) }}
                                                    @if ($i == 1)
                                                        &nbsp;&nbsp;<a id="AddMore"><i class="icon-plus"></i></a>
                                                    @else
                                                        <a href="#" class="removeclass">&nbsp;&nbsp;<i class="icon-remove"></i></a>
                                                    @endif
                                                </p>
                                            @endfor
                                        @else
                                            <input name="form-count" type="hidden" value="1">
                                            <p>
                                                {{ Form::select("form-1", BuiltForm::all_forms(), Input::old('form-1'), array('class'=>'chosen module-form')) }}
                                                &nbsp;&nbsp;<a id="AddMore"><i class="icon-plus"></i></a>
                                            </p>
                                        @endif

                                        {{ HTML::link("$link_type/form-builder/create", "Create New Form", array('class'=>'pull-right btn btn-mini mb-15')) }}
                                    </div>
                                </div>

                                <div class="control-group {{{ $errors->has('target') ? 'error' : '' }}}">
                                    <label class="control-label">Target <i class="red">*</i></label>
                                    <div class="controls line">
                                        {{ Form::select('target[]', Menu::all_targets(), (!isset($module)) ? Input::old('target') : $module->selected_targets(), array('class'=>'chosen span6 m-wrap', 'style'=>'width:285px', 'multiple', 'data-placeholder'=>'Select target')) }}
                                        {{ $errors->first('target', '<span class="help-inline">:message</span>') }}
                                    </div>
                                </div>

                                <div class="control-group hide" id="form-dropdowns">
                                    <label class="control-label">Source for form dropdowns</label>
                                    {{ Form::select('', $select, '', array('id'=>'dropdown-options', 'class'=>'hide')) }}
                                </div>
                            </div>
                            <div class="tab-pane" id="tab3">
                                <h4>Confirm options</h4>
                                <div class="control-group">
                                    <label class="control-label">Module Name:</label>
                                    <div class="controls">
                                        <span class="text" id="name"></span>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Module Version:</label>
                                    <div class="controls">
                                        <span class="text" id="version"></span>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Module Author:</label>
                                    <div class="controls">
                                        <span class="text" id="author"></span>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Module Website:</label>
                                    <div class="controls">
                                        <span class="text" id="website"></span>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Module Description:</label>
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
                            {{ Form::submit('Submit', array('class'=>'btn btn-success button-submit')) }}
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
@stop

@section('scripts')
    @include('backend.default.module_builders.scripts')
@stop
