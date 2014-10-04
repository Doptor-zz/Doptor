<script>
    window.base_url = '{{ URL::to('/') }}';
    window.link_type = 'admin';
</script>
{{ HTML::script("assets/admin/default/js/jquery.js") }}
{{ HTML::script("assets/admin/default/js/jquery-ui-1.10.1.custom.min.js") }}
{{ HTML::script("assets/admin/default/js/bootstrap.js") }}
{{ HTML::script("assets/admin/default/js/jquery.sparkline.js") }}
{{ HTML::script("assets/admin/default/js/jquery.metadata.js") }}
{{ HTML::script("assets/admin/default/js/jquery.tablesorter.min.js") }}
{{ HTML::script("assets/admin/default/js/jquery.collapsible.js") }}
{{ HTML::script("assets/admin/default/js/accordion.nav.js") }}
{{ HTML::script("assets/admin/default/js/jquery.gritter.js") }}
{{ HTML::script("assets/admin/default/js/custom.js") }}
{{ HTML::script("assets/admin/default/js/chosen.jquery.js") }}
{{ HTML::script("assets/admin/default/js/respond.min.js") }}
{{ HTML::script("assets/admin/default/js/ios-orientationchange-fix.js") }}
<script>

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

    $(function () {
        $('select').chosen();
    });

    /**=========================
    LEFT NAV ICON ANIMATION
    ==============================**/
    $(function () {
        $(".left-primary-nav a").hover(function () {
            $(this).stop().animate({
                fontSize: "30px"
            }, 200);
        }, function () {
            $(this).stop().animate({
                fontSize: "24px"
            }, 100);
        });
    });
    // Add CSRF protection tokens in ajax request also
    $.ajaxSetup({
        headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
@section('scripts')
    {{-- Here goes the page level scripts and plugins --}}
    {{-- HTML::script("assets/backend/default/scripts/app.js") --}}
    <script>
        jQuery(document).ready(function() {
            // App.init();
            // Handle href data in buttons
            $('button[data-href]').click(function() {
                location.href = $(this).attr('data-href');
            });
            $('.accordion-nav ul').parent().children('a').append('<i class="pull-right icon-circle-arrow-left"></i>');
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
