@section('styles')
    @include("{$module_alias}::_common.index_styles")
@stop

@section('content')
    <div class="row-fluid">
        <div class="span12">
            <!-- BEGIN TABLE widget-->
            <div class="widget box blue">
                <div class="widget-title">
                    <h4><i class="icon-th-list"></i> {{ $title }}</h4>
                </div>
                <div class="widget-body">
                    <div class="row-fluid" id="main_tab">
                        @include("{$module_alias}::branches._common.index_buttons")

                        @include("{$module_alias}::branches._common.index_data")
                    </div>
                </div>
            </div>
            <!-- END TABLE widget-->
        </div>
    </div>
@stop

@section('scripts')
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    {!! HTML::script("assets/backend/default/plugins/data-tables/jquery.dataTables.js") !!}
    {!! HTML::script("assets/backend/default/plugins/data-tables/DT_bootstrap.js") !!}
    <!-- END PAGE LEVEL PLUGINS -->

    @include("{$module_alias}::_common.index_scripts")
@stop
