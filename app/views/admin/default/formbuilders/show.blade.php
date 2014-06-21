@section('content')
    <div class="row-fluid">
        <div class="span12">
            <!-- BEGIN TABLE widget-->
            <div class="widget box light-grey">
                <div class="blue widget-title">
                    <h4><i class="icon-table"></i> {{ $form->name }}</h4>
                </div>
                <div class="widget-body">
                    <div class="control-group">
                        Form Category: {{ $form->category }}
                    </div>
                    <div class="control-group">
                        Form Description: {{ $form->description }}
                    </div>
                    {{ preg_replace("/\/(\n)?\//", '', $form->rendered) }}
                </div>
            </div>
            <!-- END TABLE widget-->
        </div>
    </div>
@stop
