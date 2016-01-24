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
                    <h4><i class="icon-th-list"></i> {!! trans('cms.translation_manager') !!}</h4>
                    <div class="tools">
                        <a href="javascript:;" class="collapse"></a>
                        <a href="#widget-config" data-toggle="modal" class="config"></a>
                        <a href="javascript:;" class="reload"></a>
                        <a href="javascript:;" class="remove"></a>
                    </div>
                </div>
                <div class="widget-body">
                    <div class="clearfix margin-bottom-10">
                        @if ($current_user->hasAccess("translation_manager.languages.create"))
                        <div class="btn-group pull-right">
                            <a href="{!! route($link_type . '.modules.doptor.translation_manager.languages.create') !!}" class="btn btn-success">
                                {!! trans('options.create_new') !!} <i class="icon-plus"></i>
                            </a>
                        </div>
                        @endif
                        @if ($current_user->hasAccess("translation_manager.languages.get_install"))
                        <div class="btn-group pull-right">
                            <a href="{!! route($link_type . '.modules.doptor.translation_manager.languages.get_install') !!}" class="btn btn-success">
                                {!! trans('options.install_new') !!} <i class="icon-plus"></i>
                            </a>
                        </div>
                        @endif
                    </div>
                    <table class="table table-striped table-hover table-bordered" id="sample_1">
                        <thead>
                            <tr>
                                <th>{!! trans('fields.language') !!}</th>
                                <th>{!! trans('fields.code') !!}</th>
                                <th class="span3"></th>
                                <th class="span2"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($languages as $language)
                                <tr>
                                    <td>{!! $language->name !!}</td>
                                    <td>{!! $language->code !!}</td>
                                    <td>
                                        {!! link_to_route('backend.modules.doptor.translation_manager.index', trans('options.manage'), [$language->id]) !!}
                                        |
                                        {!! link_to_route('backend.modules.doptor.translation_manager.export', trans('options.export'), [$language->id]) !!}
                                    </td>
                                    <td>
                                    @if ($language->id != 1)
                                        @if ($current_user->hasAccess("translation_manager.languages.edit"))
                                        <a href="{!! route($link_type . '.modules.doptor.translation_manager.languages.edit', [$language->id]) !!}" class="btn btn-mini"><i class="icon-edit"></i></a>
                                        @endif
                                        <div class="actions inline">
                                            <div class="btn btn-mini">
                                                <i class="icon-cog"> {!! trans('options.actions') !!}</i>
                                            </div>
                                            <ul class="btn btn-mini">
                                                @if ($current_user->hasAccess("translation_manager.languages.destroy"))
                                                <li>
                                                    {!! Form::open(array('route' => array($link_type . '.modules.doptor.translation_manager.languages.destroy', $language->id), 'method' => 'delete', 'class'=>'inline', 'onclick'=>"return deleteRecord($(this), 'language');")) !!}
                                                        <button type="submit" class="danger delete"><i class="icon-trash"></i> {!! trans('options.delete') !!}</button>
                                                    {!! Form::close() !!}
                                                </li>
                                                @endif
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
            <!-- END EXAMPLE TABLE widget-->
        </div>
    </div>
@stop

@section('scripts')
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        {!! HTML::script("assets/backend/default/plugins/data-tables/jquery.dataTables.js") !!}"
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
@stop
