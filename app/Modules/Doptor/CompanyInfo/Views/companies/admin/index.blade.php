@section('styles')
    <!-- BEGIN PAGE LEVEL STYLES -->
    <!-- END PAGE LEVEL STYLES -->
@stop

@section('content')
    <div class="row-fluid">
        <div class="span12">
            <!-- BEGIN EXAMPLE TABLE widget-->
            <div class="widget light-gray box">
                <div class="blue widget-title">
                    <h4>
                        <i class="icon-th-list"></i> {{ $title }}
                    </h4>
                </div>
                <div class="widget-body">
                    <div class="row-fluid">
                        @if ($tabbed_view)
                            @include("{$module_alias}::_common.index_tabbed")
                        @else
                            <div id="main_tab">
                                @include("{$module_alias}::companies._common.index_buttons")

                                @include("{$module_alias}::companies._common.index_data")
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <!-- END EXAMPLE TABLE widget-->
        </div>
    </div>
@stop

@section('scripts')
    {!! HTML::script("assets/admin/default/js/jquery.dataTables.js") !!}

    {!! HTML::script("assets/admin/default/js/dataTables.bootstrap.js") !!}

    <script>
        $(function () {
            $('.table').dataTable({
                "sDom": "<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span6'i><'span6'p>>"
            });
        });
    </script>
    @parent

    @include("{$module_alias}::_common.index_scripts")
@stop
