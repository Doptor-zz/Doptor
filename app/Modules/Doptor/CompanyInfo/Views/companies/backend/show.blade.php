@section('content')
    <div class="row-fluid">
        <div class="span12">
            <!-- BEGIN TABLE widget-->
            <div class="widget box light-grey">
                <div class="widget-title">
                    <h4><i class="icon-table"></i> {!! $company->name !!}</h4>
                </div>

                @include("{$module_alias}::companies._common.show")
            </div>
            <!-- END TABLE widget-->
        </div>
    </div>
@stop
