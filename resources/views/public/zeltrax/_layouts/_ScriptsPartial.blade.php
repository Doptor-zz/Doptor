<!-- get jQuery from the google apis -->
{!! HTML::script("assets/public/{$current_theme}/js/universal/jquery.js") !!}

<!-- SLIDER REVOLUTION 4.x SCRIPTS  -->
{!! HTML::script("assets/public/{$current_theme}/js/revolutionslider/rs-plugin/js/jquery.themepunch.plugins.min.js") !!}
{!! HTML::script("assets/public/{$current_theme}/js/revolutionslider/rs-plugin/js/jquery.themepunch.revolution.min.js") !!}

<!-- mega menu -->
{!! HTML::script("assets/public/{$current_theme}/js/mainmenu/bootstrap.min.js") !!}
{!! HTML::script("assets/public/{$current_theme}/js/mainmenu/fhmm.js") !!}

<!-- scroll up -->
{!! HTML::script("assets/public/{$current_theme}/js/scrolltotop/totop.js") !!}

<!-- REVOLUTION SLIDER -->
{!! HTML::script("assets/public/{$current_theme}/js/revolutionslider/rs-plugin/js/custom.js") !!}

<!-- sticky menu -->
{!! HTML::script("assets/public/{$current_theme}/js/mainmenu/sticky.js") !!}
{!! HTML::script("assets/public/{$current_theme}/js/mainmenu/modernizr.custom.75180.js") !!}

<script type="text/javascript">
    // Menu drop down effect
    $('.dropdown-toggle').dropdownHover().dropdown();
    $(document).on('click', '.fhmm .dropdown-menu', function(e) {
      e.stopPropagation()
    })
</script>

<script>
    // Add CSRF protection tokens in ajax request also
    $.ajaxSetup({
        headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(function () {
        // $("select:not(.select-menu)").chosen();
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
