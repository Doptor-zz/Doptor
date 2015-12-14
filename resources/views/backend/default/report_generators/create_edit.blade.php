@section('styles')
@stop

@section('content')
    <div class="row-fluid">
        <div class="span12">
            <!-- BEGIN EXAMPLE TABLE widget-->
            <div class="widget light-gray box">
                <div class="blue widget-title">
                    <h4><i class="icon-th-list"></i> {!! trans('options.install_new') !!} {!! trans('cms.report_generator') !!}</h4>
                </div>
                <div class="widget-body form">
                    {!! Form::open(array('route'=>$link_type . '.report-generators.store', 'method'=>'POST', 'class'=>'form-horizontal', 'files'=>true, 'id'=>'report-generator')) !!}

                        @if ($errors->has())
                             <div class="alert alert-error hide" style="display: block;">
                               <button data-dismiss="alert" class="close">×</button>
                               {!! trans('errors.form_errors') !!}
                            </div>
                        @endif

                        <div class="control-group">
                           <label class="control-label">{!! trans('form_messages.select_report_generator') !!}</label>
                           <div class="controls">
                              <input type="file" class="default" name="file" />
                           </div>
                        </div>

                        <div class="control-group">
                           <label class="control-label">{!! trans('form_messages.replace_existing') !!}</label>
                           <div class="controls">
                                {!! Form::hidden('replace_existing', false) !!}
                                {!! Form::checkbox('replace_existing', true, Input::old('replace_existing', true)) !!}
                           </div>
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary"><i class="icon-ok"></i> {!! trans('options.install_new') !!}</button>
                        </div>

                    {!! Form::close() !!}
                </div>
            </div>
            <!-- END EXAMPLE TABLE widget-->
        </div>
    </div>
@stop

@section('scripts')
@stop
