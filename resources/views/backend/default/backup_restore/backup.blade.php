@section('content')
    <div class="row-fluid">
        <div class="span12">
            <!-- BEGIN FORM PORTLET-->
            <div class="widget light-gray box">
                <div class="blue widget-title">
                    <h4><i class="icon-reorder"></i>{!! trans('cms.backup') !!}</h4>
                </div>
                <div class="widget-body form">
                    {!! Form::open(['method'=>'POST']) !!}
                        <button type="submit" class="btn btn-primary" name="form_save">
                            {!! trans('cms.create_backup') !!}
                        </button>
                    {!! Form::close() !!}
                </div>
            </div>
            <!-- END FORM PORTLET-->
        </div>
    </div>
@stop
