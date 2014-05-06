@section('content')

<section class="indent">
    <div class="container">
        <div class="accordion-wrapper grid_12">

            <h1>{{ $title }}</h1>

            @if (Session::has('error_message'))
                <div class="grid_8">
                    <div class="alert alert-error nomargin">
                        Error! {{ Session::get('error_message') }}
                    </div>
                </div>
                <div class="clearfix"></div>
            @endif
            @if (Session::has('success_message'))
                <div class="grid_8">
                    <div class="alert alert-success nomargin">
                        Success! {{ Session::get('success_message') }}
                    </div>
                </div>
                <div class="clearfix"></div>
            @endif

            <div class="pull-right">
                <a href="{{ url('modules/'.$module_name.'/create') }}" class="pill pill-style1">
                    <span class="pill-inner">Add new</span>
                </a>
                <div class="actions inline">
                    <div class="pill">
                        <i class="pill-inner"> Actions</i>
                    </div>
                    <ul class="pill pill-small">
                        <li>
                            {{ Form::open(array('route' => array('modules.'.$module_name.'.destroy', 'multiple'), 'method' => 'delete', 'class'=>'inline')) }}
                                <button type="submit" class="danger"><i class="icon-trash" onclick="return deleteRecord($(this))"></i> Delete</button>
                            {{ Form::close() }}
                        </li>
                    </ul>
                </div>
            </div>
            <div class="clearfix"></div>
            <br>
            <table class="default-table" id="sample_1">
                <thead>
                    <tr>
                        <th class="span1"><input type="checkbox" class="select_all" /></th>
                        @foreach ($field_names as $field_name)
                            <th>{{ Str::title($field_name) }}</th>
                        @endforeach
                        <th class="span2"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($entries as $entry)
                        <tr>
                            <td>{{ Form::checkbox($entry->id, 'checked', false) }}</td>
                            @foreach ($fields as $field)
                                <td>{{ $entry->{$field} }}</td>
                            @endforeach
                            <td>

                                <a href="{{ URL::to('modules/' . $module_name .'/' . $entry->id . '/edit') }}" class="pill pill-small"><i class="pill-inner">Edit</i></a>

                                <div class="actions inline">
                                    <div class="pill pill-small">
                                        <i class="pill-inner"> Actions</i>
                                    </div>
                                    <ul class="pill pill-small">
                                        <li>
                                            {{ Form::open(array('route' => array('modules.'.$module_name.'.destroy', $entry->id), 'method' => 'delete', 'class'=>'inline')) }}
                                                <button type="submit" class="danger"><i class="icon-trash" onclick="return deleteRecord($(this))"></i> Delete</button>
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
</section>

@stop

@section('scripts')
    @parent
    <script>
        $(function() {
            $('#selected_ids').val('');

            $('.select_all').change(function() {
                var checkboxes = $('#sample_1 tbody').find(':checkbox');

                if ($(this).is(':checked')) {
                    checkboxes.attr('checked', 'checked');
                } else {
                    checkboxes.removeAttr('checked');
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
    </script>
    <!-- END PAGE LEVEL SCRIPTS -->
@stop
