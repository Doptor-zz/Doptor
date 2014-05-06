@section('styles')
    <link rel="stylesheet" href="{{ URL::to('assets/backend/default/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}" />
@stop

@section('content')
    <div class="row-fluid">
        <div class="span12">
            <!-- BEGIN FORM PORTLET-->
            <div class="widget light-gray box">
                <div class="blue widget-title">
                    <h4><i class="icon-reorder"></i>Website Configuration</h4>
                </div>
                <div class="widget-body form">
                    <!-- BEGIN FORM-->
                    {{ Form::open(array('route' => 'config', 'method'=>'POST', 'class'=>'form-horizontal')) }}

                        <div class="control-group">
                            <label class="control-label">Website Name</label>
                            <div class="controls">
                                {{ Form::text('website_name', Setting::value('website_name'), array('class' => 'input-large')) }}
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Footer Text</label>
                            <div class="controls">
                                {{ Form::text('footer_text', Setting::value('footer_text'), array('class' => 'input-large')) }}
                            </div>
                        </div>

                        <div class="control-group {{{ $errors->has('public_offline') ? 'error' : '' }}}">
                            <label class="control-label">Set Public Offline?</label>
                            <div class="controls line">
                                {{ Form::select('public_offline', array('no'=>'No', 'yes'=>'Yes'), Setting::value('public_offline')) }}
                                {{ $errors->first('public_offline', '<span class="help-inline">:message</span>') }}
                            </div>
                        </div>

                        <div class="control-group {{{ $errors->has('public_offline_end') ? 'error' : '' }}}">
                            <label class="control-label">Set Public Offline Till</label>
                            <div class="controls line">
                                <div id="public_offline_end" class="input-append">
                                    {{ Form::text('public_offline_end', Setting::value('public_offline_end'), array('style'=>'width:180px;', 'data-format'=>'yyyy-MM-dd hh:mm:ss')) }}
                                    <span class="add-on">
                                        <i data-time-icon="icon-time" data-date-icon="icon-calendar">
                                        </i>
                                    </span>
                                </div>
                                <span class="help-inline">Leave blank to set offline until specified otherwise.</span>
                                {{ $errors->first('public_offline_end', '<span class="help-inline">:message</span>') }}
                            </div>
                        </div>

                        <div class="control-group {{{ $errors->has('admin_offline') ? 'error' : '' }}}">
                            <label class="control-label">Set Admin Offline?</label>
                            <div class="controls line">
                                {{ Form::select('admin_offline', array('no'=>'No', 'yes'=>'Yes'), Setting::value('admin_offline')) }}
                                {{ $errors->first('admin_offline', '<span class="help-inline">:message</span>') }}
                            </div>
                        </div>

                        <div class="control-group {{{ $errors->has('admin_offline_end') ? 'error' : '' }}}">
                            <label class="control-label">Set Admin Offline Till</label>
                            <div class="controls line">
                                <div id="admin_offline_end" class="input-append">
                                    {{ Form::text('admin_offline_end', Setting::value('admin_offline_end'), array('style'=>'width:180px;', 'data-format'=>'yyyy-MM-dd hh:mm:ss')) }}
                                    <span class="add-on">
                                        <i data-time-icon="icon-time" data-date-icon="icon-calendar">
                                        </i>
                                    </span>
                                </div>
                                <span class="help-inline">Leave blank to set offline until specified otherwise.</span>
                                {{ $errors->first('admin_offline_end', '<span class="help-inline">:message</span>') }}
                            </div>
                        </div>

                        <div class="control-group {{{ $errors->has('backend_offline') ? 'error' : '' }}}">
                            <label class="control-label">Set Backend Offline?</label>
                            <div class="controls line">
                                {{ Form::select('backend_offline', array('no'=>'No', 'yes'=>'Yes'), Setting::value('backend_offline')) }}
                                {{ $errors->first('backend_offline', '<span class="help-inline">:message</span>') }}
                            </div>
                        </div>

                        <div class="control-group {{{ $errors->has('backend_offline_end') ? 'error' : '' }}}">
                            <label class="control-label">Set Backend Offline Till</label>
                            <div class="controls line">
                                <div id="backend_offline_end" class="input-append">
                                    {{ Form::text('backend_offline_end', Setting::value('backend_offline_end'), array('style'=>'width:180px;', 'data-format'=>'yyyy-MM-dd hh:mm:ss')) }}
                                    <span class="add-on">
                                        <i data-time-icon="icon-time" data-date-icon="icon-calendar">
                                        </i>
                                    </span>
                                </div>
                                <span class="help-inline">Leave blank to set offline until specified otherwise.</span>
                                {{ $errors->first('backend_offline_end', '<span class="help-inline">:message</span>') }}
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Offline Message</label>
                            <div class="controls">
                                {{ Form::textarea('offline_message', Setting::value('offline_message'), array('rows'=>2, 'class' => 'input-large')) }}
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Backend Theme</label>
                            <div class="controls">
                                {{ Form::select('backend_theme', Theme::themeLists('backend'), Setting::value('backend_theme')) }}
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Admin Theme</label>
                            <div class="controls">
                                {{ Form::select('admin_theme', Theme::themeLists('admin'), Setting::value('admin_theme')) }}
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Public Theme</label>
                            <div class="controls">
                                {{ Form::select('public_theme', Theme::themeLists('public'), Setting::value('public_theme')) }}
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Email Host</label>
                            <div class="controls">
                                {{ Form::text('email_host', Setting::value('email_host'), array('class' => 'input-large')) }}
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Email Port</label>
                            <div class="controls">
                                {{ Form::text('email_port', Setting::value('email_port'), array('class' => 'input-large')) }}
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Email Encryption</label>
                            <div class="controls line">
                                {{ Form::select('email_encryption', array('false'=>'None', 'tls'=>'TLS', 'ssl'=>'SSL'), Setting::value('email_encryption')) }}
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Email Username</label>
                            <div class="controls">
                                {{ Form::text('email_username', Setting::value('email_username'), array('class' => 'input-large')) }}
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Email Password</label>
                            <div class="controls">
                                {{ Form::text('email_password', Setting::value('email_password'), array('class' => 'input-large')) }}
                            </div>
                        </div>

                        <div class="control-group hide">
                            <label class="control-label">mysqldump Path</label>
                            <div class="controls">
                                {{ Form::text('mysqldump_path', Setting::value('mysqldump_path'), array('class' => 'input-large')) }}
                                <div class="help-inline">Example: C:\wamp\bin\mysql\mysql5.6.12\bin\mysqldump.exe</div>
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    {{ Form::close() }}
                    <!-- END FORM-->
                </div>
            </div>
            <!-- END FORM PORTLET-->
        </div>
    </div>
@stop

@section('scripts')
    <script type="text/javascript" src="{{ URL::to("assets/backend/default/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js") }}"></script>
    @parent
    <script>
        jQuery(document).ready(function() {
            var nowTemp = new Date();
            var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), nowTemp.getHours(), nowTemp.getMinutes(), nowTemp.getSeconds(), nowTemp.getMilliseconds());

            $('#public_offline_end').datetimepicker({
                startDate: now,
                pick12HourFormat: false
            });
            $('#admin_offline_end').datetimepicker({
                startDate: now,
                pick12HourFormat: false
            });
            $('#backend_offline_end').datetimepicker({
                startDate: now,
                pick12HourFormat: false
            });
            $('#datetimepicker_end').datetimepicker({
                language: 'en',
                pick12HourFormat: false
            });
        });
    </script>
@stop
