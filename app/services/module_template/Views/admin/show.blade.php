@section('content')
    <div class="row-fluid">
        <div class="span12">
            <!-- BEGIN TABLE widget-->
            <div class="widget box light-grey">
                <div class="blue widget-title">
                    <h4><i class="icon-table"></i> {{ $title }}</h4>
                </div>
                <div class="widget-body tab-widget">
                    <div class="form-horizontal tab-content">
                        @for ($i = 0; $i < count($field_names); $i++)
                            <div class="control-group">
                                <label class="control-label">
                                    {{ Str::title($field_names[$i]) }}
                                </label>
                                <div class="controls">
                                    {{ $entry->{$fields[$i]} }}
                                </div>
                            </div>
                        @endfor
                    </div>
                </div>
            </div>
            <!-- END TABLE widget-->
        </div>
    </div>
@stop
