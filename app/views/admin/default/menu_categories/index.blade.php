@section('content')
    <div class="row-fluid">
        <div class="span12">
            <!-- BEGIN EXAMPLE TABLE widget-->
            <div class="widget light-gray box">
                <div class="blue widget-title">
                    <h4><i class="icon-th-list"></i>Menu Categories</h4>
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
                            @if ($current_user->hasAccess('menu-categories.create'))
                            <button data-href="{{ URL::to($link_type . '/menu-categories/create') }}" class="btn btn-success">
                                Add New <i class="icon-plus"></i>
                            </button>
                            @endif
                        </div>
                    </div>
                    <table class="table table-striped table-hover table-bordered" id="sample_1">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Description</th>
                                <th class="span3">Created At</th>
                                <th class="span2"></th>
                            </tr>
                        </thead>
                        <tbody id="menu-list">
                            @foreach ($menu_cats as $menu_cat)
                                <tr class="">
                                    <td>{{ $menu_cat->name }}</td>
                                    <td>{{ $menu_cat->description }}</td>
                                    <td>{{ $menu_cat->created_at }}</td>
                                    <td>
                                        @if ($current_user->hasAccess('menu-categories.edit'))
                                        <a href="{{ URL::to($link_type . '/menu-categories/' . $menu_cat->id . '/edit') }}" class="btn btn-mini"><i class="icon-edit"></i></a>
                                        @endif

                                        <div class="actions inline">
                                            <div class="btn btn-mini">
                                                <i class="icon-cog"> Actions</i>
                                            </div>
                                            <ul class="btn btn-mini">
                                                @if ($current_user->hasAccess('menu-categories.destroy'))
                                                <li>
                                                    {{ Form::open(array('route' => array($link_type . '.menu-categories.destroy', $menu_cat->id), 'method' => 'delete', 'class'=>'inline', 'onclick'=>"return deleteRecord($(this), 'menu category');")) }}
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
@stop
