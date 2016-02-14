@extends("public.$current_theme._layouts._layout")

@section('content')
    <div class="container">
        <!-- BEGIN SIDEBAR & CONTENT -->
        <div class="row margin-bottom-40">
            <!-- BEGIN CONTENT -->
            <div class="col-md-12 col-sm-12">
                <div class="content-page page-404">
                    <div class="number">
                        404
                    </div>
                    <div class="details">
                        <h3>{!! trans('public.404_message') !!}</h3>
                    </div>
                </div>
            </div>
            <!-- END CONTENT -->
        </div>
        <!-- END SIDEBAR & CONTENT -->
    </div>
@stop
