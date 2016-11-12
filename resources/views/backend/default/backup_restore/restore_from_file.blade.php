@section('content')
    <div class="row-fluid">
        <div class="span12">
            <!-- BEGIN FORM PORTLET-->
            <div class="widget light-gray box">
                <div class="blue widget-title">
                    <h4><i class="icon-reorder"></i>{!! trans('cms.restore') !!}</h4>
                </div>
                <div class="widget-body form">
                    <div class="alert alert-warning">
                        <strong>Warning!</strong>
                        Restoring from backup will replace every data with the data from the backup file
                    </div>
                    {!! Form::open(['method'=>'POST', 'files'=>true]) !!}

                        <div class="control-group">
                            <label class="control-label">Select the backup file</label>
                            <div class="controls">
                                <input type="file" class="default" name="file" />
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary" name="form_save">
                            {!! trans('cms.restore_backup') !!}
                        </button>
                    {!! Form::close() !!}
                </div>
            </div>
            <!-- END FORM PORTLET-->
        </div>
    </div>
@stop
