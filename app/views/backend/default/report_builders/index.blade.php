@section('content')
    <div class="row-fluid">
        <div class="span12">
            <!-- BEGIN TABLE widget-->
            <div class="widget box light-grey">
                <div class="blue widget-title">
                    <h4><i class="icon-table"></i>All Report {{ trans('cms.builders') }}</h4>
                    <div class="tools">
                        <a href="javascript:;" class="collapse"></a>
                        <a href="#widget-config" data-toggle="modal" class="config"></a>
                        <a href="javascript:;" class="reload"></a>
                        <a href="javascript:;" class="remove"></a>
                    </div>
                </div>
                <div class="widget-body">
                    <div class="clearfix margin-bottom-10">
                        <div class="btn-group pull-right">
                            @if ($current_user->hasAccess('report-builder.create'))
                                <a href="{{ URL::to($link_type . '/report-builder/create') }}" class="btn btn-success">
                                    Add New <i class="icon-plus"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                    <table class="table table-striped table-hover table-bordered" id="sample_1">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Version</th>
                                <th>Author</th>
                                <th>Website</th>
                                <th>Download</th>
                                <th>Created At</th>
                                <!-- <th class="span2">Edit</th> -->
                                <th class="span2"></th>
                            </tr>
                        </thead>
                        <tbody id="menu-list">
                            @foreach ($report_builders as $report)
                                <tr class="">
                                    <td>{{ $report->name }}</td>
                                    <td>{{ $report->version }}</td>
                                    <td>{{ $report->author }}</td>
                                    <td>{{ $report->website }}</td>
                                    <th>{{ HTML::link(url($link_type . '/report-builder/download/'.$report->id), 'Download') }}</th>
                                    <td>{{ $report->created_at }}</td>
                                    <td>
                                        @if ($current_user->hasAccess('report-builder.edit'))
                                        <a href="{{ URL::to($link_type . '/report-builder/' . $report->id . '/edit') }}" class="btn btn-mini"><i class="icon-edit"></i></a>
                                        @endif

                                        @if ($current_user->hasAccess('report-builder.destroy'))
                                        <div class="actions inline">
                                            <div class="btn btn-mini">
                                                <i class="icon-cog"> Actions</i>
                                            </div>
                                            <ul class="btn btn-mini">
                                                <li>
                                                {{ Form::open(array('route' => array($link_type . '.report-builder.destroy', $report->id), 'method' => 'delete', 'class'=>'inline', 'onclick'=>"return deleteRecords($(this), 'module');")) }}
                                                    <button type="submit" class="danger delete"><i class="icon-trash"></i> Delete</button>
                                                {{ Form::close() }}
                                                </li>
                                            </ul>
                                        </div>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- END TABLE widget-->
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
        </script>
        <!-- END PAGE LEVEL SCRIPTS -->

        <script>
            @if (Session::has('download_file'))
                location.href = "{{ URL::to('backend/report-builder/download/' . Session::get('download_file')) }}";
            @endif
            $(function() {
                $('#selected_ids').val('');

                $('.select_all').change(function() {
                    var checkboxes = $('#sample_1 tbody').find(':checkbox');

                    if ($(this).is(':checked')) {
                        checkboxes.attr('checked', 'checked');
                        restore_uniformity();
                    } else {
                        checkboxes.removeAttr('checked');
                        restore_uniformity();
                    }
                });
            });
            function deleteRecords(th, type) {
                if (type === undefined) type = 'record';

                doDelete = confirm("Are you sure you want to delete the selected " + type + "s ?");
                if (!doDelete) {
                    // If cancel is selected, do nothing
                    return false;
                }

                $('#sample_1 tbody').find('input:checked').each(function() {
                    value = $('#selected_ids').val();
                    $('#selected_ids').val(value + ' ' + this.name);
                });
            }
            function restore_uniformity() {
                $.uniform.restore("input[type=checkbox]");
                $('input[type=checkbox]').uniform();
            }
        </script>
@stop
