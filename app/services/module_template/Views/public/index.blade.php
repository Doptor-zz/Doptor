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

            <div class="tabs full-w">
                <ul class="tab-menu">
                    @foreach ($forms as $i => $form)
                        <li class="{{ $i==0 ? 'active' : '' }}">
                            <a href="#tab_{{ $i }}">
                                {{ $form['form_name'] }}
                                <i class="l-tab-shad"></i>
                                <i class="r-tab-shad"></i>
                            </a>
                        </li>
                    @endforeach
                </ul>
                <div class="clear"></div>
                <div class="tab-wrapper">
                    @foreach ($forms as $i => $form)
                        <div class="tab {{ $i==0 ? 'active' : '' }}" id="tab_{{ $i }}">
                            <div class="pull-right">
                                <a href="{{ URL::to('modules/'.$module_link.'/create/'.$form['form_id']) }}" class="pill pill-style1">
                                    <span class="pill-inner">Add new</span>
                                </a>
                                <div class="actions inline">
                                    <div class="pill">
                                        <i class="pill-inner"> Actions</i>
                                    </div>
                                    <ul class="pill pill-small">
                                        <li>
                                            {{ Form::open(array('route' => array('modules.'.$module_link.'.destroy', 'multiple'), 'method' => 'delete', 'class'=>'inline', 'onsubmit'=>"return deleteRecords($(this), 'entries');")) }}
                                            {{ Form::hidden('form_id', $form['form_id']) }}
                                            {{ Form::hidden('selected_ids', '', array('class'=>'selected_ids')) }}
                                                <button type="submit" class="danger"><i class="icon-trash"></i> Delete</button>
                                            {{ Form::close() }}
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <table class="default-table" id="sample_{{$i}}">
                                <thead>
                                    <tr>
                                        <th class="span1"><input type="checkbox" class="select_all" /></th>
                                        @foreach ($form['field_names'] as $field_name)
                                            <th>{{ Str::title($field_name) }}</th>
                                        @endforeach
                                        <th class="span2">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($form['entries'] as $entry)
                                        <tr>
                                            <td>{{ Form::checkbox($entry->id, 'checked', false) }}</td>
                                            @foreach ($form['fields'] as $field)
                                                <td>{{ $entry->{$field} }}</td>
                                            @endforeach
                                            <td>
                                                <a href="{{ URL::to('modules/' . $module_link .'/' . $entry->id . '/edit/' . $form['form_id']) }}" class="pill pill-small"><span class="pill-inner">Edit</span></a>

                                                <div class="actions inline">
                                                    <div class="pill pill-small">
                                                        <i class="pill-inner"> Actions</i>
                                                    </div>
                                                    <ul>
                                                        <li>
                                                            {{ Form::open(array('route' => array('modules.'.$module_link.'.destroy', $entry->id), 'method' => 'delete', 'class'=>'inline')) }}
                                                                {{ Form::hidden('form_id', $form['form_id']) }}
                                                                <button type="submit" class="danger" onclick="return deleteRecord($(this))"><span class="pill-inner">Delete</span></button>
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
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</section>

@stop

@section('scripts')
    @parent
    <script>
        function deleteRecords(th, type) {
            if (type === undefined) type = 'record';

            doDelete = confirm("Are you sure you want to delete the selected " + type + "s ?");
            if (!doDelete) {
                // If cancel is selected, do nothing
                return false;
            }

            @foreach($forms as $i => $form)
            var this_form = $("#tab_{{$i}}");
            this_form.find('input:checked').each(function() {
                var value = this_form.find('.selected_ids').val();
                this_form.find('.selected_ids').val(value + ' ' + this.name);
            });
            @endforeach
        }
        $(function() {
            $('.selected_ids').val('');

            @foreach($forms as $i => $form)
                this_form_{{$i}} = $("#tab_{{$i}}");
                this_form_{{$i}}.find('.select_all').change(function() {
                    var checkboxes = this_form_{{$i}}.find(':checkbox');

                    if ($(this).is(':checked')) {
                        checkboxes.attr('checked', 'checked');
                    } else {
                        checkboxes.removeAttr('checked');
                    }
                });
            @endforeach
        });
    </script>
    <!-- END PAGE LEVEL SCRIPTS -->
@stop
