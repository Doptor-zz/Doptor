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
                    <h4><i class="icon-th-list"></i>{{ trans('cms.form_categories') }}</h4>
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
                            @if ($current_user->hasAccess('form-categories.create'))
                            <button data-href="{{ URL::to($link_type . '/form-categories/create') }}" class="btn btn-success">
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
                            @foreach ($form_cats as $form_cat)
                                <tr class="">
                                    <td>{{ $form_cat->name }}</td>
                                    <td>{{ $form_cat->description }}</td>
                                    <td>{{ $form_cat->created_at }}</td>
                                    <td>
                                        @if ($current_user->hasAccess('form-categories.edit'))
                                        <a href="{{ URL::to($link_type . '/form-categories/' . $form_cat->id . '/edit') }}" class="btn btn-mini"><i class="icon-edit"></i></a>
                                        @endif

                                        <div class="actions inline">
                                            <div class="btn btn-mini">
                                                <i class="icon-cog"> Actions</i>
                                            </div>
                                            <ul class="btn btn-mini">
                                                @if ($current_user->hasAccess('form-categories.destroy'))
                                                <li>
                                                    {{ Form::open(array('route' => array($link_type . '.form-categories.destroy', $form_cat->id), 'method' => 'delete', 'class'=>'inline', 'onclick'=>"return deleteRecord($(this), 'form category');")) }}
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
@stop
