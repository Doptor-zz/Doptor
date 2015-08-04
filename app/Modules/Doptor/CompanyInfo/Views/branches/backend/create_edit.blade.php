@section('styles')
    {!! HTML::style('assets/backend/default/plugins/chosen-bootstrap/chosen/chosen.css') !!}

    <style>
        .form-group {
            border: 1px solid #d3d3d3;
            border-radius: 5px;
            padding: 20px 5px 5px 5px;
            margin-left: 0 !important;
            margin-right: 10px !important;
            margin-bottom: 10px !important;
        }
    </style>
@stop

@section('content')
    <div class="row-fluid">
        <div class="span12">
            <!-- BEGIN FORM widget-->
            <div class="widget box blue tabbable">
                <div class="widget-title">
                    <h4>
                        <span>{!! $title !!}</span>
                        &nbsp;
                    </h4>
                </div>
                <div class="widget-body form">
                    <div class="tab-pane active" id="widget_tab1">
                        <!-- BEGIN FORM-->
                        @include("{$module_alias}::branches._common.form_create_edit_company")
                        <!-- END FORM-->
                    </div>
                </div>
            </div>
            <!-- END FORM widget-->
        </div>
    </div>
@stop

@section('scripts')
    {!! HTML::script('assets/backend/default/plugins/chosen-bootstrap/chosen/chosen.jquery.min.js') !!}

    @parent

    @include("{$module_alias}::companies._common.form_scripts")
@stop
