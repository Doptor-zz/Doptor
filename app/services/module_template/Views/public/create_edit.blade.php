@section('content')

<section class="indent">
    <div class="container">
        <div class="accordion-wrapper grid_12">

            @if (Session::has('error_message'))
                <div class="grid_8">
                    <div class="alert alert-error nomargin">
                        Error! {{ Session::get('error_message') }}
                    </div>
                </div>
                <div class="clearfix"></div>
            @endif
            @if (Session::has('success_message'))
                <div class="grid_8">
                    <div class="alert alert-success nomargin">
                        Success! {{ Session::get('success_message') }}
                    </div>
                </div>
                <div class="clearfix"></div>
            @endif

            <h1>{{ $title }}</h1>

            <div class="tabs full-w">

                @include("{$module_alias}::form_{$form['form_id']}")

            </div>
        </div>
    </div>
</section>

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
                        restore_uniformity();
                    } else {
                        field.val('{{ $entry->{$field} }}');
                    }
                @endforeach
            });
            function restore_uniformity() {
                $.uniform.restore("input[type=radio]");
                $('input[type=radio]').uniform();
            }
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
