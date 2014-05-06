@extends('backend.default._layouts._layout')

@section('styles')
    <!-- BEGIN PAGE LEVEL STYLES -->
    <link rel="stylesheet" href="{{ URL::to('assets/backend/default/css/pages/error.css') }}" />
    <!-- END PAGE LEVEL STYLES -->
@stop

@section('content')
    <div class="row-fluid">
        <div class="span12">
            <div class="row-fluid page-404">
                <div class="span5 number">
                    404
                </div>
                <div class="span7 details">
                    <h3>Opps, You're lost.</h3>
                    <p>
                        We can not find the page you're looking for.<br />
                        Is there a typo in the url?
                    </p>
                </div>
            </div>
        </div>
    </div>
@stop
