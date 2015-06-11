@section('content')
    <div class="row-fluid">
        <div class="span12">
            <!-- BEGIN FORM widget-->
            <div class="widget box tabbable">
                <div class="blue widget-title">
                    <h4>
                        <span>{{ $title }}</span>
                        &nbsp;
                    </h4>
                </div>
                <div class="widget-body form">
                    <div class="tab-widget">
                        <!-- BEGIN FORM-->
                        @include("{$module_alias}::form_{$form['form_id']}")
                        <!-- END FORM-->
                    </div>
                </div>
            </div>
            <!-- END FORM widget-->
        </div>
    </div>
@stop

@section('scripts')
    @parent

    <script>
        // Populate dropdown fields based on the selected sources
        jQuery(document).ready(function() {
            var sources = {{ json_encode($sources) }};

            for (var field_name in sources) {
                if(sources.hasOwnProperty(field_name)){
                    var options = '';
                    for (var option in sources[field_name]) {
                        options += '<option value="'+option+'">';
                        options += option;
                        options += '</option>';
                    }
                    $('[name='+field_name+']').html(options);

                    // Reapply the chosen plugin
                    $('[name='+field_name+']').siblings().remove();
                    $('[name='+field_name+']').show().removeClass('chzn-done');
                    $('[name='+field_name+']').chosen();
                }
            }
        });
    </script>

    @if (isset($entry))
        <script>
            jQuery(document).ready(function() {
                // While editing fields populate with its data
                @foreach ($form['fields'] as $field)
                    <?php
                        $entry->{$field} = preg_replace('~[\r\n]+~', ' ', $entry->{$field});
                        $entry->{$field} = str_replace('\n', " ", $entry->{$field}) ;
                    ?>
                    field = $('[name={{ $field }}]');
                    if (field.is('input[type=radio]')) {
                        field.filter('[value="{{ $entry->{$field} }}"]').attr('checked', true);
                    } else {
                        field.val('{{ $entry->{$field} }}');
                    }
                @endforeach
            });
        </script>
    @endif

    <script>
        $(function() {
            // Repopulate input fields with old data, in case of validation error(s)
            var old_inputs = {{ json_encode(Input::old()) }};
            delete(old_inputs._token);
            delete(old_inputs.input_name);
            delete(old_inputs.captcha);

            $('input, textarea, select').each(function() {
                var input_name = $(this).attr('name');
                if (old_inputs[input_name] !== undefined) {
                    $(this).val(old_inputs[input_name]);
                }
            });
        }());
    </script>
@stop
