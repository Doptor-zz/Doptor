@section('styles')
    @if (!isset($media_entry))
        {{-- Load the Dropzone file only during the addition of media entry --}}
        {!! HTML::style('assets/backend/default/plugins/dropzone/css/basic.css') !!}
        {!! HTML::style('assets/backend/default/plugins/dropzone/css/dropzone.css') !!}
    @endif
    <style>
        .media-manager li {
            list-style: none;
            margin: 0 auto;
            width: 64px;
            height: 64px;
            margin: 0 50px 50px 0;
        }
        .media-manager .options {
            bottom: -45px;
            position: absolute;
        }
        .icon-folder-close {
            font-size: 100px;
        }
        .file-name {
            text-align: center;
            overflow: hidden;
            text-overflow: ellipsis;
            width: 100px;
        }
        .folder-image {
            width: 120px;
            float: left;
        }
        .folder-image:hover {
            opacity: 0.7;
            cursor: hand;
        }
    </style>
@stop

@section('content')
    <div class="row-fluid">
        <div class="span12">
            <!-- BEGIN FORM widget-->
            <div class="widget box blue tabbable">
                <div class="blue widget-title">
                    <h4>
                        <i class="icon-user"></i>
                        @if (!isset($media_entry))
                            <span class="hidden-480">{!! trans('cms.media_manager') !!}</span>
                        @else
                            <span class="hidden-480">{!! trans('options.edit') !!} {!! trans('cms.media_manager') !!}</span>
                        @endif
                        &nbsp;
                    </h4>
                </div>
                <div class="widget-body form">
                    <div class="tabbable widget-tabs">
                        <div class="tab-content">
                            <div class="tab-pane active" id="widget_tab1">
                                <!-- BEGIN FORM-->
                                @if (!isset($media_entry))
                                    {!! Form::open(array('route'=>$link_type . '.media-manager.store', 'method'=>'POST', 'class'=>'dropzone form-horizontal')) !!}
                                    <div class="control-group {!! $errors->has('folder') ? 'error' : '' !!}">
                                        <label class="control-label">{!! trans('form_messages.current_folder') !!}</label>
                                        <div class="controls">
                                            {!! Form::text('folder', $base_dir, array('class' => 'input-xlarge', 'disabled') ) !!}
                                            <a href="#" class="btn btn-mini" id="up-folder" title="Go up one directory"><i class="icon-arrow-up"></i></a>
                                            <a href="#" class="btn btn-mini" id="reload-folder" title="Reload Folder"><i class="icon-refresh"></i></a>
                                            {!! HTML::link("#create-folder", "Create Folder", array('class'=>'btn btn-mini', 'role'=>'button', 'data-toggle'=>'modal')) !!}
                                            <span class="help-inline">{!! trans('form_messages.drop_to_upload') !!}</span>
                                        </div>
                                    </div>
                                    <ul class="media-manager">

                                    </ul>
                                    <!-- <div class="clearfix"></div> -->


                                    {!! Form::close() !!}

                                    <div id="create-folder" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="true">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            <h3 id="myModalLabel3">{!! trans('options.create_new') !!} {!! trans('fields.folder') !!}</h3>
                                        </div>
                                        <div class="modal-body">
                                            <div class="control-group {!! $errors->has('folder') ? 'error' : '' !!}">
                                            <label class="control-label">{!! trans('fields.folder') !!} {!! trans('fields.name') !!}</label>
                                            <div class="controls">
                                                {!! Form::text('folder_name', '') !!}
                                                <span class="help-inline">{!! trans('form_messages.no_spaces_in_folder') !!}</span>
                                            </div>
                                        </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn" data-dismiss="modal" aria-hidden="true">{!! trans('options.close') !!}</button>
                                            <button data-dismiss="modal" class="btn btn-primary" id="folder-submit">{!! trans('options.confirm') !!}</button>
                                        </div>
                                    </div>
                                @else
                                    {!! Form::open(array('route' => array($link_type . '.media-manager.update', $media_entry->id), 'method'=>'PUT', 'class'=>'dropzone form-horizontal')) !!}

                                        {!! Form::text('id', $media_entry->id, array('class' => 'hide')) !!}

                                        {!! HTML::image($media_entry->image, '', array('width'=>'500')) !!}

                                        <br><br>

                                        <div class="control-group {!! $errors->has('caption') ? 'error' : '' !!}">
                                            <label class="control-label">{!! trans('fields.caption') !!}</label>
                                            <div class="controls">
                                                {!! Form::text('caption', $media_entry->caption, array('class' => 'input-xlarge'))!!}
                                                {!! $errors->first('caption', '<span class="help-inline">:message</span>') !!}
                                            </div>
                                        </div>

                                        <div class="form-actions">
                                            <button type="submit" class="btn btn-primary"><i class="icon-ok"></i> {!! trans('options.save') !!}</button>
                                        </div>
                                    {!! Form::close() !!}
                                @endif
                                <!-- END FORM-->
                                <div class="modal hide" id="pleaseWaitDialog" data-backdrop="static" data-keyboard="false">
                                    <div class="modal-header">
                                        <h1>{!! trans('options.processing') !!}</h1>
                                    </div>
                                    <div class="modal-body">
                                        <div class="progress progress-striped active">
                                            <div class="bar" style="width: 100%;"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END FORM widget-->
        </div>
    </div>
@stop

@section('scripts')
    @include('backend.default.media_manager.scripts')
@stop
