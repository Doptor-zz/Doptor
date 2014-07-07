<!-- BEGIN PAGE LEVEL PLUGINS -->
{{ HTML::script('assets/backend/default/plugins/bootstrap-wizard/jquery.bootstrap.wizard.min.js') }}
{{ HTML::script('assets/backend/default/plugins/jquery-validation/dist/jquery.validate.min.js') }}
{{ HTML::script('assets/backend/default/plugins/jquery-validation/dist/additional-methods.min.js') }}
<!-- END PAGE LEVEL PLUGINS -->
@parent
{{ HTML::script('assets/backend/default/scripts/form-wizard.js') }}
{{ HTML::script('assets/backend/default/scripts/form-validation.js') }}
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

        $('#all_forms_chzn').css('width', '300px');
        $('.chzn-drop').css('width', '300px');
        $('#all_forms_chzn').find('input').css('width', '265px');

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
        var InputsWrapper   = $("#InputsWrapper"); //Input boxes wrapper ID
        var AddButton       = $("#AddMore"); //Add button ID

    @if (!isset($module))
            var x = InputsWrapper.length; //initial text box count
        var FieldCount = 1; //to keep track of text box added
    @else
        var x = {{ count($selected_forms) }};
        var FieldCount = {{ count($selected_forms) }};
    @endif

    // on add input button click
    $(AddButton).click(function (e) {
        FieldCount++; //text box added increment
        //add input box
        $(InputsWrapper).append('<p>{{ Form::select("form-form_count", BuiltForm::all_forms(), Input::old("form-form_count"), array("class"=>"chosen")) }}<a href="#" class="removeclass">&nbsp;&nbsp;<i class="icon-remove"></i></a></p>');
        // Dynamically change the select name
        $('select[name="form-form_count"]').attr('name', function(){
            return 'form-' + FieldCount;
        });
        // Don't show the form(s) already selected
        for (var i = 1; i <= FieldCount; i++) {
            selected_value = $('select[name="form-' + i +'"]').val();
            if (selected_value != 0) {
                $('select[name="form-' + FieldCount +'"] option[value='+selected_value+']').remove();
            }
        };
        $('input[name=form-count]').val(FieldCount);
        x++; //text box increment
        $(".chosen").chosen();
        return false;
    });

    $("body").on("click",".removeclass", function(e) { //user click on remove text
        if( x > 1 ) {
            $(this).parent('p').remove(); //remove text box
            x--; //decrement textbox
            repopulateDropdowns();
        }
        return false;
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
            url: '{{ URL::to("backend/module-builder/form-fields/") }}/' + form_id
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
            selected_form.parent().find('.form-fields').html(selects);
        });
    }

    function getDropdowns(selected_form) {
        // Get all the dropdown fields that are present in a form
        var form_id = selected_form.val();
        var form_name = selected_form.find('option:selected').text();

        $('#form-dropdowns').show();
        $.ajax({
            url: '{{ URL::to("backend/module-builder/form-dropdowns/") }}/' + form_id
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

            $('#form-dropdowns').append(selects);
        });
    }

    function repopulateDropdowns() {
        // Remove all already added form dropdown sources
        $('.added-form').remove();
        // Show dropdown source selection for all selected form
        $('.module-form').each(function () {
            getDropdowns($(this));
        });
    }
</script>
