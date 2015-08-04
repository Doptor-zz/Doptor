@section('content')
    <div class="row-fluid">
        <div class="span12">
            <!-- BEGIN TABLE widget-->
            <div class="widget box light-grey">
                <div class="blue widget-title">
                    <h4><i class="icon-table"></i> {!! $title !!}</h4>
                </div>

                @include("{$module_alias}::branches._common.show")
            </div>
            <!-- END TABLE widget-->
        </div>
    </div>
@stop
