@section('styles')
    {{ HTML::style('assets/backend/default/plugins/chosen-bootstrap/chosen/chosen.css') }}
    {{ HTML::style('assets/backend/default/plugins/chosen-bootstrap/chosen/chosen.css') }}
    {{ HTML::style('assets/backend/default/plugins/jquery-ui/jquery-ui.css') }}
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
                    {{ Form::open(array('route'=>$link_type . '.report-builder.store', 'method'=>'POST', 'class'=>'form-horizontal', 'id'=>'report-builder')) }}

                        <div class="control-group">
                            <label class="control-label">Title</label>
                            <div class="controls">
                                {{ Form::text('title', Input::old('title')) }}
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
                            <label class="control-label">Start date</label>
                            <div class="controls line">
                                <div id="datetimepicker_start" class="input-append">
                                    {{ Form::text('start_date', '', array('data-format'=>'yyyy-MM-dd HH:mm:ss')) }}
                                    <span class="add-on">
                                        <i data-time-icon="icon-time" data-date-icon="icon-calendar">
                                        </i>
                                    </span>
                                </div>
                                <span class="help-inline">Leave blank to get from oldest records.</span>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">End date</label>
                            <div class="controls line">
                                <div id="datetimepicker_end" class="input-append">
                                    {{ Form::text('end_date', (!isset($post)) ? '' : $post->publish_end, array('data-format'=>'yyyy-MM-dd HH:mm:ss')) }}
                                    <span class="add-on">
                                        <i data-time-icon="icon-time" data-date-icon="icon-calendar">
                                        </i>
                                    </span>
                                </div>
                                <span class="help-inline">Leave blank to get upto latest reports.</span>
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary" name="print-report"> Print Report</button>
                            <button type="submit" class="btn btn-primary" name="csv-report"> Generate CSV Report</button>
                            <button type="submit" class="btn btn-primary" name="pdf-report"> Generate PDF Report</button>
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

            $('#datetimepicker_start').datetimepicker({
                language: 'en',
                pick12HourFormat: false
            });
            $('#datetimepicker_end').datetimepicker({
                language: 'en',
                pick12HourFormat: false
            });
        });
        function get_fields () {
            url = '{{ URL::to("backend/report-builder/module-fields")}}/' + $('#module_name').val();
            $('#module_fields').html('<div class="controls line">Loading fields...</div>');
            $.ajax({
                type: "GET",
                url: url,
            })
            .done(function(fields) {
                html = '';
                for(field in fields) {
                    html += '<div class="controls line">';
                    html += '<label class="checkbox">';
                    html += '<input type="checkbox" value="'+fields[field]+'" name="fields.'+field+'" id="all-access" /> '+fields[field];
                    html += '</label>';
                    html += '</div>';
                }
                $('#module_fields').html(html);
                $('input[type=checkbox]').uniform();
            });
        }
    </script>
@stop
