<!-- BEGIN PAGE LEVEL PLUGINS -->
{!! HTML::script('assets/backend/default/plugins/bootstrap-wizard/jquery.bootstrap.wizard.min.js') !!}
{!! HTML::script('assets/backend/default/plugins/jquery-validation/dist/jquery.validate.min.js') !!}
{!! HTML::script('assets/backend/default/plugins/jquery-validation/dist/additional-methods.min.js') !!}
<!-- END PAGE LEVEL PLUGINS -->
@parent
{!! HTML::script('assets/backend/default/scripts/form-wizard.js') !!}
{!! HTML::script('assets/backend/default/scripts/form-validation.js') !!}
<script>
    jQuery(document).ready(function () {
        FormWizard.init();

        $("#module-builder").validate({
            rules: {
                name: {required: true, minlength: 3 },
                version: {required: true },
                author: {required: true, minlength: 3 },
                website: {required: true, minlength: 3, url: true }
            }
        });

        // Populate the overview of the selections in the last step
        $('.button-next').click(function() {
            $('#name').html($('input[name=name]').val());
            $('#version').html($('input[name=version]').val());
            $('#author').html($('input[name=author]').val());
            $('#website').html($('input[name=website]').val());
            $('#description').html($('textarea[name=description]').val());
        });
    });

    $(document).ready(function() {
        multipleForms();

        $('.module-form').each(function() {
            getDropdowns($(this));
            getSelectedFormFields($(this));
        });

        $('.module-form').change(function() {
            repopulateDropdowns();
        });

        $(document).on('change', '.selected-form', function() {
            getFormFields($(this));
        });
    });

    function multipleForms() {
        // Things to do to dynamically add/remove as much forms as needed
        $(document).on('click', '.form-list .btn', function(e) {
            e.preventDefault();
            var this_list = $(this).closest('.form-list');

            if ($(this).hasClass('btn-add')) {
                $(".chosen").chosen('destroy');

                var clone = this_list.clone();

                clone.removeAttr('selected');

                // insert form after the last form
                clone.insertAfter(this_list.last());

                $(".chosen").chosen();
            } else if ($(this).hasClass('btn-remove')) {
                // remove this form
                if ($('.form-list').length > 1) {
                    this_list.remove();
                }
            }
        });
    }

    function getFormFields(selected_form) {
        var ids = selected_form.val().split('-');
        var module_id = ids[0];
        var form_id = ids[1];
        window.form = selected_form;

        if (!selected_form.parent().find('.form-fields').length) {
            selected_form.parent().append('<div class="form-fields inline"></div>');
        }

        if (form_id == 0 || form_id == undefined) {
            // If same as in form is selected, remove field options
            selected_form.parent().find('.loading').html('');
            selected_form.parent().find('.form-fields').html('');
            return;
        }

        selected_form.parent()
            .find('.form-fields')
            .html('<div class="loading inline">Loading...</div>');

        $.ajax({
            url: '{!! URL::to("backend/module-builder/form-fields/") !!}/' + form_id + '/' + module_id
        }).done(function(form_fields) {
            var form_name = selected_form.attr('name').replace('moduleform-', '');
            var selects = '&nbsp;&nbsp;&nbsp;&nbsp;<label class="inline">Form fields:</label>';
            selects += '<select name="formfield-'+form_name+'">';
            for (var field in form_fields) {
                if (form_fields.hasOwnProperty(field)) {
                    selects += '<option value="'+field+'">'+form_fields[field]+'</option>';
                }
            }
            selects += '</select>';

            selected_form.parent().find('.loading').html('');
            $(".chosen").chosen('destroy');
            selected_form.parent().find('.form-fields').html(selects);
            $(".chosen").chosen();
        });
    }

    function getSelectedFormFields(selected_form) {
        // Populate the list of form fields for the selected form
        // to select which fields to show
        var form_id = selected_form.val();

        if (form_id == 0) {
            return false;
        }

        var parent_list = selected_form.closest('.form-list'),
            this_form_fields = parent_list.find('.form-fields');

        this_form_fields.attr('name', 'form-fields-' + form_id + '[]');

        $.ajax({
            url: '{!! URL::to("backend/module-builder/form-fields/") !!}/' + form_id
        }).done(function(form_fields) {
            var options = '';
            for (var field in form_fields) {
                if (form_fields.hasOwnProperty(field)) {
                    options += '<option value="'+field+'" selected>'+form_fields[field]+'</option>';
                }
            }
            $(".chosen").chosen('destroy');
            this_form_fields.html(options);
            $(".chosen").chosen();
        });
    }

    function getDropdowns(selected_form) {
        // Get all the dropdown fields that are present in a form
        if (selected_form == 0) {
            return false;
        }
        var form_id = selected_form.val();
        var form_name = selected_form.find('option:selected').text();

        $('#form-dropdowns').show();
        $.ajax({
            url: '{!! URL::to("backend/module-builder/form-dropdowns/") !!}/' + form_id
        }).done(function(form_fields) {
            var selects = '';
            for (var field in form_fields) {
                if (form_fields.hasOwnProperty(field)) {
                    selects += '<div class="controls line added-form form-'+form_id+'">';
                    selects += '<label><b>Source for dropdown field "'+form_fields[field]+'" in form "'+form_name+'":</b> </label>';
                    selects += '<select name="moduleform-'+field+'" class="selected-form">';
                    selects += $('#dropdown-options').html();
                    selects += '</select>';
                    selects += '</div>';
                }
            }

            $(".chosen").chosen('destroy');
            $('#form-dropdowns').append(selects);
            $(".chosen").chosen();
        });
    }

    function repopulateDropdowns() {
        // Remove all already added form dropdown sources
        $('.added-form').remove();
        // Show dropdown source selection for all selected form
        $('.module-form').each(function () {
            getDropdowns($(this));
            getSelectedFormFields($(this));
        });
    }
</script>
