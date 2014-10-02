@section('content')
    <div class="row-fluid">
        <div class="span12">
            <!-- BEGIN FORM PORTLET-->
            <div class="widget light-gray box">
                <div class="blue widget-title">
                    <h4><i class="icon-reorder"></i>{{ trans('cms.synchronize') }} Local to Remote</h4>
                </div>
                <div class="widget-body form">
                    <h4>Enter your remote superadmin credentials to start synchronization</h4>
                    {{ Form::open(array('url' => 'admin/synchronize/localToWeb', 'method'=>'POST', 'class'=>'form-horizontal')) }}

                        <div class="control-group {{{ $errors->has('username') ? 'error' : '' }}}">
                            <label class="control-label">Username <span class="red">*</span></label>
                            <div class="controls">
                                {{ Form::text('username', Input::old('username'), array('class' => 'input-xlarge'))}}
                            </div>
                        </div>

                        <div class="control-group {{{ $errors->has('password') ? 'error' : '' }}}">
                            <label class="control-label">Password <span class="red">*</span></label>
                            <div class="controls">
                                {{ Form::password('password', array('class' => 'input-xlarge')) }}
                            </div>
                        </div>

                        <div class="control-group {{{ $errors->has('remote_url') ? 'error' : '' }}}">
                            <label class="control-label">Remote URL <span class="red">*</span></label>
                            <div class="controls">
                                {{ Form::text('remote_url', Input::old('remote_url'), array('class' => 'input-xlarge'))}}
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary"><i class="icon-ok"></i> Sync Local to Remote</button>
                        </div>

                    {{ Form::close() }}
                </div>
            </div>
            <!-- END FORM PORTLET-->
        </div>
    </div>
@stop
