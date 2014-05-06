@section('style')
@stop

@section('content')
    <section class="indent">
        <div class="container">
            <div class="grid_12">
                <iframe src="{{ $menu->link_manual }}" width="{{ $menu->wrapper_width() }}" height="{{ $menu->wrapper_height() }}">
                </iframe>
            </div>
        </div>
    </section>
@stop

@section('scripts')
@stop
