<!-- BEGIN PAGE LEVEL SCRIPTS -->
{!! HTML::script('assets/backend/default/plugins/bootstrap/js/bootstrap-modalmanager.js') !!}
@if ($link_type == 'backend')
    {!! HTML::script("assets/backend/default/scripts/media-selection.js") !!}
@else
    {!! HTML::script("assets/admin/default/js/media-selection.js") !!}
@endif

@parent

<script>
    MediaSelection.init('logo');

    $(document).on('click', '.person-in-charge .btn', function() {
        var this_incharge = $(this).closest('.person-in-charge');

        if ($(this).hasClass('btn-primary')) {
            // insert form after the last form
            var clone = this_incharge.clone();
            clone.find(':input')
            .val('')
            .removeAttr('checked')
            .removeAttr('selected');
            clone.insertAfter(this_incharge.last());
        } else if ($(this).hasClass('btn-danger')) {
            // remove this form
            if ($('.person-in-charge').length > 1) {
                this_incharge.remove();
            }
        }
    });
</script>
