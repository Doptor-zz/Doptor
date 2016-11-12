@if (!isset($media_entry))
    {!! HTML::script('assets/backend/default/plugins/dropzone/dropzone.js') !!}
@endif
@parent
<script>
    jQuery(document).ready(function() {
        $('.default.message').remove();

        $('input[name=folder]').val('{!! $base_dir !!}');
        folder_contents('{!! $base_dir !!}');

        // Open the folder when clicked
        $('.folder-image').live('click', function() {
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
              url: "{!!URL::to('backend/media-manager/create_folder/')!!}",
              data: { dir: new_folder }
            })
            .done(function(data) {
                folder_contents($('input[name=folder]').val());
            });
        });

        $('.delete-file').live('click', function() {
            doDelete = confirm("Are you sure you want to delete the file?");
            if (!doDelete) return false;
            $.ajax({
                type: "DELETE",
                url: "{!!URL::to('backend/media-manager/1')!!}",
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
          url: "{!!URL::to('backend/media-manager/folder_contents/')!!}",
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
                    delete_file = '<a href="#" class="delete-file" data-file="'+$dir+'/'+file_name+'">{!! trans('options.delete') !!}</a>';
                @else
                    delete_file = '';
                @endif
                file = '<div class="preview processing image-preview"> <div class="details"> <div class="size file-name">'+file_name+'</div> <div class="options">'+delete_file+'</div><img src="'+data.files[i]+'" width="64px" alt="" /> </div> </div>';
                $('ul.media-manager').append(file);
            }
            pleaseWaitDiv.modal('hide');
            $('[name=folder]').val($dir);
        });
    }
</script>
