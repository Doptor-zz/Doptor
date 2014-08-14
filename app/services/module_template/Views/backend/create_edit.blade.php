@extends('backend.default._layouts._layout')

@section('styles')
    {{ HTML::style('assets/backend/default/plugins/chosen-bootstrap/chosen/chosen.css') }}
    {{ HTML::style('assets/backend/default/plugins/chosen-bootstrap/chosen/chosen.css') }}
@stop

@section('content')
    <div class="row-fluid">
        <div class="span12">
            <!-- BEGIN FORM widget-->
            <div class="widget box blue tabbable">
                <div class="widget-title">
                    <h4>
                        <span>{{ $title }}</span>
                        &nbsp;
                    </h4>
                </div>
                <div class="widget-body form">
                    <div class="tab-pane active" id="widget_tab1">
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
    {{ HTML::script('assets/backend/default/plugins/chosen-bootstrap/chosen/chosen.jquery.min.js') }}

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
        $('select').chosen();
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
@stop
