@section('styles')
    <!-- BEGIN PAGE LEVEL STYLES -->
    {!! HTML::style('assets/backend/default/plugins/data-tables/DT_bootstrap.css') !!}
    <!-- END PAGE LEVEL STYLES -->
@stop

@section('content')
    <div class="row-fluid">
        <div class="span12">
            <!-- BEGIN EXAMPLE TABLE widget-->
            <div class="widget light-gray box">
                <div class="blue widget-title">
                    <h4><i class="icon-th-list"></i> {!! trans('cms.translations') !!}</h4>
                    <div class="tools">
                        <a href="javascript:;" class="collapse"></a>
                        <a href="#widget-config" data-toggle="modal" class="config"></a>
                        <a href="javascript:;" class="reload"></a>
                        <a href="javascript:;" class="remove"></a>
                    </div>
                </div>
                <div class="widget-body">
                    <table class="table table-striped table-hover table-bordered" id="sample_1">
                        <thead>
                            <tr>
                                <th>{!! trans('fields.group') !!}</th>
                                <th class="span2"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($groups as $group)
                                <tr>
                                    <td>{!! $group->group !!}</td>
                                    <td>
                                        {!! HTML::link(route('backend.modules.doptor.translation_manager.get_manage', [$language->id, $group->group]), trans('options.manage')) !!}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- END EXAMPLE TABLE widget-->
        </div>
    </div>
@stop

@section('scripts')
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        {!! HTML::script("assets/backend/default/plugins/data-tables/jquery.dataTables.js") !!}"
        {!! HTML::script("assets/backend/default/plugins/data-tables/DT_bootstrap.js") !!}
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        @parent
        {!! HTML::script("assets/backend/default/scripts/table-managed.js") !!}
        <script>
           jQuery(document).ready(function() {
              TableManaged.init();
           });
        </script>
        <!-- END PAGE LEVEL SCRIPTS -->
@stop
