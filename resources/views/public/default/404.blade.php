@extends('public.default._layouts._layout')

@section('content')
    <section class="indent">

        <!-- BEGIN 404 WRAPPER -->
        <div id="error404" class="container">
            <div class="error404-num hide-text grid_4">
                404
            </div>
            <div class="grid_7 prefix_1">
                <hgroup>
                    <h2>{!! trans('public.404_message') !!}</h2>
                </hgroup>

            </div>
        </div>
        <!-- END 404 WRAPPER -->

    </section>
@stop
