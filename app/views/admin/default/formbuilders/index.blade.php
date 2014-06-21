@section('content')
    <div class="row-fluid">
        <div class="span12">
            <!-- BEGIN TABLE widget-->
            <div class="widget box light-grey">
                <div class="blue widget-title">
                    <h4><i class="icon-table"></i>All Built Forms</h4>
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
                            @if ($current_user->hasAccess('form-builder.create'))
                                <button data-href="{{ URL::to($link_type . '/form-builder/create') }}" class="btn btn-success">
                                    Add New <i class="icon-plus"></i>
                                </button>
                            @endif
                        </div>
                    </div>
                    <table class="table table-striped table-bordered table-hover" id="sample_1">
                        <thead>
                            <tr>
                                <th style="width:8px;"><input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes" /></th>
                                <th>Form Name</th>
                                <th class="hidden-480">Category</th>
                                <th class="hidden-480">Description</th>
                                <th class="hidden-480">Created At</th>
                                <th class="span2"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($forms as $form)

                                <tr class="odd gradeX">
                                    <td><input type="checkbox" class="checkboxes" value="1" /></td>
                                    <td>{{ HTML::link(URL::to($link_type . '/form-builder/'.$form->id), $form->name) }}</td>
                                    <td class="hidden-480">{{ $form->cat->name }}</td>
                                    <td class="hidden-480">{{ $form->description }}</td>
                                    <td>{{ $form->created_at }}</td>
                                    <td>
                                        @if ($current_user->hasAccess('form-builder.edit'))
                                        <a href="{{ URL::to($link_type . '/form-builder/' . $form->id . '/edit') }}" class="btn btn-mini"><i class="icon-edit"></i></a>
                                        @endif

                                        <div class="actions inline">
                                            <div class="btn btn-mini">
                                                <i class="icon-cog"> Actions</i>
                                            </div>
                                            <ul class="btn btn-mini">
                                                @if ($current_user->hasAccess('form-builder.destroy'))
                                                <li>
                                                    {{ Form::open(array('route' => array($link_type . '.form-builder.destroy', $form->id), 'method' => 'delete', 'class'=>'inline', 'onclick'=>"return deleteRecord($(this), 'form builder');")) }}
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
            <!-- END TABLE widget-->
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
