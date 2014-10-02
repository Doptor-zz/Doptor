@section('styles')
    <!-- BEGIN PAGE LEVEL STYLES -->
    <link rel="stylesheet" href="{{ URL::to('assets/backend/default/plugins/jquery-ui/jquery-ui.css') }}" />
    <!-- elFinder CSS (REQUIRED) -->
    <link rel="stylesheet" type="text/css" href="{{ URL::to('assets/backend/default/plugins/elfinder/css/elfinder.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ URL::to('assets/backend/default/plugins/elfinder/css/theme.css')}}">
    <!-- END PAGE LEVEL STYLES -->
@stop

@section('content')
    <div class="row-fluid">
        <div class="span12">
            <!-- BEGIN EXAMPLE TABLE widget-->
            <div class="widget light-gray box">
                <div class="blue widget-title">
                    <h4><i class="icon-th-list"></i>{{ trans('cms.media_manager') }}</h4>
                    <div class="tools">
                        <a href="javascript:;" class="collapse"></a>
                        <a href="#widget-config" data-toggle="modal" class="config"></a>
                        <a href="javascript:;" class="reload"></a>
                        <a href="javascript:;" class="remove"></a>
                    </div>
                </div>
                <div class="widget-body">
                    <div id="elfinder">

                    </div>
                </div>
            </div>
            <!-- END EXAMPLE TABLE widget-->
        </div>
    </div>
@stop

@section('scripts')
    <!-- elFinder JS (REQUIRED) -->
    <script src="{{ URL::to('assets/backend/default/plugins/elfinder/js/elfinder.min.js')}}"></script>

    <!-- elFinder initialization (REQUIRED) -->
    <script type="text/javascript" charset="utf-8">
        $(document).ready(function() {
            $('#elfinder').elfinder({
                url : '{{ URL::action('Barryvdh\Elfinder\ElfinderController@showConnector') }}'
            });
            if ($('.elfinder-toolbar div').length != 0) {
                $('.elfinder-toolbar div').last().remove();
            }
        });
    </script>
    <script>
        // $(function() {
        //     $('#selected_ids').val('');

        //     $('.select_all').change(function() {
        //         var checkboxes = $('#sample_1 tbody').find(':checkbox');

        //         if ($(this).is(':checked')) {
        //             checkboxes.attr('checked', 'checked');
        //             restore_uniformity();
        //         } else {
        //             checkboxes.removeAttr('checked');
        //             restore_uniformity();
        //         }
        //     });
        // });
        // function deleteRecords(th, type) {
        //     if (type === undefined) type = 'record';

        //     doDelete = confirm("Are you sure you want to delete the selected " + type + "s ?");
        //     if (!doDelete) {
        //         // If cancel is selected, do nothing
        //         return false;
        //     }

        //     $('#sample_1 tbody').find('input:checked').each(function() {
        //         value = $('#selected_ids').val();
        //         $('#selected_ids').val(value + ' ' + this.name);
        //     });
        // }
        // function restore_uniformity() {
        //     $.uniform.restore("input[type=checkbox]");
        //     $('input[type=checkbox]').uniform();
        // }
    </script>
@stop
