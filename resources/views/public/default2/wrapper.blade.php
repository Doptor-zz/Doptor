@section('style')
@stop

@section('content')
    <div class="container">
        <div class="row margin-bottom-40">
            <div class="col-md-12 col-sm-12">
                <iframe src="{!! $menu->link_manual !!}" width="{!! $menu->wrapper_width() !!}" height="{!! $menu->wrapper_height() !!}">
                </iframe>
            </div>
        </div>
    </div>
@stop

@section('scripts')
@stop
