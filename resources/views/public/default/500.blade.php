@extends('public.default._layouts._layout')

@section('content')
    <section class="indent">

        <!-- BEGIN 500 WRAPPER -->
        <div id="error404" class="container">
            <div class="grid_7 prefix_1">
                <hgroup>
                    <h1>{!! trans('public.500_message') !!}</h1>
                </hgroup>

            </div>
        </div>
        <!-- END 500 WRAPPER -->

    </section>
@stop
