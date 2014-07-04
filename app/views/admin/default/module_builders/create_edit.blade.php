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
                        <i class="icon-reorder"></i> Form Wizard - <span class="step-title">Step 1 of 3</span>
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
                                        {{ Form::text('name', (!isset($module)) ? Input::old('name') : $module->name, array('class' => 'span6'))}}
                                        {{ $errors->first('name', '<span class="help-inline">:message</span>') }}
                                    </div>
                                </div>
                                <div class="control-group {{{ $errors->has('version') ? 'error' : '' }}}">
                                    <label class="control-label">Version <i class="red">*</i></label>
                                    <div class="controls">
                                        {{ Form::text('version', (!isset($module)) ? Input::old('version') : $module->version, array('class' => 'span6'))}}
                                        {{ $errors->first('version', '<span class="help-inline">:message</span>') }}
                                    </div>
                                </div>
                                <div class="control-group {{{ $errors->has('author') ? 'error' : '' }}}">
                                    <label class="control-label">Author <i class="red">*</i></label>
                                    <div class="controls">
                                        {{ Form::text('author', (!isset($module)) ? Input::old('author') : $module->author, array('class' => 'span6'))}}
                                        {{ $errors->first('author', '<span class="help-inline">:message</span>') }}
                                    </div>
                                </div>
                                <div class="control-group {{{ $errors->has('website') ? 'error' : '' }}}">
                                    <label class="control-label">Website Address</label>
                                    <div class="controls">
                                        {{ Form::text('website', (!isset($module)) ? Input::old('website') : $module->website, array('class' => 'span6'))}}
                                        {{ $errors->first('website', '<span class="help-inline">:message</span>') }}
                                    </div>
                                </div>
                                <div class="control-group {{{ $errors->has('description') ? 'error' : '' }}}">
                                    <label class="control-label">Module Description</label>
                                    <div class="controls">
                                        {{ Form::textarea('description', (!isset($module)) ? Input::old('description') : $module->description, array('class' => 'span6', 'rows'=>2))}}
                                        {{ $errors->first('description', '<span class="help-inline">:message</span>') }}
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab2">
                                <h4>Select form(s)</h4>
                                <div class="control-group">
                                    <label class="control-label">Form(s) <i class="red">*</i></label>
                                    <div class="controls" id="InputsWrapper">
                                        @if (isset($forms))
                                            {{-- expr --}}
                                            <input name="form-count" type="hidden" value="{{ count($forms) }}">
                                            @for ($i = 1; $i < count($forms); $i++)
                                                <p>

                                                    {{ Form::select("form-{$i}", BuiltForm::all_forms(), $forms[$i-1], array('class'=>'chosen')) }}
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
                                                {{ Form::select("form-1", BuiltForm::all_forms(), Input::old('form-1'), array('class'=>'chosen')) }}
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
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <script type="text/javascript" src="{{ URL::to('assets/backend/default/plugins/bootstrap-wizard/jquery.bootstrap.wizard.min.js') }}"></script>
    <script type="text/javascript" src="{{ URL::to('assets/backend/default/plugins/jquery-validation/dist/jquery.validate.min.js') }}"></script>
    <script type="text/javascript" src="{{ URL::to('assets/backend/default/plugins/jquery-validation/dist/additional-methods.min.js') }}"></script>
    <!-- END PAGE LEVEL PLUGINS -->
    @parent
    <script src="{{ URL::to('assets/backend/default/scripts/form-wizard.js') }}"></script>
    <script src="{{ URL::to('assets/backend/default/scripts/form-validation.js') }}"></script>
    <script>
        jQuery(document).ready(function () {
            FormWizard.init();

            $("#module-builder").validate({
                rules: {
                    name: {required: true, minlength: 3 },
                    version: {required: true },
                    author: {required: true, minlength: 3 },
                    website: {required: true, minlength: 3, url: true }
                }
            });

            $('#all_forms_chzn').css('width', '300px');
            $('.chzn-drop').css('width', '300px');
            $('#all_forms_chzn').find('input').css('width', '265px');

            // Populate the overview of the selections in the last step
            $('.button-next').click(function() {
                $('#name').html($('input[name=name]').val());
                $('#version').html($('input[name=version]').val());
                $('#author').html($('input[name=author]').val());
                $('#website').html($('input[name=website]').val());
                $('#description').html($('textarea[name=description]').val());
            });
        });

        $(document).ready(function() {
            // Things to do to dynamically add/remove as much forms as needed
            var InputsWrapper   = $("#InputsWrapper"); //Input boxes wrapper ID
            var AddButton       = $("#AddMore"); //Add button ID

            @if (!isset($module))
                var x = InputsWrapper.length; //initial text box count
                var FieldCount = 1; //to keep track of text box added
            @else
                var x = {{ count($forms) }};
                var FieldCount = {{ count($forms) }};
            @endif

            // on add input button click
            $(AddButton).click(function (e) {
                FieldCount++; //text box added increment
                //add input box
                $(InputsWrapper).append('<p>{{ Form::select("form-form_count", BuiltForm::all_forms(), Input::old("form-form_count"), array("class"=>"chosen")) }}<a href="#" class="removeclass">&nbsp;&nbsp;<i class="icon-remove"></i></a></p>');
                // Dynamically change the select name
                $('select[name="form-form_count"]').attr('name', function(){
                    return 'form-' + FieldCount;
                });
                // Don't show the form(s) already selected
                for (var i = 1; i <= FieldCount; i++) {
                    selected_value = $('select[name="form-' + i +'"]').val();
                    if (selected_value != 0) {
                        $('select[name="form-' + FieldCount +'"] option[value='+selected_value+']').remove();
                    }
                };
                $('input[name=form-count]').val(FieldCount);
                x++; //text box increment
                $(".chosen").chosen();
                return false;
            });

            $("body").on("click",".removeclass", function(e) { //user click on remove text
                if( x > 1 ) {
                    $(this).parent('p').remove(); //remove text box
                    x--; //decrement textbox
                }
                return false;
            });
        });
    </script>
@stop
