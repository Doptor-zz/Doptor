@section('styles')
    {{ HTML::style('assets/backend/default/plugins/chosen-bootstrap/chosen/chosen.css') }}
    {{ HTML::style('assets/backend/default/plugins/jquery-ui/jquery-ui.css') }}
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
                    {{ Form::open(array('route'=>$link_type . '.report-builder.store', 'method'=>'POST', 'class'=>'form-horizontal', 'id'=>'report-builder')) }}

                        <div class="control-group">
                            <label class="control-label">Name</label>
                            <div class="controls">
                                {{ Form::text('name', Input::old('name')) }}
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Module <i class="red">*</i></label>
                            <div class="controls">
                                {{ Form::select('module_name', Module::lists('name', 'id'), Input::old('module_name'), array('id'=>'module_name', 'class'=>'chosen', 'data-placeholder'=>'Select a module')) }}
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
                                {{ Form::text('author', Input::old('author')) }}
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Version</label>
                            <div class="controls">
                                {{ Form::text('version', Input::old('version')) }}
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Website</label>
                            <div class="controls">
                                {{ Form::text('website', Input::old('website')) }}
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
            $('#module_name').on('change', function() {
                get_fields();
            });
        });
        function get_fields () {
            url = '{{ URL::to("backend/report-builder/module-fields")}}/' + $('#module_name').val();
            $('#module_fields').html('<div class="controls line">Loading fields...</div>');
            $.ajax({
                type: "GET",
                url: url,
            })
            .done(function(forms) {
                html = '';
                for (var i in forms) {
                    form = forms[i];
                    html += '<div class="controls line">';
                    html += '<label><b><input type="radio" name="model_name" value="'+form['model']+'">'+form['name']+'<b></label>';
                    for (var field in form['fields']) {
                        html += '<label class="checkbox">';
                        html += '<input type="checkbox" value="'+form['fields'][field]+'" name="fields.'+field+'" id="all-access" /> '+form['fields'][field];
                        html += '</label>';
                    }
                    html += '</div>';
                }
                $('#module_fields').html(html);
                $('input[type=checkbox]').uniform();
            });
        }
    </script>
@stop
