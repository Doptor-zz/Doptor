@section('styles')
@stop

@section('content')
    <div class="row-fluid">
        <div class="span12">
            <!-- BEGIN EXAMPLE TABLE widget-->
            <div class="widget light-gray box">
                <div class="blue widget-title">
                    <h4><i class="icon-th-list"></i>{{ trans('cms.contact_categories') }}</h4>
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
                                @if ($current_user->hasAccess("contact-categories.destroy"))
                                    <li>
                                        {{ Form::open(array('route' => array($link_type . '.contact-categories.destroy', 'multiple'), 'method' => 'delete', 'class'=>'inline', 'onsubmit'=>"return deleteRecords($(this), 'contact categorie');")) }}
                                            {{ Form::hidden('selected_ids', '', array('id'=>'selected_ids')) }}
                                            <button type="submit" class="danger delete"><i class="icon-trash"></i> Delete</button>
                                        {{ Form::close() }}
                                    </li>
                                @endif
                                </ul>
                            </div>
                        </div>
                        @if ($current_user->hasAccess("contact-categories.create"))
                        <div class="btn-group pull-right">
                            <a href="{{ URL::to($link_type . '/contact-categories/create') }}" class="btn btn-success">
                                Add New <i class="icon-plus"></i>
                            </a>
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
                            @foreach ($contact_cats as $contact_cat)
                                <tr class="">
                                    <td>{{ Form::checkbox($contact_cat->id, 'checked', false) }}</td>
                                    <td>{{ $contact_cat->name }}</td>
                                    <td>{{ $contact_cat->alias }}</td>
                                    <td>{{ $contact_cat->description }}</td>
                                    <td>{{ $contact_cat->status() }}</td>
                                    <td>{{ $contact_cat->created_at }}</td>
                                    <td>
                                        @if ($current_user->hasAccess("contact-categories.edit"))
                                        <a href="{{ URL::to($link_type . '/contact-categories/' . $contact_cat->id . '/edit') }}" class="btn btn-mini"><i class="icon-edit"></i></a>
                                        @endif

                                        <div class="actions inline">
                                            <div class="btn btn-mini">
                                                <i class="icon-cog"> Actions</i>
                                            </div>
                                            <ul class="btn btn-mini">
                                            @if ($current_user->hasAccess("contact-categories.destroy"))
                                                <li>
                                                    {{ Form::open(array('route' => array($link_type . '.contact-categories.destroy', $contact_cat->id), 'method' => 'delete', 'class'=>'inline', 'onclick'=>"return deleteRecord($(this), 'contact category');")) }}
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
