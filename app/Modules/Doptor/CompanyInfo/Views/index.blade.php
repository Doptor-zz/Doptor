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
                    <div class="row-fluid">
                        <div class="tabbable tabbable-custom">
                            <ul class="nav nav-tabs">
                                <li class="active">
                                    <a href="#tab_companies" data-toggle="tab">
                                        Companies
                                    </a>
                                </li>
                                <li>
                                    <a href="#tab_branches" data-toggle="tab">
                                        Company Branches
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab_companies">
                                    @include("{$module_alias}::companies._common.index_buttons")

                                    @include("{$module_alias}::companies._common.index_data")
                                </div>

                                <div class="tab-pane" id="tab_branches">
                                    @include("{$module_alias}::branches._common.index_buttons")

                                    @include("{$module_alias}::branches._common.index_data")
                                </div>
                            </div>
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
