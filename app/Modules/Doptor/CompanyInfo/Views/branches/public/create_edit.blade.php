@section('content')

<section class="indent">
    <div class="container">
        <div class="accordion-wrapper grid_12">

            @if (Session::has('error_message'))
                <div class="grid_8">
                    <div class="alert alert-error nomargin">
                        Error! {!! Session::get('error_message') !!}
                    </div>
                </div>
                <div class="clearfix"></div>
            @endif
            @if (Session::has('success_message'))
                <div class="grid_8">
                    <div class="alert alert-success nomargin">
                        Success! {!! Session::get('success_message') !!}
                    </div>
                </div>
                <div class="clearfix"></div>
            @endif

            <h1>{!! $title !!}</h1>

            <div class="tabs full-w">

                @include("{$module_alias}::branches._common.form_create_edit_company")

            </div>
        </div>
    </div>
</section>

@stop
