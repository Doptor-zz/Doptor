<!-- BEGIN PAGE LEVEL SCRIPTS -->
@parent
<script>
    var this_form;

    if ($('#main_tab').length >0) {
        this_form = $("#main_tab");
    } else {
        this_form = $("#tab_companies, #tab_branches");
    }

    function deleteRecords(th, type) {
        if (type === undefined) type = 'record';

        doDelete = confirm("Are you sure you want to delete the selected " + type + "s ?");
        if (!doDelete) {
            // If cancel is selected, do nothing
            return false;
        }

        this_form.find('input:checked').each(function() {
            var value = this_form.find('.selected_ids').val();
            this_form.find('.selected_ids').val(value + ' ' + this.name);
        });
    }
    $(function() {
        $('.selected_ids').val('');

        this_form.find('.select_all').change(function() {
            var checkboxes = this_form.find(':checkbox');

            if ($(this).is(':checked')) {
                checkboxes.attr('checked', 'checked');
                restore_uniformity();
            } else {
                checkboxes.removeAttr('checked');
                restore_uniformity();
            }
        });
    });
    function restore_uniformity() {
        $.uniform.restore("input[type=checkbox]");
        $('input[type=checkbox]').uniform();
    }
</script>
<!-- END PAGE LEVEL SCRIPTS -->
