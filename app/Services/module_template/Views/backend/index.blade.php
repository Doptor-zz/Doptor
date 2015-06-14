@section('styles')
    <!-- BEGIN PAGE LEVEL STYLES -->
    {{ HTML::style('assets/backend/default/plugins/data-tables/DT_bootstrap.css') }}
    <!-- END PAGE LEVEL STYLES -->
@stop

@section('content')
    <div class="row-fluid">
        <div class="span12">
            <!-- BEGIN TABLE widget-->
            <div class="widget box blue">
                <div class="widget-title">
                    <h4><i class="icon-th-list"></i> All Entries</h4>
                </div>
                <div class="widget-body">
                    <div class="row-fluid">
                        <div class="tabbable tabbable-custom">
                            <ul class="nav nav-tabs">
                                @foreach ($forms as $i => $form)
                                    <li class="{{ $i==0 ? 'active' : '' }}">
                                        <a href="#tab_{{ $i }}" data-toggle="tab">
                                            {{ $form['form_name'] }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                            <div class="tab-content">
                                @foreach ($forms as $i => $form)
                                    <div class="tab-pane {{ $i==0 ? 'active' : '' }}" id="tab_{{ $i }}">
                                        <div class="clearfix margin-bottom-10">
                                            <div class="btn-group pull-right">
                                                <div class="actions inline">
                                                    <div class="btn">
                                                        <i class="icon-cog"> Actions</i>
                                                    </div>
                                                    <ul class="btn">
                                                        <li>
                                                            {{ Form::open(array('route' => array('backend.modules.'.$module_link.'.destroy', 'multiple'), 'method' => 'delete', 'class'=>'inline', 'onsubmit'=>"return deleteRecords($(this), 'entries');")) }}
                                                            {{ Form::hidden('form_id', $form['form_id']) }}
                                                            {{ Form::hidden('selected_ids', '', array('class'=>'selected_ids')) }}
                                                                <button type="submit" class="danger"><i class="icon-trash"></i> Delete</button>
                                                            {{ Form::close() }}
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="btn-group pull-right">
                                                <a href="{{ URL::to('backend/modules/'.$module_link.'/create/'.$form['form_id']) }}" class="btn btn-success">
                                                    Add New <i class="icon-plus"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <table class="table table-striped table-hover table-bordered" id="sample_{{$i}}">
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
                                                            <a href="{{ URL::to('backend/modules/' . $module_link .'/' . $entry->id . '/edit/' . $form['form_id']) }}" class="btn btn-mini"><i class="icon-edit"></i></a>

                                                            <div class="actions inline">
                                                                <div class="btn btn-mini">
                                                                    <i class="icon-cog"> Actions</i>
                                                                </div>
                                                                <ul class="btn btn-mini">
                                                                    <li>
                                                                        {{ Form::open(array('route' => array('backend.modules.'.$module_link.'.destroy', $entry->id), 'method' => 'delete', 'class'=>'inline')) }}
                                                                            {{ Form::hidden('form_id', $form['form_id']) }}
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
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END TABLE widget-->
        </div>
    </div>
@stop

@section('scripts')
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    {{ HTML::script("assets/backend/default/plugins/data-tables/jquery.dataTables.js") }}
    {{ HTML::script("assets/backend/default/plugins/data-tables/DT_bootstrap.js") }}
    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN PAGE LEVEL SCRIPTS -->
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
                        restore_uniformity();
                    } else {
                        checkboxes.removeAttr('checked');
                        restore_uniformity();
                    }
                });
            @endforeach
        });
        function restore_uniformity() {
            $.uniform.restore("input[type=checkbox]");
            $('input[type=checkbox]').uniform();
        }
    </script>
    <!-- END PAGE LEVEL SCRIPTS -->
@stop
