@section('styles')
    @if (!isset($media_entry))
        {{-- Load the Dropzone file only during the addition of media entry --}}
        {{ HTML::style('assets/backend/default/plugins/dropzone/css/basic.css') }}
        {{ HTML::style('assets/backend/default/plugins/dropzone/css/dropzone.css') }}
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
            white-space: pre;
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
            <div class="widget box light-gray tabbable">
                <div class="blue widget-title">
                    <h4>
                        <i class="icon-user"></i>
                        @if (!isset($media_entry))
                            <span class="hidden-480">{{ trans('cms.media_manager') }}</span>
                        @else
                            <span class="hidden-480">Edit Media Entry</span>
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
                                    {{ Form::open(array('route'=>$link_type . '.media-manager.store', 'method'=>'POST', 'class'=>'dropzone form-horizontal')) }}
                                    <div class="control-group {{{ $errors->has('folder') ? 'error' : '' }}}">
                                        <label class="control-label">Current Folder</label>
                                        <div class="controls">
                                            {{ Form::text('folder', $base_dir, array('class' => 'input-xlarge', 'disabled') ) }}
                                            <a href="#" class="btn btn-mini" id="up-folder" title="Go up one directory"><i class="icon-arrow-up"></i></a>
                                            <a href="#" class="btn btn-mini" id="reload-folder" title="Reload Folder"><i class="icon-refresh"></i></a>
                                            {{ HTML::link("#create-folder", "Create Folder", array('class'=>'btn btn-mini', 'role'=>'button', 'data-toggle'=>'modal')) }}
                                            <span class="help-inline">Drop files to upload or click to browse files</span>
                                        </div>
                                    </div>
                                    <ul class="media-manager">

                                    </ul>
                                    <!-- <div class="clearfix"></div> -->


                                    {{ Form::close() }}

                                    <div id="create-folder" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="true">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            <h3 id="myModalLabel3">Create New Folder</h3>
                                        </div>
                                        <div class="modal-body">
                                            <div class="control-group {{{ $errors->has('folder') ? 'error' : '' }}}">
                                            <label class="control-label">Folder Name</label>
                                            <div class="controls">
                                                {{ Form::text('folder_name', '') }}
                                                <span class="help-inline">Don't use spaces and other invalid characters for folder name</span>
                                            </div>
                                        </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
                                            <button data-dismiss="modal" class="btn btn-primary" id="folder-submit">Confirm</button>
                                        </div>
                                    </div>
                                @else
                                    {{ Form::open(array('route' => array($link_type . '.media-manager.update', $media_entry->id), 'method'=>'PUT', 'class'=>'dropzone form-horizontal')) }}

                                        {{ Form::text('id', $media_entry->id, array('class' => 'hide')) }}

                                        {{ HTML::image($media_entry->image, '', array('width'=>'500')) }}

                                        <br><br>

                                        <div class="control-group {{{ $errors->has('caption') ? 'error' : '' }}}">
                                            <label class="control-label">Caption</label>
                                            <div class="controls">
                                                {{ Form::text('caption', $media_entry->caption, array('class' => 'input-xlarge'))}}
                                                {{ $errors->first('caption', '<span class="help-inline">:message</span>') }}
                                            </div>
                                        </div>

                                        <div class="form-actions">
                                            <button type="submit" class="btn btn-primary"><i class="icon-ok"></i> Save</button>
                                        </div>
                                    {{ Form::close() }}
                                @endif
                                <!-- END FORM-->
                                <div class="modal hide" id="pleaseWaitDialog" data-backdrop="static" data-keyboard="false">
                                    <div class="modal-header">
                                        <h1>Processing...</h1>
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
    @if (!isset($media_entry))
        {{ HTML::script('assets/backend/default/plugins/dropzone/dropzone.js') }}
    @endif
    @parent
    <script>
        jQuery(document).ready(function() {
            $('.default.message').remove();

            $('input[name=folder]').val('{{ $base_dir }}');
            folder_contents('{{ $base_dir }}');

            // Open the folder when clicked
            $(document).on('click', '.folder-image', function() {
                parent = $('input[name=folder]').val();
                folder_name = $(this).find('.file-name').first().text();
                new_folder = parent + '/' + folder_name;
                folder_contents(new_folder);
            });

            // Go up one folder
            $('#up-folder').on('click', function() {
                splits = $('input[name=folder]').val().split('/');
                splits.pop();
                folder_contents(splits.join('/'));
            });

            // Reload folder and its contents
            $('#reload-folder').on('click', function() {
                current = $('input[name=folder]').val();
                folder_contents(current);
            });

            // Create folder
            $('#folder-submit').click(function(e) {
                parent = $('input[name=folder]').val();
                folder_name = $('input[name=folder_name]').val();
                new_folder = parent + '/' + folder_name;
                $.ajax({
                  type: "POST",
                  url: "{{URL::to('backend/media-manager/create_folder/')}}",
                  data: { dir: new_folder }
                })
                .done(function(data) {
                    folder_contents($('input[name=folder]').val());
                });
            });

            $(document).on('click', '.delete-file', function() {
                doDelete = confirm("Are you sure you want to delete the file?");
                if (!doDelete) return false;
                $.ajax({
                    type: "DELETE",
                    url: "{{URL::to('backend/media-manager/1')}}",
                    data: { file: $(this).data('file') }
                })
                .done(function(data) {
                    folder_contents($('input[name=folder]').val());
                });
            });
        });

        // Get the contents of a folder
        function folder_contents($dir) {
            var pleaseWaitDiv = $('#pleaseWaitDialog');
            pleaseWaitDiv.modal();
            $.ajax({
              type: "POST",
              url: "{{URL::to('backend/media-manager/folder_contents/')}}",
              data: { dir: $dir }
            })
            .done(function(data) {
                $('ul.media-manager').html('');
                $('.image-preview.success').remove();
                $('.image-preview.error').remove();
                for (var i = 0; i < data.dirs.length; i++) {
                    dir = '<li class="folder-image"> <i class="icon-folder-close"></i> <div class="file-name">'+data.dirs[i].match(/[^\/\\]+$/)[0]+'</div> </li>';
                    $('ul.media-manager').append(dir);
                }
                for (var i = 0; i < data.files.length; i++) {
                    file_name = data.files[i].match(/[^\/\\]+$/)[0];
                    @if ($current_user->hasAccess('media-manager.destroy'))
                        delete_file = '<a href="#" class="delete-file" data-file="'+$dir+'/'+file_name+'">Delete</a>';
                    @else
                        delete_file = '';
                    @endif
                    file = '<div class="preview processing image-preview"> <div class="details"> <div class="size file-name">'+file_name+'</div> <div class="options">'+delete_file+'</div><img src="'+window.base_url+'/'+data.files[i]+'" width="64px" alt="" /> </div> </div>';
                    $('ul.media-manager').append(file);
                }
                pleaseWaitDiv.modal('hide');
                $('[name=folder]').val($dir);
            });
        }
    </script>
@stop
