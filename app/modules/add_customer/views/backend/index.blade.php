@section('styles')
    <!-- BEGIN PAGE LEVEL STYLES -->
    <link rel="stylesheet" href="{{ URL::to('assets/backend/plugins/data-tables/DT_bootstrap.css') }}" />
    <!-- END PAGE LEVEL STYLES -->
@stop

@section('content')
    <div class="row-fluid">
        <div class="span12">
            <!-- BEGIN EXAMPLE TABLE widget-->
            <div class="widget box blue">
                <div class="widget-title">
                    <h4><i class="icon-th-list"></i> All Entries</h4>
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
                            <button data-href="{{ URL::to('backend/modules/'.$module_name.'/create') }}" class="btn btn-success">
                                Add New <i class="icon-plus"></i>
                            </button>
                        </div>
                    </div>
                    <table class="table table-striped table-hover table-bordered" id="sample_1">
                        <thead>
                            <tr>
                                @foreach ($fields as $field)
                                    <th>{{ Str::title($field) }}</th>
                                @endforeach
                                <th class="span2"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($entries as $entry)
                                <tr>
                                    @foreach ($fields as $field)
                                        <td>{{ $entry->{$field} }}</td>
                                    @endforeach
                                    <td>
                                        <a href="{{ URL::to('backend/modules/' . $module_name .'/' . $entry->id . '/edit') }}" class="btn btn-mini"><i class="icon-edit"></i></a>

                                        <div class="actions inline">
                                            <div class="btn btn-mini">
                                                <i class="icon-cog"> Actions</i>
                                            </div>
                                            <ul class="btn btn-mini">
                                                <li>
                                                    {{ Form::open(array('route' => array('backend.modules.'.$module_name.'.destroy', $entry->id), 'method' => 'delete', 'class'=>'inline')) }}
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
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <script type="text/javascript" src="{{ URL::to("assets/backend/plugins/data-tables/jquery.dataTables.js") }}"></script>
    <script type="text/javascript" src="{{ URL::to("assets/backend/plugins/data-tables/DT_bootstrap.js") }}"></script>
    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    @parent
    <script>
       function deleteRecord(th) {
           doDelete = confirm("Are you sure you want to delete the entry?");
           if (!doDelete) {
               // If cancel is selected, do nothing
               return false;
           }
       }
    </script>
    <!-- END PAGE LEVEL SCRIPTS -->
@stop
