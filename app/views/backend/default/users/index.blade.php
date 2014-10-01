@section('styles')
    <!-- BEGIN PAGE LEVEL STYLES -->
    <link rel="stylesheet" href="{{ URL::to('assets/backend/default/plugins/data-tables/DT_bootstrap.css') }}" />
    <!-- END PAGE LEVEL STYLES -->
@stop

@section('content')
    <div class="row-fluid">
        <div class="span12">
            <!-- BEGIN EXAMPLE TABLE widget-->
            <div class="widget light-gray box">
                <div class="blue widget-title">
                    <h4><i class="icon-th-list"></i>{{ trans('cms.all_users') }}</h4>
                </div>
                <div class="widget-body">
                    <div class="clearfix margin-bottom-10">
                        <div class="btn-group pull-right">
                            <div class="actions inline">
                                <div class="btn">
                                    <i class="icon-cog"> Actions</i>
                                </div>
                                <ul class="btn">
                                @if ($current_user->hasAccess("users.destroy"))
                                    <li>
                                        {{ Form::open(array('route' => array($link_type . '.users.destroy', 'multiple'), 'method' => 'delete', 'class'=>'inline', 'onsubmit'=>"return deleteRecords($(this), 'user');")) }}
                                            {{ Form::hidden('selected_ids', '', array('id'=>'selected_ids')) }}
                                            <button type="submit" class="danger delete"><i class="icon-trash"></i> Delete</button>
                                        {{ Form::close() }}
                                    </li>
                                @endif
                                </ul>
                            </div>
                        </div>
                        <div class="btn-group pull-right">
                            @if ($current_user->hasAccess('users.create'))
                                <button data-href="{{ URL::to($link_type . '/users/create') }}" class="btn btn-success">
                                    Add New <i class="icon-plus"></i>
                                </button>
                            @endif
                        </div>
                    </div>
                    <table class="table table-striped table-hover table-bordered" id="sample_1">
                        <thead>
                            <tr>
                                <th class="span1"><input type="checkbox" class="select_all" /></th>
                                <th>Username</th>
                                <th>Full Name</th>
                                <th>User Group</th>
                                <th>Status</th>
                                <th>Created At</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)

                                <tr class="">
                                    <td>{{ Form::checkbox($user->id, 'checked', false) }}</td>
                                    <td>{{ $user->username }}</td>
                                    <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                                    <td>{{ implode(', ', $user->user_groups) }}</td>
                                    <td>{{ $user->is_banned ? 'Inactive' : 'Active' }}</td>
                                    <td>{{ $user->created_at }}</td>
                                    <td>
                                        @if ($current_user->hasAccess('users.edit'))
                                        <a href="{{ URL::to($link_type . '/users/' . $user->id . '/edit') }}" class="btn btn-mini"><i class="icon-edit"></i></a>
                                        @endif

                                        <div class="actions inline">
                                            <div class="btn btn-mini">
                                                <i class="icon-cog"> Actions</i>
                                            </div>
                                            <ul class="btn btn-mini">
                                                @if ($current_user->hasAccess('users.activate'))
                                                <li>
                                                    @if (User::isBanned($user->id))
                                                    {{ Form::open(array('route' => array($link_type . '.users.activate', $user->id), 'method' => 'post', 'class'=>'inline')) }}
                                                        <button type="submit" class=""> Activate</button>
                                                    {{ Form::close() }}
                                                    @else
                                                    {{ Form::open(array('route' => array($link_type . '.users.deactivate', $user->id), 'method' => 'post', 'class'=>'inline')) }}
                                                        <button type="submit" class=""> Deactivate</button>
                                                    {{ Form::close() }}
                                                    @endif
                                                </li>
                                                <hr>
                                                @endif
                                                @if ($current_user->hasAccess("users.destroy"))
                                                <li>
                                                    {{ Form::open(array('route' => array($link_type . '.users.destroy', $user->id), 'method' => 'delete', 'class'=>'inline', 'onclick'=>"return deleteRecord($(this), 'user');")) }}
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
        </script>
        <!-- END PAGE LEVEL SCRIPTS -->
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
