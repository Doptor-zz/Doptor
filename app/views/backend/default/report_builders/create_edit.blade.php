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
                    <h4><i class="icon-th-list"></i> Report Builder</h4>
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

                        <div class="control-group">
                            <label class="control-label">Module <i class="red">*</i></label>
                            <div class="controls">
                                {{ Form::select('module_id', Module::lists('name', 'id'), (isset($report_builder)) ? $report_builder->module_id : Input::old('module_id'), array('id'=>'module_id', 'class'=>'chosen', 'data-placeholder'=>'Select a module')) }}
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
        jQuery(document).ready(function() {
            get_fields();
            $('#module_id').on('change', function() {
                get_fields();
            });
        });

        function restore_uniformity() {
            $.uniform.restore("input[type=checkbox]");
            $('input[type=checkbox]').uniform();
        }

        function get_fields () {
            url = '{{ URL::to("backend/report-builder/module-fields")}}/' + $('#module_id').val();
            $('#module_fields').html('<div class="controls line">Loading fields...</div>');
            $.ajax({
                type: "GET",
                url: url,
            })
            .done(function(forms) {
                @if (isset($report_builder))
                    var selected_fields = {{ str_replace('\\', '', $report_builder->required_fields) }};
                @else
                    var selected_fields = {};
                @endif
                html = '';
                for (var i in forms) {
                    if (i == 0) {
                        status = 'checked';
                    } else {
                        status = '';
                    }
                    form = forms[i];
                    html += '<div class="controls line">';
                    html += '<label><b><input type="radio" name="model_name" value="'+form['model']+'" '+status+'>'+form['name']+'<b></label>';
                    for (var field in form['fields']) {
                        html += '<label class="checkbox">';
                        html += '<input type="checkbox" value="'+form['fields'][field]+'" name="fields.'+field+'" /> '+form['fields'][field];
                        html += '</label>';
                    }
                    html += '</div>';

                }
                $('#module_fields').html(html);
                for (var selected_field in selected_fields) {
                    $('[name="fields.'+selected_field+'"]').attr('checked', true);
                }
                // restore_uniformity();
            });
        }
    </script>
@stop
