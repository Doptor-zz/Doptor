@extends('backend.default._layouts._layout')

@section('content')
    <div class="row-fluid">
        <div class="span12">
            <!-- BEGIN TABLE widget-->
            <div class="widget box light-grey">
                <div class="widget-title">
                    <h4><i class="icon-table"></i> {{ $entry->name }}</h4>
                </div>
                <div class="widget-body">
                    <div class="control-group">
                    </div>
                    <div class="control-group">
                    </div>
                </div>
            </div>
            <!-- END TABLE widget-->
        </div>
    </div>
@stop
