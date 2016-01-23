@section('content')
    <div class="row-fluid">
        <div class="span12">
            <!-- BEGIN FORM widget-->
            <div class="widget box blue tabbable">
                <div class="blue widget-title">
                    <h4>
                        <i class="icon-user"></i>
                        @if (!isset($subscriber))
                            <span class="hidden-480">Add Subscriber</span>
                        @else
                            <span class="hidden-480">Edit Subscriber</span>
                        @endif
                        &nbsp;
                    </h4>
                </div>
                <div class="widget-body form">
                    <div class="tabbable widget-tabs">
                        <div class="tab-content">
                            <div class="tab-pane active" id="widget_tab1">
                                <!-- BEGIN FORM-->
                                @if (!isset($subscriber))
                                {!! Form::open(array('route'=>$link_type . '.modules.newsletters.subscribers.store', 'method'=>'POST', 'class'=>'form-horizontal')) !!}
                                @else
                                {!! Form::open(array('route'=>array($link_type . '.modules.newsletters.subscribers.update', $subscriber->id), 'method'=>'PUT', 'class'=>'form-horizontal')) !!}
                                @endif

                                    @if ($errors->has())
                                         <div class="alert alert-error hide" style="display: block;">
                                           <button data-dismiss="alert" class="close">×</button>
                                           {!! trans('errors.form_errors') !!}
                                        </div>
                                    @endif

                                    <div class="control-group {{ $errors->has('name') ? 'error' : '' }}">
                                        <label class="control-label">Name</label>
                                        <div class="controls">
                                            {!! Form::text('name', isset($subscriber) ? $subscriber->name : Input::old('name'), array('class' => 'input-xlarge'))!!}
                                            {!! $errors->first('name', '<span class="help-inline">:message</span>') !!}
                                        </div>
                                    </div>

                                    <div class="control-group {{ $errors->has('email') ? 'error' : '' }}">
                                        <label class="control-label">Email <span class="red">*</span></label>
                                        <div class="controls">
                                            {!! Form::text('email', isset($subscriber) ? $subscriber->email : Input::old('email'), array('required', 'class' => 'input-xlarge'))!!}
                                            {!! $errors->first('email', '<span class="help-inline">:message</span>') !!}
                                        </div>
                                    </div>

                                    <div class="form-actions">
                                        <button type="submit" class="btn btn-primary" name="form_save">Save</button>

                                        <button type="submit" class="btn btn-success" name="form_save_new">Save &amp; New</button>

                                        <button type="submit" class="btn btn-primary btn-danger" name="form_close">Close</button>
                                    </div>
                                {!! Form::close() !!}
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

@section('scripts')
    {!! HTML::script("assets/backend/default/plugins/ckeditor/ckeditor.js") !!}">

    @parent
@stop
