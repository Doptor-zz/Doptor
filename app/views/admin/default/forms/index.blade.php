@section('content')
    <div class="row-fluid">
        <div class="span12">
            <!-- BEGIN EXAMPLE TABLE widget-->
            <div class="widget light-gray box">
                <div class="blue widget-title">
                    <h4><i class="icon-th-list"></i> All Form Entries</h4>
                </div>
                <div class="widget-body">
                    <div class="clearfix margin-bottom-10">
                        <div class="btn-group pull-right">
                            <div class="actions inline">
                                <div class="btn">
                                    <i class="icon-cog"> Actions</i>
                                </div>
                                <ul class="btn">
                                    @if ($current_user->hasAccess("form.destroy"))
                                    <li>
                                        {{ Form::open(array('route' => array($link_type . '.form.destroy', 'multiple'), 'method' => 'delete', 'class'=>'inline', 'onsubmit'=>"return deleteRecords($(this), 'forms');")) }}
                                            {{ Form::hidden('selected_ids', '', array('id'=>'selected_ids')) }}
                                            <button type="submit" class="danger delete"><i class="icon-trash"></i> Delete</button>
                                        {{ Form::close() }}
                                    </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                        @if ($current_user->hasAccess("form.create"))
                        <div class="btn-group pull-right">
                            <a href="{{ URL::to($link_type . '/form/' . $form_id) }}" class="btn btn-success">
                                Add New <i class="icon-plus"></i>
                            </a>
                        </div>
                        @endif
                    </div>
                    <table class="table table-striped table-hover table-bordered" id="sample_1">
                        <thead>
                            <tr>
                                <th class="span1"><input type="checkbox" class="select_all" /></th>
                                <th>Data</th>
                                <th class="span2"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($form_entries as $form_entry)
                                <tr>
                                    <td>{{ Form::checkbox($form_entry->id, 'checked', false) }}</td>
                                    <td>
                                        {{ $form_entry->data() }}
                                    </td>
                                    <td>
                                        <div class="actions inline">
                                            <div class="btn btn-mini">
                                                <i class="icon-cog"> Actions</i>
                                            </div>
                                            <ul class="btn btn-mini">
                                                @if ($current_user->hasAccess("form.destroy"))
                                                <li>
                                                    {{ Form::open(array('route' => array($link_type . '.form.destroy', $form_entry->id), 'method' => 'delete', 'class'=>'inline', 'onsubmit'=>"return deleteRecords($(this), 'forms');")) }}
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
    <script src="{{ url("assets/admin/default/js/jquery.dataTables.js") }}"></script>

    <script src="{{ url("assets/admin/default/js/dataTables.bootstrap.js") }}"></script>

    <script>
        $(function () {
            $('.table').dataTable({
                "sDom": "<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span6'i><'span6'p>>"
            });
        });
    </script>
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
@stop
