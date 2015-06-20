@section('styles')
    <!-- BEGIN PAGE LEVEL STYLES -->
    {!! HTML::style('assets/backend/default/plugins/data-tables/DT_bootstrap.css') !!}
    <!-- END PAGE LEVEL STYLES -->
@stop

@section('content')
    <div class="row-fluid">
        <div class="span12">
            <!-- BEGIN EXAMPLE TABLE widget-->
            <div class="widget light-gray box">
                <div class="blue widget-title">
                    <h4><i class="icon-th-list"></i>All Newsletters</h4>
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

                                @if ($current_user->hasAccess("modules.newsletters.destroy"))
                                    <li>
                                        {!! Form::open(array('route' => array($link_type . '.modules.newsletters.destroy', 'multiple'), 'method' => 'delete', 'class'=>'inline', 'onsubmit'=>"return deleteRecords($(this), 'newsletters');")) !!}
                                            {!! Form::hidden('selected_ids', '', array('id'=>'selected_ids')) !!}
                                            <button type="submit" class="danger delete"><i class="icon-trash"></i> Delete</button>
                                        {!! Form::close() !!}
                                    </li>
                                @endif
                                </ul>
                            </div>
                        </div>
                        @if ($current_user->hasAccess("{$link_type}.newsletters.create"))
                        <div class="btn-group pull-right">
                            <a href="{!! URL::to("{$link_type}/modules/newsletters/create") !!}" class="btn btn-success">
                                Add New <i class="icon-plus"></i>
                            </a>
                        </div>
                        @endif
                    </div>
                    <table class="table table-striped table-hover table-bordered" id="sample_1">
                        <thead>
                            <tr>
                                <th class="span1"><input type="checkbox" class="select_all" /></th>
                                <th>Subject</th>
                                <th>Content</th>
                                <th class="span3">Subscribed At</th>
                                <th class="span3"></th>
                            </tr>
                        </thead>
                        <tbody id="menu-list">
                            @foreach ($newsletters as $newsletter)
                                <tr class="">
                                    <td>{!! Form::checkbox($newsletter->id, 'checked', false) !!}</td>
                                    <td>{!! $newsletter->subject !!}</td>
                                    <td>{!! $newsletter->content !!}</td>
                                    <td>{!! $newsletter->created_at !!}</td>
                                    <td>
                                        @if ($current_user->hasAccess("modules.newsletters.edit"))
                                        <a href="{!! URL::route("$link_type.modules.newsletters.edit", $newsletter->id) !!}" class="btn btn-mini"><i class="icon-edit"></i></a>
                                        @endif

                                        <div class="actions inline">
                                            <div class="btn btn-mini">
                                                <i class="icon-cog"> Actions</i>
                                            </div>
                                            <ul class="btn btn-mini">
                                            @if ($current_user->hasAccess("modules.newsletters.destroy"))
                                                <li>
                                                    {!! Form::open(array('route' => array($link_type . '.modules.newsletters.destroy', $newsletter->id), 'method' => 'delete', 'class'=>'inline', 'onclick'=>"return deleteRecord($(this), 'subscriber');")) !!}
                                                        <button type="submit" class="danger delete"><i class="icon-trash"></i> Delete</button>
                                                    {!! Form::close() !!}
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
{!! HTML::script("assets/backend/default/plugins/data-tables/jquery.dataTables.js") !!}
{!! HTML::script("assets/backend/default/plugins/data-tables/DT_bootstrap.js") !!}
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
@parent
{!! HTML::script("assets/backend/default/scripts/table-managed.js") !!}
<script>
    jQuery(document).ready(function() {
        TableManaged.init();
    });
</script>
<!-- END PAGE LEVEL SCRIPTS -->
<script>
    $(function() {
        $('#selected_ids').val('');

        $('.select_all').change(function() {
            var checkboxes = $('#sample_1').find('tbody').find(':checkbox');

            if ($(this).is(':checked')) {
                checkboxes.attr('checked', 'checked');
                restore_uniformity();
            } else {
                checkboxes.removeAttr('checked');
                restore_uniformity();
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
    function restore_uniformity() {
        $.uniform.restore("input[type=checkbox]");
        $('input[type=checkbox]').uniform();
    }
</script>
@stop
