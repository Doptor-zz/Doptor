@section('styles')
    {{ HTML::style('assets/backend/default/plugins/chosen-bootstrap/chosen/chosen.css') }}
    {{ HTML::style('assets/backend/default/plugins/jquery-ui/jquery-ui.css') }}
    <style>
        .radio, .checkbox {
            padding-left: 20px !important;
        }
    </style>
@stop

@section('content')
    <div class="row-fluid">
        <div class="span12">
            <!-- BEGIN EXAMPLE TABLE widget-->
            <div class="widget light-gray box">
                <div class="blue widget-title">
                    <h4><i class="icon-th-list"></i> {{ trans('cms.report_builder') }}</h4>
                </div>
                <div class="widget-body form">
                    @if (!isset($report_builder))
                    {{ Form::open(array('route'=>$link_type . '.report-builder.store', 'method'=>'POST', 'class'=>'form-horizontal', 'id'=>'report-builder')) }}
                    @else
                    {{ Form::open(array('route' => array($link_type . '.report-builder.update', $report_builder->id), 'method'=>'PUT', 'class'=>'form-horizontal')) }}
                    @endif

                        <div class="control-group">
                            <label class="control-label">Name</label>
                            <div class="controls">
                                {{ Form::text('name', (isset($report_builder)) ? $report_builder->name : Input::old('name')) }}
                            </div>
                        </div>

                        {{ Form::hidden('count-value', 1) }}
                        <div class="control-group">
                            <label class="control-label">Module <i class="red">*</i></label>
                            <div class="controls">
                                @if (!isset($report_builder))
                                    <div class="selected-module">
                                        {{ Form::select('module_id[]', Module::lists('name', 'id'), Input::old('module_id'), array('class'=>'module_id chosen', 'data-placeholder'=>'Select a module')) }}
                                        <a href="#" class="removeclass hide">&nbsp;&nbsp;<i class="icon-remove"></i></a>
                                    </div>
                                @else
                                    @foreach ($module_ids as $i => $module_id)
                                        <div class="selected-module">
                                            {{ Form::select('module_id[]', Module::lists('name', 'id'), $module_id, array('class'=>'module_id chosen', 'data-placeholder'=>'Select a module')) }}
                                            <a href="#" class="removeclass hide">&nbsp;&nbsp;<i class="icon-remove"></i></a>
                                        </div>
                                    @endforeach
                                @endif
                                <a id="add-more"><i class="icon-plus"></i></a>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Fields to display in report <i class="red">*</i></label>

                            <div id="module_fields">
                                <div class="controls line">

                                </div>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Author</label>
                            <div class="controls">
                                {{ Form::text('author', (isset($report_builder)) ? $report_builder->author : Input::old('author')) }}
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Version</label>
                            <div class="controls">
                                {{ Form::text('version', (isset($report_builder)) ? $report_builder->version : Input::old('version')) }}
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Website</label>
                            <div class="controls">
                                {{ Form::text('website', (isset($report_builder)) ? $report_builder->website : Input::old('website')) }}
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Show calendars</label>
                            <div class="controls line">
                                {{ Form::checkbox('show_calendars', 'checked', (isset($report_builder)) ? $report_builder->show_calendars : true) }}
                                {{ $errors->first('show_calendars', '<span class="help-inline">:message</span>') }}
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary" name="print-report"> Build Report</button>
                        </div>

                    {{ Form::close() }}
                </div>
            </div>
            <!-- END EXAMPLE TABLE widget-->
        </div>
    </div>
@stop

@section('scripts')
    {{ HTML::script("assets/backend/default/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js") }}
    {{ HTML::script('assets/backend/default/plugins/chosen-bootstrap/chosen/chosen.jquery.min.js') }}

    @parent

    <script>
        var count = 1;
        jQuery(document).ready(function() {
            $('.module_id').each(function() {
                get_fields($(this));
            });
            $(document).on('change', '.module_id', function(e) {
                get_fields($(this));
            });

            $('#add-more').on('click', function(e) {
                add_more($(this));
            });
            $(document).on('click','.removeclass', function(e) {
                remove_id = $(this).parent('.selected-module').find('select').val();
                $('#module_fields').find('[data-module_id='+remove_id+']').remove();
                $(this).parent('.selected-module').remove(); //remove text box
                return false;
            });
        });

        function restore_uniformity() {
            $.uniform.restore("input[type=checkbox]");
            $('input[type=checkbox]').uniform();
        }

        function get_fields(that) {
            module_id = that.val();
            console.log(module_id);
            url = '{{ URL::to("backend/report-builder/module-fields")}}/' + module_id;
            $('#module_fields').append('<div class="controls line loading">Loading fields...</div>');
            $.ajax({
                type: "GET",
                url: url,
            })
            .done(function(forms) {
                @if (isset($report_builder))
                    var selected_fields = {{ $required_fields }};
                @else
                    var selected_fields = {};
                @endif
                html = '';
                for (var i in forms) {
                    form = forms[i];
                    html += '<div class="controls line" data-module_id="'+module_id+'">';
                    html += '<label><b>Module: <input type="hidden" name="module_id-'+count+'" value="'+module_id+'">'+that.find(':selected').text()+'</b></label>';
                    html += '<label><b>';
                    html += '<input type="checkbox" class="hide" name="model_name-'+count+'" value="'+form['model']+'" checked>';
                    html += '<input type="checkbox" class="hide" name="form_name-'+count+'" value="'+form['name']+'" checked>';
                    html += 'Form: '+form['name'];
                    html += '</b></label>';
                    html += '<div class="form-fields">Fields: ';
                    for (var field in form['fields']) {
                        html += '<label class="checkbox inline">';
                        html += '<input type="checkbox" value="'+form['fields'][field]+'" name="fields-'+count+'.'+field+'" /> '+form['fields'][field];
                        html += '</label>';
                    }
                    html += '</div>';
                    html += '</div>';
                    $('[name=count-value]').val(count);
                    count += 1;
                }

                $('#module_fields').find('.loading').remove();
                $('#module_fields').append(html);

                // Display the form fields of only the modules that are selected
                module_fields = '';
                $('.module_id').each(function() {
                    id = $(this).val();
                    $('#module_fields').find('[data-module_id='+id+']').each(function() {
                        module_fields += $(this)[0].outerHTML;
                    });
                });
                $('#module_fields').html(module_fields);

                // Preselect the fields in case of editing
                for (var i in forms) {
                    for (var j = 0; j < selected_fields.length; j++) {
                        selected_field = selected_fields[j];
                        for (var field in selected_field) {
                            for (var x = 1; x <= count; x++) {
                                $('[name="fields-'+x+'.'+field+'"]').attr('checked', true);
                            };
                        }
                    }
                }
                // restore_uniformity();
            });
        }

        function add_more(that) {
            $('.chosen').removeAttr('id').removeAttr('style').removeClass('chzn-done');
            $('.chzn-container').remove();
            select_html = that.parent().find('.selected-module :first').clone();
            select_html.find('select').parent().appendTo(that.parent());
            select_html.find('a').removeClass('hide');

            // Don't show the module(s) already selected
            $('.module_id :not(:last)').each(function() {
                var value = $(this).val();
                $('.module_id :last').find('option[value='+value+']').remove();
            });

            get_fields($('.module_id :last'));
            $('.chosen').chosen();
        }
    </script>
@stop
