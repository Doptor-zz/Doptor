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
        window.link_type = 'backend';

        // auto-logout after some defined time
        var timer,
            auto_logout_time; // time of inactivity to wait before logging out

        @if ($current_user->auto_logout_time != '' || $current_user->auto_logout_time != 0)
        auto_logout_time = {{ $current_user->auto_logout_time }};
        @else
        auto_logout_time = {{ get_setting('auto_logout_time', 60) }};
        @endif
        if (auto_logout_time == 0) {
            auto_logout_time = 60;
        }

        document.onkeypress = resetTimer;
        document.onmousemove = resetTimer;

        function resetTimer() {
            clearTimeout(timer);
            timer = setTimeout("logout()", 60000*auto_logout_time);
        }

        function logout() {
            window.location.replace(window.base_url + '/logout');
        }

        // Add CSRF protection tokens in ajax request also
        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            }
        });
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
