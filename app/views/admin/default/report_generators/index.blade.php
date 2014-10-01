@section('content')
    <div class="row-fluid">
        <div class="span12">
            <!-- BEGIN EXAMPLE TABLE widget-->
            <div class="widget light-gray box">
                <div class="blue widget-title">
                    <h4>
                        <i class="icon-th-list"></i>All {{ trans('cms.report_generators') }}
                        @if ($link_type == 'admin')
                            @if ($current_user->hasAccess('report-generators.create'))
                                <div class="btn-group pull-right">
                                    <a href="{{ URL::to($link_type . '/report-generators/create') }}" class="btn btn-success">
                                        Install New Report Generator <i class="icon-plus"></i>
                                    </a>
                                </div>
                            @endif
                        @endif
                    </h4>
                    <div class="tools">
                        <a href="javascript:;" class="collapse"></a>
                        <a href="#widget-config" data-toggle="modal" class="config"></a>
                        <a href="javascript:;" class="reload"></a>
                        <a href="javascript:;" class="remove"></a>
                    </div>
                </div>
                <div class="widget-body">
                    @if ($link_type != 'admin')
                        <div class="clearfix margin-bottom-10">
                            <div class="btn-group pull-right">
                                @if ($current_user->hasAccess('report-generators.create'))
                                    <button data-href="{{ URL::to($link_type . '/report-generators/install') }}" class="btn btn-success">
                                        Install New Module <i class="icon-plus"></i>
                                    </button>
                                @endif
                            </div>
                        </div>
                    @endif
                    <table class="table table-striped table-hover table-bordered" id="sample_1">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>For Module Name</th>
                                <th>Version</th>
                                <th>Author</th>
                                <th>Website</th>
                                <th class="span3">Installed At</th>
                                <!-- <th class="span2">Edit</th> -->
                                <th class="span2"></th>
                            </tr>
                        </thead>
                        <tbody id="menu-list">
                            @foreach ($report_generators as $generator)
                                <tr class="">
                                    <td>{{ $generator->name }}</td>
                                    <td>{{ $generator->module_name }}</td>
                                    <td>{{ $generator->version }}</td>
                                    <td>{{ $generator->author }}</td>
                                    <td>{{ $generator->website }}</td>
                                    <td>{{ $generator->created_at }}</td>
                                    <td>
                                        <div class="actions inline">
                                            <div class="btn btn-mini">
                                                <i class="icon-cog"> Actions</i>
                                            </div>
                                            <ul class="btn btn-mini">
                                                @if ($current_user->hasAccess('report-generators.destroy'))
                                                <li>
                                                    {{ Form::open(array('route' => array($link_type . '.report-generators.destroy', $generator->id), 'method' => 'delete', 'class'=>'inline', 'onclick'=>"return deleteRecord($(this), 'report generator');")) }}
                                                        <button type="submit" class="danger delete"><i class="icon-trash"></i> Delete</button>
                                                    {{ Form::close() }}
                                                </li>
                                                @endif
                                            </ul>
                                        </div>
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
        <script type="text/javascript" src="{{ URL::to("assets/backend/default/plugins/data-tables/jquery.dataTables.js") }}"></script>
        <script type="text/javascript" src="{{ URL::to("assets/backend/default/plugins/data-tables/DT_bootstrap.js") }}"></script>
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        @parent
        <script src="{{ URL::to("assets/backend/default/scripts/table-managed.js") }}"></script>
        <script>
            jQuery(document).ready(function() {
               TableManaged.init();
            });
            @if (Session::has('download_file'))
                location.href = "{{ URL::to('backend/report-builder/download/' . Session::get('download_file')) }}";
            @endif
        </script>
        <!-- END PAGE LEVEL SCRIPTS -->
@stop
