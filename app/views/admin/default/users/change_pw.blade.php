@section('content')
    <div class="row-fluid">
        <div class="span12">
            <!-- BEGIN FORM widget-->
            <div class="widget light-gray box tabbable">
                <div class="blue widget-title">
                    <h4>
                        <i class="icon-user"></i>
                        <span class="hidden-480">Change User Password</span>
                    </h4>
                </div>

                <div class="widget-body widget-container form">
                    <div class="tabbable widget-tabs">
                        <div class="tab-content">
                            <div class="tab-pane active" id="widget_tab1">
                                <!-- BEGIN FORM-->
                                {{ Form::open(array('route' => $link_type.'.users.change-password', 'method'=>'PUT', 'class'=>'form-horizontal')) }}

                                    @if ($errors->has())
                                         <div class="alert alert-error hide" style="display: block;">
                                           <button data-dismiss="alert" class="close">×</button>
                                           You have some form errors. Please check below.
                                        </div>
                                    @endif
                                    <div class="control-group {{{ $errors->has('password') ? 'error' : '' }}}">
                                        <label class="control-label">Password {{ (!isset($user)) ? '<span class="red">*</span>' : '' }}</label>
                                        <div class="controls">
                                            {{ Form::password('password', array('class' => 'input-xlarge'))}}
                                            {{ $errors->first('password', '<span class="help-inline">:message</span>') }}
                                        </div>
                                    </div>
                                    <div class="control-group {{{ $errors->has('password_confirmation') ? 'error' : '' }}}">
                                        <label class="control-label">Confirm Password {{ (!isset($user)) ? '<span class="red">*</span>' : '' }}</label>
                                        <div class="controls">
                                            {{ Form::password('password_confirmation', array('class' => 'input-xlarge'))}}
                                            {{ $errors->first('password_confirmation', '<span class="help-inline">:message</span>') }}
                                        </div>
                                    </div>

                                    <br>
                                    <div class="form-actions">
                                        <button type="submit" class="btn btn-primary"><i class="icon-ok"></i> Save</button>
                                    </div>
                                {{ Form::close() }}
                                <!-- END FORM-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END FORM widget-->
        </div>
    </div>
@stop
