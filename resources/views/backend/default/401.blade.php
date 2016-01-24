@extends('backend.default._layouts._login')

@section('styles')
    <!-- BEGIN PAGE LEVEL STYLES -->
    <link rel="stylesheet" href="{!! URL::to('assets/backend/default/css/pages/error.css') !!}" />
    <!-- END PAGE LEVEL STYLES -->
@stop

@section('content')
    <div class="row-fluid">
        <div class="span12">
            <div class="row-fluid page-404">
                <div class="span5 number">
                    401
                </div>
                <div class="span7 details">
                    <h3>{!! trans('errors.401.message') !!}</h3>
                    <p>
                        {!! trans('errors.401.sub_message') !!}
                    </p>
                </div>
            </div>
        </div>
    </div>
@stop
