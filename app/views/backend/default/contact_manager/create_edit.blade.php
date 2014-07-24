@section('styles')
    {{ HTML::style('assets/backend/default/plugins/bootstrap/css/bootstrap-modal.css') }}
    {{ HTML::style('assets/backend/default/plugins/chosen-bootstrap/chosen/chosen.css') }}
    {{ HTML::style('assets/backend/default/plugins/chosen-bootstrap/chosen/chosen.css') }}
@stop

@section('content')
    <div class="row-fluid">
        <div class="span12">
            <!-- BEGIN FORM widget-->
            <div class="widget box blue tabbable">
                <div class="widget-title">
                    <h4>
                        <span>{{ $title }}</span>
                        &nbsp;
                    </h4>
                </div>
                <div class="widget-body form">
                    <div class="tab-pane active" id="widget_tab1">
                        @if ($errors->has())
                             <div class="alert alert-error hide" style="display: block;">
                               <button data-dismiss="alert" class="close">×</button>
                               You have some form errors. Please check below.
                            </div>
                        @endif
                        <!-- BEGIN FORM-->
                        @include("contact_manager::form_{$form['form_id']}")
                        <!-- END FORM-->
                    </div>
                </div>
            </div>
            <!-- END FORM widget-->
        </div>
    </div>
@stop

@section('scripts')
    {{ HTML::script('assets/backend/default/plugins/bootstrap/js/bootstrap-modalmanager.js') }}
    {{ HTML::script('assets/backend/default/plugins/chosen-bootstrap/chosen/chosen.jquery.min.js') }}
    {{ HTML::script("assets/backend/default/scripts/media-selection.js") }}
    <script type="text/javascript" src='http://maps.google.com/maps/api/js?sensor=false&libraries=places'></script>
    {{ HTML::script("assets/backend/default/plugins/jquery.geolocation.edit.min.js") }}

    @parent

    <script>
        // Populate dropdown fields based on the selected sources
        jQuery(document).ready(function() {
            $('select').chosen();
            MediaSelection.init('image');

            // init the map, the first time the modal is shown
            var stillPresent = false;
            $('#map-selection').on('shown.bs.modal', function (e) {
                if(stillPresent == false){
                    $("#location-picker").geolocate({
                        lat: "#map-lat",
                        lng: "#map-lon",
                        address: ["#map-address"]
                    });

                    $("#save-changes").on('click', function() {
                        latitude = $('#map-lat').val();
                        longitude = $('#map-lon').val();
                        $('#location-lat').val(latitude);
                        $('#location-lon').val(longitude);
                        $('#location-coordinates').html(latitude+', '+longitude);
                        $('#map-selection').modal('hide');
                    });

                    stillPresent = true;
                }
            });
        });
    </script>

@stop
