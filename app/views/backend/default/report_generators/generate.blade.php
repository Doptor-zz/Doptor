@section('styles')
@stop

@section('content')
    <div class="row-fluid">
        <div class="span12">
            <!-- BEGIN EXAMPLE TABLE widget-->
            <div class="widget light-gray box">
                <div class="blue widget-title">
                    <h4><i class="icon-th-list"></i>{{ $generator->name }} Report Generator</h4>
                </div>
                <div class="widget-body form">
                    {{ Form::open(array('route'=>array($link_type . '.report-generators.generate',$generator->id), 'method'=>'POST', 'class'=>'form-horizontal', 'id'=>'report-generators')) }}

                        @if ($generator->show_calendars)
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
                        @endif

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

@section('scripts')
    {{ HTML::script("assets/backend/default/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js") }}
    @parent

    <script>
        jQuery(document).ready(function() {
            $('#datetimepicker_start').datetimepicker({
                language: 'en',
                pick12HourFormat: false
            });
            $('#datetimepicker_end').datetimepicker({
                language: 'en',
                pick12HourFormat: false
            });
        });
    </script>
@stop
