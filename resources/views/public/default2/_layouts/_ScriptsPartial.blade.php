<!-- BEGIN CORE PLUGINS (REQUIRED FOR ALL PAGES) -->
<script>
    var base_url = '{!! url() !!}';
</script>
<!--[if lt IE 9]>
{!!HTML::script("assets/public/$current_theme/plugins/respond.min.js")!!}
<![endif]-->
{!!HTML::script("assets/public/$current_theme/plugins/jquery.min.js")!!}
{!!HTML::script("assets/public/$current_theme/plugins/jquery-migrate.min.js")!!}
{!!HTML::script("assets/public/$current_theme/plugins/bootstrap/js/bootstrap.min.js")!!}
{!!HTML::script("assets/public/$current_theme/scripts/back-to-top.js")!!}
<!-- END CORE PLUGINS -->

{!!HTML::script("assets/public/$current_theme/scripts/layout.js")!!}
<script type="text/javascript">
    jQuery(document).ready(function() {
        Layout.init();
    });
</script>
<!-- END PAGE LEVEL JAVASCRIPTS -->

<script>
    // Add CSRF protection tokens in ajax request also
    $.ajaxSetup({
        headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>

@if (!Services\MenuManager::isImageShown())
    <script>
        $(document).find('img').each(function() { $(this).remove() })
    </script>
@endif
@section('scripts')
    {{-- Here goes the page level scripts and plugins --}}
@show
