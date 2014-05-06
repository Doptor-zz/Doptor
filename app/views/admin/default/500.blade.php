@extends('admin.default._layouts._layout')


@section('content')
    <div class="row">
        <div class="span4 offset2">
            <div class="error-code">
                500
                <div>
                </div>
            </div>
        </div>
        <div class="span4">
            <div class="error-message">
                <h4>Opps, Something went wrong.</h4>
                <p>
                     We are fixing it!<br />
                    Please come back in a while.<br />
                </p>
            </div>
        </div>
    </div>
@stop
