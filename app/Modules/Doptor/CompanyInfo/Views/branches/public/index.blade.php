@section('content')

<section class="indent">
    <div class="container">
        <div class="accordion-wrapper grid_12">

            <h1>{!! $title !!}</h1>

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

            <div class="tabs full-w">
                <div class="pull-right">
                    <a href="{!! URL::to('modules/'.$module_link.'/create/'.'27') !!}" class="pill pill-style1">
                        <span class="pill-inner">Add new</span>
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>

@stop
