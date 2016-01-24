@section('styles')
    {!! HTML::style('assets/backend/default/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') !!}
    {!! HTML::style('assets/backend/default/plugins/bootstrap/css/bootstrap-modal.css') !!}
@stop

@section('content')
    <div class="row-fluid">
        <div class="span12">
            <!-- BEGIN FORM PORTLET-->
            <div class="widget light-gray box">
                <div class="blue widget-title">
                    <h4><i class="icon-reorder"></i>{!! trans('config.website_config') !!}</h4>
                </div>
                <div class="widget-body form">
                    <!-- BEGIN FORM-->
                    {!! Form::open(array('route' => 'config', 'method'=>'POST', 'class'=>'form-horizontal')) !!}

                        <fieldset>
                            <legend>{!! trans('config.basic_settings') !!}</legend>
                            <div class="control-group">
                                <label class="control-label">{!! trans('config.website_name') !!}</label>
                                <div class="controls">
                                    {!! Form::text('website_name', Setting::value('website_name'), array('class' => 'input-large')) !!}
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label">{!! trans('config.website_logo') !!}</label>
                                <div class="controls">
                                    {!! Form::hidden('website_logo') !!}
                                    <a class="btn btn-primary insert-media" id="insert-main-image" href="#">{!! trans('form_messages.select_image') !!}</a>
                                    <span class="file-name">
                                        {!! Setting::value('website_logo') !!}
                                    </span>
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label">{!! trans('config.footer_text') !!}</label>
                                <div class="controls">
                                    {!! Form::text('footer_text', Setting::value('footer_text'), array('class' => 'input-large')) !!}
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label">Language</label>
                                <div class="controls">
                                    {!! Form::select('language', $languages, Setting::value('language')) !!}
                                </div>
                            </div>

                        </fieldset>

                        <fieldset>
                            <legend>{!! trans('config.theme_settings') !!}</legend>
                            <div class="control-group">
                                <label class="control-label">{!! trans('config.backend_theme') !!}</label>
                                <div class="controls">
                                    {!! Form::select('backend_theme', Theme::themeLists('backend'), Setting::value('backend_theme')) !!}
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label">{!! trans('config.admin_theme') !!}</label>
                                <div class="controls">
                                    {!! Form::select('admin_theme', Theme::themeLists('admin'), Setting::value('admin_theme')) !!}
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label">{!! trans('config.public_theme') !!}</label>
                                <div class="controls">
                                    {!! Form::select('public_theme', Theme::themeLists('public'), Setting::value('public_theme')) !!}
                                </div>
                            </div>
                        </fieldset>

                        <fieldset>
                            <legend>{!! trans('config.security_settings') !!}</legend>
                            <div class="control-group">
                                <label class="control-label">{!! trans('config.auto_logout_time') !!}</label>
                                <div class="controls">
                                    {!! Form::text('auto_logout_time', Setting::value('auto_logout_time'), array('class' => 'input-large', 'pattern'=>'\d*')) !!}
                                    <span class="help-inline">{!! trans('config.time_in_min') !!}</span>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">{!! trans('config.ip_address_to_disable') !!}</label>
                                <div class="controls">
                                    {!! Form::text('disabled_ips', Setting::value('disabled_ips'), array('class' => 'input-large')) !!}
                                    <span class="help-inline">{!! trans('config.separate_address') !!}</span>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset>
                            <legend>{!! trans('config.company_details') !!}</legend>
                            <div class="control-group">
                                <label class="control-label">{!! trans('config.company_name') !!}</label>
                                <div class="controls">
                                    {!! Form::text('company_name', Setting::value('company_name'), array('class' => 'input-large')) !!}
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label">{!! trans('config.company_address') !!}</label>
                                <div class="controls">
                                    {!! Form::text('company_address', Setting::value('company_address'), array('class' => 'input-large')) !!}
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label">{!! trans('config.company_contact') !!}</label>
                                <div class="controls">
                                    {!! Form::text('company_contact', Setting::value('company_contact'), array('class' => 'input-large')) !!}
                                </div>
                            </div>
                        </fieldset>

                        <fieldset>
                            <legend>{!! trans('config.social_media_links') !!}</legend>
                            <div class="control-group">
                                <label class="control-label">{!! trans('config.facebook_link') !!}</label>
                                <div class="controls">
                                    {!! Form::text('facebook_link', Setting::value('facebook_link'), array('class' => 'input-large')) !!}
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label">{!! trans('config.twitter_link') !!}</label>
                                <div class="controls">
                                    {!! Form::text('twitter_link', Setting::value('twitter_link'), array('class' => 'input-large')) !!}
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label">{!! trans('config.google_plus_link') !!}</label>
                                <div class="controls">
                                    {!! Form::text('gplus_link', Setting::value('gplus_link'), array('class' => 'input-large')) !!}
                                </div>
                            </div>
                        </fieldset>

                        <fieldset>
                            <legend>{!! trans('config.offline_settings') !!}</legend>
                            <div class="control-group {!! $errors->has('public_offline') ? 'error' : '' !!}">
                                <label class="control-label">{!! trans('config.set_public_offline') !!}</label>
                                <div class="controls line">
                                    {!! Form::select('public_offline', array('no'=>'No', 'yes'=>'Yes'), Setting::value('public_offline')) !!}
                                    {!! $errors->first('public_offline', '<span class="help-inline">:message</span>') !!}
                                </div>
                            </div>

                            <div class="control-group {!! $errors->has('public_offline_end') ? 'error' : '' !!}">
                                <label class="control-label">{!! trans('config.set_public_offline_till') !!}</label>
                                <div class="controls line">
                                    <div id="public_offline_end" class="input-append">
                                        {!! Form::text('public_offline_end', Setting::value('public_offline_end'), array('style'=>'width:180px;', 'data-format'=>'yyyy-MM-dd hh:mm:ss')) !!}
                                        <span class="add-on">
                                            <i data-time-icon="icon-time" data-date-icon="icon-calendar">
                                            </i>
                                        </span>
                                    </div>
                                    <span class="help-inline">{!! trans('config.offline_leave_blank') !!}</span>
                                    {!! $errors->first('public_offline_end', '<span class="help-inline">:message</span>') !!}
                                </div>
                            </div>

                            <div class="control-group {!! $errors->has('admin_offline') ? 'error' : '' !!}">
                                <label class="control-label">{!! trans('config.set_admin_offline') !!}</label>
                                <div class="controls line">
                                    {!! Form::select('admin_offline', array('no'=>'No', 'yes'=>'Yes'), Setting::value('admin_offline')) !!}
                                    {!! $errors->first('admin_offline', '<span class="help-inline">:message</span>') !!}
                                </div>
                            </div>

                            <div class="control-group {!! $errors->has('admin_offline_end') ? 'error' : '' !!}">
                                <label class="control-label">{!! trans('config.set_admin_offline_till') !!}</label>
                                <div class="controls line">
                                    <div id="admin_offline_end" class="input-append">
                                        {!! Form::text('admin_offline_end', Setting::value('admin_offline_end'), array('style'=>'width:180px;', 'data-format'=>'yyyy-MM-dd hh:mm:ss')) !!}
                                        <span class="add-on">
                                            <i data-time-icon="icon-time" data-date-icon="icon-calendar">
                                            </i>
                                        </span>
                                    </div>
                                    <span class="help-inline">{!! trans('config.offline_leave_blank') !!}</span>
                                    {!! $errors->first('admin_offline_end', '<span class="help-inline">:message</span>') !!}
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label">{!! trans('config.offline_message') !!}</label>
                                <div class="controls">
                                    {!! Form::textarea('offline_message', Setting::value('offline_message'), array('rows'=>2, 'class' => 'input-large')) !!}
                                </div>
                            </div>
                        </fieldset>

                        <fieldset>
                            <legend>{!! trans('config.email_settings') !!}</legend>
                            <div class="control-group">
                                <label class="control-label">{!! trans('config.email_host') !!}</label>
                                <div class="controls">
                                    {!! Form::text('email_host', Setting::value('email_host'), array('class' => 'input-large')) !!}
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label">{!! trans('config.email_port') !!}</label>
                                <div class="controls">
                                    {!! Form::text('email_port', Setting::value('email_port'), array('class' => 'input-large', 'pattern'=>'\d*')) !!}
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label">{!! trans('config.email_encryption') !!}</label>
                                <div class="controls line">
                                    {!! Form::select('email_encryption', array('false'=>'None', 'tls'=>'TLS', 'ssl'=>'SSL'), Setting::value('email_encryption')) !!}
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label">{!! trans('config.email_username') !!}</label>
                                <div class="controls">
                                    {!! Form::text('email_username', Setting::value('email_username'), array('class' => 'input-large')) !!}
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label">{!! trans('config.email_password') !!}</label>
                                <div class="controls">
                                    <input type="password" name="email_password" value="{!!Setting::value('email_password')!!}" placeholder="{!! trans('fields.email') !!} {!! trans('fields.password') !!}" class="input-large">
                                </div>
                            </div>
                        </fieldset>

                        <div class="control-group hide">
                            <label class="control-label">MySQL dump path</label>
                            <div class="controls">
                                {!! Form::text('mysqldump_path', Setting::value('mysqldump_path'), array('class' => 'input-large')) !!}
                                <div class="help-inline">Example: C:\wamp\bin\mysql\mysql5.6.12\bin\mysqldump.exe</div>
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">{!! trans('options.save') !!}</button>
                        </div>
                    {!! Form::close() !!}
                    <!-- END FORM-->
                </div>
            </div>
            <!-- END FORM PORTLET-->
        </div>
    </div>
@stop

@section('scripts')
    {!! HTML::script('assets/backend/default/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') !!}
    {!! HTML::script('assets/backend/default/plugins/bootstrap/js/bootstrap-modalmanager.js') !!}
    {!! HTML::script("assets/backend/default/scripts/media-selection.js") !!}
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

        MediaSelection.init('website_logo');
    </script>
@stop
