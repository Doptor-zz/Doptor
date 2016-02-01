@section('content')
    <div class="row-fluid">
        <div class="span12">
            <!-- BEGIN TABLE widget-->
            <div class="widget box light-grey">
                <div class="blue widget-title">
                    <h4><i class="icon-table"></i>{!! trans('cms.module_builder') !!}</h4>
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
                            @if ($current_user->hasAccess('module-builder.create'))
                                <button data-href="{!! URL::to($link_type . '/module-builder/create') !!}" class="btn btn-success">
                                    {!! trans('options.create_new') !!} <i class="icon-plus"></i>
                                </button>
                            @endif
                        </div>
                    </div>
                    <table class="table table-striped table-hover table-bordered" id="sample_1">
                        <thead>
                            <tr>
                                <th>{!! trans('fields.name') !!}</th>
                                <th>{!! trans('fields.version') !!}</th>
                                <th>{!! trans('fields.author') !!}</th>
                                <th>{!! trans('fields.website') !!}</th>
                                <th>{!! trans('modules.selected_forms') !!}</th>
                                <th>{!! trans('modules.table_names') !!}</th>
                                <th>{!! trans('modules.download') !!}</th>
                                <th>{!! trans('options.created_at') !!}</th>
                                <!-- <th class="span2">{!! trans('options.edit') !!}</th> -->
                                <th class="span2"></th>
                            </tr>
                        </thead>
                        <tbody id="menu-list">
                            @foreach ($modules as $module)
                                <tr class="">
                                    <td>{!! $module->name !!}</td>
                                    <td>{!! $module->version !!}</td>
                                    <td>{!! $module->author !!}</td>
                                    <td>{!! $module->website !!}</td>
                                    <td>
                                        @foreach ($module->forms() as $module_form)
                                            {!! $module_form->name !!}
                                            @if ($current_user->hasAccess('form-builder.edit'))
                                            <a href="{!! URL::to($link_type . '/form-builder/' . $module_form->id . '/edit') !!}" class="btn btn-mini" title="{!! trans('options.edit') !!} Form"><i class="icon-edit"></i></a>
                                            @endif
                                            <br>
                                        @endforeach
                                    </td>
                                    <td>{!! $module->tables() !!}</td>
                                    <th>{!! HTML::link(url($link_type . '/module-builder/download/'.$module->id), trans('fields.download')) !!}</th>
                                    <td>{!! $module->created_at !!}</td>
                                    <td>
                                        @if ($current_user->hasAccess('module-builder.edit'))
                                        <a href="{!! URL::to($link_type . '/module-builder/' . $module->id . '/edit') !!}" class="btn btn-mini" title="{!! trans('options.edit') !!} Module"><i class="icon-edit"></i></a>
                                        @endif

                                        @if ($current_user->hasAccess('module-builder.destroy'))
                                        <div class="actions inline">
                                            <div class="btn btn-mini">
                                                <i class="icon-cog"> {!! trans('options.actions') !!}</i>
                                            </div>
                                            <ul class="btn btn-mini">
                                                <li>
                                                {!! Form::open(array('route' => array($link_type . '.module-builder.destroy', $module->id), 'method' => 'delete', 'class'=>'inline', 'onclick'=>"return deleteRecord($(this), 'module');")) !!}
                                                    <button type="submit" class="danger delete"><i class="icon-trash"></i> {!! trans('options.delete') !!}</button>
                                                {!! Form::close() !!}
                                                </li>
                                            </ul>
                                        </div>
                                        @endif
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
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <script type="text/javascript" src="{!! URL::to("assets/backend/default/plugins/data-tables/jquery.dataTables.js") !!}"></script>
        <script type="text/javascript" src="{!! URL::to("assets/backend/default/plugins/data-tables/DT_bootstrap.js") !!}"></script>
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        @parent
        <script src="{!! URL::to("assets/backend/default/scripts/table-managed.js") !!}"></script>
        <script>
            @if (Session::has('download_file'))
                location.href = "{!! URL::to('backend/module-builder/download/' . Session::get('download_file')) !!}";
            @endif
            jQuery(document).ready(function() {
                TableManaged.init();
            });
        </script>
        <!-- END PAGE LEVEL SCRIPTS -->
@stop
