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
                <ul class="tab-menu">
                    @foreach ($forms as $i => $form)
                        <li class="{!! $i==0 ? 'active' : '' !!}">
                            <a href="#tab_{!! $i !!}">
                                {!! $form['form_name'] !!}
                                <i class="l-tab-shad"></i>
                                <i class="r-tab-shad"></i>
                            </a>
                        </li>
                    @endforeach
                </ul>
                <div class="clear"></div>
                <div class="tab-wrapper">
                    @foreach ($forms as $i => $form)
                        <div class="tab {!! $i==0 ? 'active' : '' !!}" id="tab_{!! $i !!}">
                            <div class="pull-right">
                                <a href="{!! URL::to('modules/'.$module_link.'/create/'.$form['form_id']) !!}" class="pill pill-style1">
                                    <span class="pill-inner">Add new</span>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</section>

@stop
