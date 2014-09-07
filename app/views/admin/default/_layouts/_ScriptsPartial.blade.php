<script>
    window.base_url = '{{ URL::to('/') }}';
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
{{ HTML::script("assets/admin/default/js/respond.min.js") }}
{{ HTML::script("assets/admin/default/js/ios-orientationchange-fix.js") }}
<script>
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
