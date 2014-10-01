@section('content')
    <div class="row-fluid">
        <div class="span12">
            <!-- BEGIN EXAMPLE TABLE widget-->
            <div class="widget light-gray box">
                <div class="blue widget-title">
                    <h4><i class="icon-th-list"></i>Frontend {{ trans('cms.menu_manager') }}</h4>
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
                            <div class="actions inline">
                                <div class="btn">
                                    <i class="icon-cog"> Actions</i>
                                </div>
                                <ul class="btn">
                                    @if ($current_user->hasAccess("menu-manager.destroy"))
                                    <li>
                                        {{ Form::open(array('route' => array($link_type . '.menu-manager.destroy', 'multiple'), 'method' => 'delete', 'class'=>'inline', 'onsubmit'=>"return deleteRecords($(this), 'menu entrie');")) }}
                                            {{ Form::hidden('selected_ids', '', array('id'=>'selected_ids')) }}
                                            <button type="submit" class="danger delete"><i class="icon-trash"></i> Delete</button>
                                        {{ Form::close() }}
                                    </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                        <div class="btn-group pull-right">
                            @if ($current_user->hasAccess('menu-manager.create'))
                                <button data-href="{{ URL::to($link_type . '/menu-manager/create') }}" class="btn btn-success">
                                    Add New <i class="icon-plus"></i>
                                </button>
                            @endif
                        </div>
                    </div>
                    <table class="table table-striped table-hover table-bordered" id="sample_1">
                        <thead>
                            <tr>
                                <th class="span1"><input type="checkbox" class="select_all" /></th>
                                <th>Position</th>
                                <th>Parent Menu</th>
                                <th>Title</th>
                                <th>Link</th>
                                <th>Status</th>
                                <th class="span1">Order</th>
                                <th class="span2"></th>
                                <th class="hide"></th>
                            </tr>
                        </thead>
                        <tbody id="menu-list">
                            @foreach ($menu_entries as $menu)
                                <tr class="">
                                    <td>{{ Form::checkbox($menu->id, 'checked', false) }}</td>
                                    <td>{{ $menu->pos->name }}</td>
                                    <td>{{ Menu::menu_name($menu->parent) }}</td>
                                    <td class="menu-title">{{ $menu->title }}</td>
                                    <td>{{ $menu->link_name() }}</td>
                                    <td>{{ $menu->status() }}</td>
                                    <td>{{ $menu->order }}</td>
                                    <td>
                                        @if ($current_user->hasAccess('menu-manager.edit'))
                                        <a href="{{ URL::to($link_type . '/menu-manager/' . $menu->id . '/edit') }}" class="btn btn-mini" title="Edit"><i class="icon-edit"></i></a>
                                        @endif

                                        <div class="actions inline">
                                            <div class="btn btn-mini">
                                                <i class="icon-cog"> Actions</i>
                                            </div>
                                            <ul class="btn btn-mini">
                                                @if ($current_user->hasAccess('menu-manager.destroy'))
                                                <li>
                                                    {{ Form::open(array('route' => array($link_type . '.menu-manager.destroy', $menu->id), 'method' => 'delete', 'class'=>'inline', 'onsubmit'=>'return deleteRecords($(this), "menu");')) }}
                                                        <button type="submit" class="danger delete"><i class="icon-trash"></i> Delete</button>
                                                    {{ Form::close() }}
                                                </li>
                                                @endif
                                            </ul>
                                        </div>

                                    </td>
                                    <td class="element-row-id hide">{{ $menu->id }}</td>
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
