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
                    <form class="form-horizontal">
                        @for ($i=0; $i<count($fields); $i++)
                            <div class="control-group">
                                <label class="control-label">{{ $field_names[$i] }}</label>
                                <div class="controls">
                                    {{ $entry->{$fields[$i]} }}
                                </div>
                            </div>
                        @endfor
                        <div class="control-group">
                            <label class="control-label">Created At</label>
                            <div class="controls">
                                {{ $entry->created_at }}
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Updated At</label>
                            <div class="controls">
                                {{ $entry->updated_at }}
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- END TABLE widget-->
        </div>
    </div>
@stop
