@extends('admin.default._layouts._layout')

@section('content')
    <div class="row">
        <div class="span4 offset2">
            <div class="error-code">
                404
                <div>
                </div>
            </div>
        </div>
        <div class="span4">
            <div class="error-message">
                <h4>Oops! Page not found... </h4>
                <p>
                     We are sorry the page you are trying to reach does not exist :(
                </p>
            </div>
        </div>
    </div>
@stop
