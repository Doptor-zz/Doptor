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
                        ***FORM_CONTENT***
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

    @if (isset($entry))
        <script>
           jQuery(document).ready(function() {
                // While editing fields populate with its data
                @foreach ($fields as $field)
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

    ***EXTRA_CODE***
@stop
