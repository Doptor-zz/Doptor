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
                    <h4><i class="icon-th-list"></i>{!! trans('cms.restore') !!}</h4>
                    <div class="tools">
                        <a href="javascript:;" class="collapse"></a>
                        <a href="#widget-config" data-toggle="modal" class="config"></a>
                        <a href="javascript:;" class="reload"></a>
                        <a href="javascript:;" class="remove"></a>
                    </div>
                </div>
                <div class="widget-body">
                    <div class="alert alert-warning">
                        <strong>Warning!</strong>
                        {!! trans('form_messages.restore_warning') !!}
                    </div>
                    <div class="clearfix margin-bottom-10">
                        <div class="btn-group pull-right">
                            <div class="actions inline">
                                <div class="btn">
                                    <i class="icon-cog"> {!! trans('options.actions') !!}</i>
                                </div>
                                <ul class="btn">
                                @if ($current_user->hasAccess("backups.destroy"))
                                    <li>
                                        {!! Form::open(array('route' => array('backups.destroy', 'multiple'), 'method' => 'delete', 'class'=>'inline', 'onsubmit'=>"return deleteRecords($(this), 'Backup file');")) !!}
                                            {!! Form::hidden('selected_ids', '', array('id'=>'selected_ids')) !!}
                                            <button type="submit" class="danger delete"><i class="icon-trash"></i> {!! trans('options.delete') !!}</button>
                                        {!! Form::close() !!}
                                    </li>
                                @endif
                                </ul>
                            </div>
                        </div>
                        @if ($current_user->hasAccess("backups.create"))
                        <div class="btn-group pull-right">
                            <a href="{!! URL::to('backend/restore/upload') !!}" class="btn btn-success">
                                {!! trans('options.upload_backup') !!} <i class="icon-plus"></i>
                            </a>
                        </div>
                        @endif
                    </div>
                    <table class="table table-striped table-hover table-bordered" id="sample_1">
                        <thead>
                            <tr>
                                <th>{!! trans('fields.description') !!}</th>
                                <th>{!! trans('fields.includes') !!}</th>
                                <th class="span3">{!! trans('options.created_at') !!}</th>
                                <th class="span2"></th>
                            </tr>
                        </thead>
                        <tbody id="menu-list">
                            @foreach ($backups as $backup)
                                <tr class="">
                                    <td>{!! $backup->description !!}</td>
                                    <td>{!! implode(', ', $backup->includes) !!}</td>
                                    <td>{!! $backup->created_at !!}</td>
                                    <td>
                                        <div class="actions inline">
                                            <div class="btn btn-mini">
                                                <i class="icon-cog"> {!! trans('options.actions') !!}</i>
                                            </div>
                                            <ul class="btn btn-mini">
                                                @if ($current_user->hasAccess("backups.restore"))
                                                    <li>
                                                        {!! Form::open(array('route' => 'backups.restore', 'method' => 'post', 'class'=>'inline', 'onclick'=>"return restoreBackup($(this));")) !!}

                                                            <input type="hidden" name="backup_id" value="{{ $backup->id }}">
                                                            <button type="submit" class="warning"><i class="icon-refresh"></i> {!! trans('cms.restore') !!}</button>
                                                        {!! Form::close() !!}
                                                    </li>
                                                @endif
                                                @if ($current_user->hasAccess("backups.destroy"))
                                                    <li>
                                                        {!! Form::open(array('route' => array('backups.destroy', $backup->id), 'method' => 'delete', 'class'=>'inline', 'onclick'=>"return deleteRecord($(this), 'Backup file');")) !!}
                                                            <button type="submit" class="danger delete"><i class="icon-trash"></i> {!! trans('options.delete') !!}</button>
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

       function restoreBackup(th) {
            doRestore = confirm("Are you sure you want to restore from the backup? {!! trans('form_messages.restore_warning') !!}");
            if (!doRestore) {
                // If cancel is selected, do nothing
                return false;
            }
        }
    </script>
    <!-- END PAGE LEVEL SCRIPTS -->
@stop
