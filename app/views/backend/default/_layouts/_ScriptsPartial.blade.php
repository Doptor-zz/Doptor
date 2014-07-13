<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<script src="{{ URL::to("assets/backend/default/plugins/jquery-1.8.3.min.js") }}" type="text/javascript"></script>
<!-- IMPORTANT! Load jquery-ui-1.10.1.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
<script src="{{ URL::to("assets/backend/default/plugins/jquery-ui/jquery-ui-1.10.1.custom.min.js") }}" type="text/javascript"></script>
<script src="{{ URL::to("assets/backend/default/plugins/bootstrap/js/bootstrap.min.js") }}" type="text/javascript"></script>
<!--[if lt IE 9]>
<script src="{{ URL::to("assets/backend/default/plugins/excanvas.js") }}"></script>
<script src="{{ URL::to("assets/backend/default/plugins/respond.js") }}"></script>
<![endif]-->
<script src="{{ URL::to("assets/backend/default/plugins/breakpoints/breakpoints.js") }}" type="text/javascript"></script>
<!-- IMPORTANT! jquery.slimscroll.min.js depends on jquery-ui-1.10.1.custom.min.js -->
<script src="{{ URL::to("assets/backend/default/plugins/jquery-slimscroll/jquery.slimscroll.min.js") }}" type="text/javascript"></script>
<script src="{{ URL::to("assets/backend/default/plugins/jquery.blockui.js") }}" type="text/javascript"></script>
<script src="{{ URL::to("assets/backend/default/plugins/jquery.cookie.js") }}" type="text/javascript"></script>
<script src="{{ URL::to("assets/backend/default/plugins/uniform/jquery.uniform.min.js") }}" type="text/javascript" ></script>
<!-- END CORE PLUGINS -->
@if(ends_with(Request::url(), 'create') || ends_with(Request::url(), 'edit'))
    <script type="text/javascript" src="{{ URL::to('assets/backend/default/plugins/chosen-bootstrap/chosen/chosen.jquery.min.js') }}"></script>
@endif
@section('scripts')
    {{-- Here goes the page level scripts and plugins --}}
    <script>
        window.base_url = '{{ URL::to('/') }}';
    </script>
    <script src="{{ URL::to("assets/backend/default/scripts/app.js") }}"></script>
    <script>
        jQuery(document).ready(function() {
            App.init();
        });

        $(function () {
            $('.go-top').click(function () {
                $('body,html').animate({
                    scrollTop: 0
                }, 500);
                return false;
            });
        });

        function deleteRecord(th, type) {
            if (type === undefined) type = 'record';

            doDelete = confirm("Are you sure you want to delete the " + type + "?");
            if (!doDelete) {
                // If cancel is selected, do nothing
                return false;
            }
        }
    </script>
@show
