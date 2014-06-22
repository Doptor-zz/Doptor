@section('styles')
    <!-- BEGIN PAGE LEVEL STYLES -->
    <link rel="stylesheet" href="{{ URL::to('assets/backend/plugins/data-tables/DT_bootstrap.css') }}" />
    <!-- END PAGE LEVEL STYLES -->
@stop

@section('content')
    <div class="row-fluid">
        <div class="span12">
            <!-- BEGIN EXAMPLE TABLE widget-->
            <div class="widget light-gray box">
                <div class="blue widget-title">
                    <h4>
                        <i class="icon-th-list"></i> All Entries
                        <div class="btn-group pull-right">
                            <div class="actions inline">
                                <div class="btn">
                                    <i class="icon-cog"> Actions</i>
                                </div>
                                <ul class="btn">
                                    <li>
                                        {{ Form::open(array('route' => array('admin.modules.'.$module_link.'.destroy', 'multiple'), 'method' => 'delete', 'class'=>'inline', 'onsubmit'=>"return deleteRecords($(this), 'entries');")) }}
                                            {{ Form::hidden('selected_ids', '', array('id'=>'selected_ids')) }}
                                            <button type="submit" class="danger"><i class="icon-trash"></i> Delete</button>
                                        {{ Form::close() }}
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="btn-group pull-right">
                            <button data-href="{{ URL::to('admin/modules/'.$module_link.'/create') }}" class="btn btn-success">
                                Add New <i class="icon-plus"></i>
                            </button>
                        </div>
                    </h4>
                </div>
                <div class="widget-body">
                    <table class="table table-striped table-hover table-bordered" id="sample_1">
                        <thead>
                            <tr>
                                <th class="span1"><input type="checkbox" class="select_all" /></th>
                                @foreach ($field_names as $field_name)
                                    <th>{{ Str::title($field_name) }}</th>
                                @endforeach
                                <th class="span3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($entries as $entry)
                                <tr>
                                    <td>{{ Form::checkbox($entry->id, 'checked', false) }}</td>
                                    @foreach ($fields as $field)
                                        <td>{{ $entry->{$field} }}</td>
                                    @endforeach
                                    <td>
                                        <a href="{{ URL::to('admin/modules/' . $module_link .'/' . $entry->id . '/edit') }}" class="btn btn-mini" title="Edit"><i class="icon-edit"></i></a>
                                        <a href="{{ URL::to('admin/modules/' . $module_link .'/' . $entry->id) }}" class="btn btn-mini" title="Show"><i class="icon-search"></i></a>

                                        <div class="actions inline">
                                            <div class="btn btn-mini">
                                                <i class="icon-cog"> Actions</i>
                                            </div>
                                            <ul class="btn btn-mini">
                                                <li>
                                                    {{ Form::open(array('route' => array('admin.modules.'.$module_link.'.destroy', $entry->id), 'method' => 'delete', 'class'=>'inline')) }}
                                                        <button type="submit" class="danger" onclick="return deleteRecord($(this))"><i class="icon-trash"></i> Delete</button>
                                                    {{ Form::close() }}
                                                </li>
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
    <script src="{{ url("assets/admin/default/js/jquery.dataTables.js") }}"></script>

    <script src="{{ url("assets/admin/default/js/dataTables.bootstrap.js") }}"></script>

    <script>
        $(function () {
            $('.table').dataTable({
                "sDom": "<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span6'i><'span6'p>>"
            });
        });
    </script>
    @parent
    <script>
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
    <!-- END PAGE LEVEL SCRIPTS -->
@stop
