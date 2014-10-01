@section('content')
    <div class="row-fluid">
        <div class="span12">
            <!-- BEGIN EXAMPLE TABLE widget-->
            <div class="widget light-gray box">
                <div class="blue widget-title">
                    <h4><i class="icon-th-list"></i>{{ trans('cms.all_user_groups') }}</h4>
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
                            @if ($current_user->hasAccess('user-groups.create'))
                                <button data-href="{{ URL::to($link_type . '/user-groups/create') }}" class="btn btn-success">
                                    Add New <i class="icon-plus"></i>
                                </button>
                            @endif
                        </div>
                    </div>
                    <table class="table table-striped table-hover table-bordered" id="sample_1">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Created At</th>
                                <th class="span2"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($user_groups as $user_group)

                                <tr class="">
                                    <td>{{ $user_group->id }}</td>
                                    <td>{{ $user_group->name }}</td>
                                    <td>{{ $user_group->created_at }}</td>
                                    <td>
                                        @if ($current_user->hasAccess('user-groups.edit'))
                                        <a href="{{ URL::to($link_type . '/user-groups/' . $user_group->id . '/edit') }}" class="btn btn-mini"><i class="icon-edit"></i></a>
                                        @endif

                                        @if ($current_user->hasAccess('user-groups.destroy'))
                                        <div class="actions inline">
                                            <div class="btn btn-mini">
                                                <i class="icon-cog"> Actions</i>
                                            </div>
                                            <ul class="btn btn-mini">
                                                <li>
                                                    {{ Form::open(array('route' => array($link_type . '.user-groups.destroy', $user_group->id), 'method' => 'delete', 'class'=>'inline', 'onclick'=>"return deleteRecord($(this), 'user group');")) }}
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
@stop
