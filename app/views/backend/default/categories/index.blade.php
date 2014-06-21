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
                    <h4><i class="icon-th-list"></i>{{ Str::title($type) }} Categories</h4>
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
                                @if ($current_user->hasAccess("{$type}-categories.destroy"))
                                    <li>
                                        {{ Form::open(array('route' => array($link_type . '.' . $type . '-categories.destroy', 'multiple'), 'method' => 'delete', 'class'=>'inline', 'onsubmit'=>"return deleteRecords($(this), '{$type} categorie');")) }}
                                            {{ Form::hidden('selected_ids', '', array('id'=>'selected_ids')) }}
                                            <button type="submit" class="danger delete"><i class="icon-trash"></i> Delete</button>
                                        {{ Form::close() }}
                                    </li>
                                @endif
                                </ul>
                            </div>
                        </div>
                        @if ($current_user->hasAccess("{$type}-categories.create"))
                        <div class="btn-group pull-right">
                            <button data-href="{{ URL::to($link_type . '/' . $type . '-categories/create') }}" class="btn btn-success">
                                Add New <i class="icon-plus"></i>
                            </button>
                        </div>
                        @endif
                    </div>
                    <table class="table table-striped table-hover table-bordered" id="sample_1">
                        <thead>
                            <tr>
                                <th class="span1"></th>
                                <th>Name</th>
                                <th>Alias</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th class="span3">Created At</th>
                                <th class="span2"></th>
                            </tr>
                        </thead>
                        <tbody id="menu-list">
                            @foreach ($post_cats as $post_cat)
                                <tr class="">
                                    <td>{{ Form::checkbox($post_cat->id, 'checked', false) }}</td>
                                    <td>{{ $post_cat->name }}</td>
                                    <td>{{ $post_cat->alias }}</td>
                                    <td>{{ $post_cat->description }}</td>
                                    <td>{{ $post_cat->status() }}</td>
                                    <td>{{ $post_cat->created_at }}</td>
                                    <td>
                                        @if ($current_user->hasAccess("{$type}-categories.edit"))
                                        <a href="{{ URL::to($link_type . '/' . $type .'-categories/' . $post_cat->id . '/edit') }}" class="btn btn-mini"><i class="icon-edit"></i></a>
                                        @endif

                                        <div class="actions inline">
                                            <div class="btn btn-mini">
                                                <i class="icon-cog"> Actions</i>
                                            </div>
                                            <ul class="btn btn-mini">
                                            @if ($current_user->hasAccess("{$type}-categories.destroy"))
                                                <li>
                                                    {{ Form::open(array('route' => array($link_type . '.' . $type . '-categories.destroy', $post_cat->id), 'method' => 'delete', 'class'=>'inline', 'onclick'=>"return deleteRecord($(this), '{$type} category');")) }}
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
    </script>
@stop
