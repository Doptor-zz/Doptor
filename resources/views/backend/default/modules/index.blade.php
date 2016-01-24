@section('content')
    <div class="row-fluid">
        <div class="span12">
            <!-- BEGIN EXAMPLE TABLE widget-->
            <div class="widget light-gray box">
                <div class="blue widget-title">
                    <h4>
                        <i class="icon-th-list"></i>{!! trans('cms.modules') !!}
                        @if ($link_type == 'admin')
                            @if ($current_user->hasAccess('modules.create'))
                                <div class="btn-group pull-right">
                                    <button data-href="{!! URL::to($link_type . '/modules/install') !!}" class="btn btn-success">
                                        {!! trans('fields.install_new_module') !!} <i class="icon-plus"></i>
                                    </button>
                                </div>
                            @endif
                        @endif
                    </h4>
                    <div class="tools">
                        <a href="javascript:;" class="collapse"></a>
                        <a href="#widget-config" data-toggle="modal" class="config"></a>
                        <a href="javascript:;" class="reload"></a>
                        <a href="javascript:;" class="remove"></a>
                    </div>
                </div>
                <div class="widget-body">
                    @if ($link_type != 'admin')
                        <div class="clearfix margin-bottom-10">
                            <div class="btn-group pull-right">
                                @if ($current_user->hasAccess('modules.create'))
                                    <button data-href="{!! URL::to($link_type . '/modules/install') !!}" class="btn btn-success">
                                        {!! trans('fields.install_new_module') !!} <i class="icon-plus"></i>
                                    </button>
                                @endif
                            </div>
                        </div>
                    @endif
                    <table class="table table-striped table-hover table-bordered" id="sample_1">
                        <thead>
                            <tr>
                                <th>{!! trans('fields.name') !!}</th>
                                <th>{!! trans('fields.links') !!}</th>
                                <th>{!! trans('fields.version') !!}</th>
                                <th>{!! trans('fields.author') !!}</th>
                                <th>{!! trans('fields.website') !!}</th>
                                <th>{!! trans('fields.table_in_db') !!}</th>
                                <th>{!! trans('fields.enabled') !!}</th>
                                <th class="span3">{!! trans('fields.installed_at') !!}</th>
                                <!-- <th class="span2">{!! trans('options.edit') !!}</th> -->
                                <th class="span2"></th>
                            </tr>
                        </thead>
                        <tbody id="menu-list">
                            @foreach ($modules as $module)
                                <tr class="">
                                    <td>{!! $module->name !!}</td>
                                    <td>
                                        @foreach ($module->targets() as $target)
                                            {!! Str::title($target) !!} :
                                            <?php $target = ($target=='public') ? '' : $target . '/' ?>
                                            @foreach ($module->getLinks() as $alias => $name)
                                                {!! HTML::link($target . 'modules/' . $alias, $name) !!}
                                                <br>
                                            @endforeach
                                        @endforeach
                                    </td>
                                    <td>{!! $module->version !!}</td>
                                    <td>{!! $module->author !!}</td>
                                    <td>{!! $module->website !!}</td>
                                    <td>{!! $module->tables() !!}</td>
                                    <td>{!! ($module->enabled) ? 'Yes' : 'No' !!}</td>
                                    <td>{!! $module->created_at !!}</td>
                                    <!-- <td>
                                        <a href="{!! URL::to($link_type . '/modules/' . $module->id . '/edit') !!}" class="btn btn-mini"><i class="icon-edit"></i> Full {!! trans('options.edit') !!}</a>
                                    </td> -->
                                    <td>
                                        <div class="actions inline">
                                            <div class="btn btn-mini">
                                                <i class="icon-cog"> {!! trans('options.actions') !!}</i>
                                            </div>
                                            <ul class="btn btn-mini">
                                                @if ($current_user->hasAccess('modules.destroy'))
                                                <li>
                                                    {!! Form::open(array('route' => array($link_type . '.modules.destroy', $module->id), 'method' => 'delete', 'class'=>'inline', 'onclick'=>"return deleteRecord($(this), 'module');")) !!}
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
        <script type="text/javascript" src="{!! URL::to("assets/backend/default/plugins/data-tables/jquery.dataTables.js") !!}"></script>
        <script type="text/javascript" src="{!! URL::to("assets/backend/default/plugins/data-tables/DT_bootstrap.js") !!}"></script>
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        @parent
        <script src="{!! URL::to("assets/backend/default/scripts/table-managed.js") !!}"></script>
        <script>
           jQuery(document).ready(function() {
              TableManaged.init();
           });
        </script>
        <!-- END PAGE LEVEL SCRIPTS -->
@stop
