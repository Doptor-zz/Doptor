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
                ***FORM_CONTENT***

            </div>
        </div>
    </div>
</section>

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

    ***EXTRA_CODE***
@stop
