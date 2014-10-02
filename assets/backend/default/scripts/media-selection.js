var MediaSelection = function () {
    return {

        init: function(field_name) {
            var insert_modal = $('#ajax-insert-modal');
            var calling_div;

            $('.insert-media').on('click', function(event) {
                console.log('clicked');
                calling_div = event.target.id;
                $('body').modalmanager('loading');

                setTimeout(function(){
                    var media_manager_link = window.base_url+'/'+window.link_type+'/media-manager';
                    insert_modal.load(media_manager_link, '', function(){
                        insert_modal.modal();
                    });
                }, 1000);
            });

            $('.preview.processing img').live('click', function(event) {
                var folder_name = $('input[name=folder]').val();
                if ($(this).parent().find('.file-name').length) {
                    var image = $(this).parent().find('.file-name').first().text();
                } else {
                    var image = $(this).parent().find('.filename').first().text();
                }

                var image_path = folder_name.trimLeft()+'/'+image;

                if (calling_div == 'insert-main-image') {

                    $('input[name='+field_name+']').val(image_path);
                    // Display the name of the current selected file
                    $('#'+calling_div).parent().find('.file-name').text(image_path);

                } else {
                    var image_url = window.base_url+'/'+folder_name+'/'+image;

                    // Insert the selected image to the CKEDITOR text input
                    var oEditor = CKEDITOR.instances.content;
                    oEditor.insertHtml('<img src="'+image_url+'">');

                }
                insert_modal.modal('hide');
            });
        }
    };
}();
