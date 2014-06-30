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

        $('.module-form').change(function() {
            getDropdowns($(this));
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
        var x = {{ count($forms) }};
    var FieldCount = {{ count($forms) }};
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
        }
        return false;
    });
    }

    function getDropdowns(selected_form) {
        var form_id = selected_form.val();
        $.ajax({
            url: '{{ URL::to("backend/module-builder/form-dropdowns/") }}/' + form_id
        }).done(function(form_fields) {
            var selects = '';
            for (var field in form_fields) {
                if (form_fields.hasOwnProperty(field)) {
                    selects += '<div class="controls line">';
                    selects += '<label>'+form_fields[field]+'</label>';
                    selects += '<select name="'+field+'">';
                    selects += '<option value=""></option>';
                    selects += '</select>';
                    selects += '</div>';
                }
            }

            $('#form-dropdowns').append(selects);
        });
    }
</script>
