<!-- initialize jQuery Library -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="{{URL::to("assets/public/default/js/jquery-1.8.1.min.js")}}"><\/script>')</script>
<!-- Modernizr -->
<script type="text/javascript" src="{{URL::to("assets/public/default/js/modernizr.custom.14583.js")}}"></script>
<!-- Superfish Menu -->
<script type="text/javascript" src="{{URL::to("assets/public/default/js/superfish.js")}}"></script>
<!-- easing plugin -->
<script type="text/javascript" src="{{URL::to("assets/public/default/js/jquery.easing.min.js")}}"></script>
<!-- Prettyphoto -->
<script type="text/javascript" src="{{URL::to("assets/public/default/js/jquery.prettyPhoto.js")}}"></script>
<!-- Mobile Menu -->
<script type="text/javascript" src="{{URL::to("assets/public/default/js/jquery.mobilemenu.js")}}"></script>
<!-- Twitter -->
<!-- <script type="text/javascript" src="{{URL::to("assets/public/default/js/jquery.twitter.js")}}"></script> -->
<!-- Elastslide -->
<script type="text/javascript" src="{{URL::to("assets/public/default/js/jquery.elastislide.js")}}"></script>
<!-- Custom Checkbox -->
<script type="text/javascript" src="{{URL::to("assets/public/default/js/jquery.checkbox.js")}}"></script>
<!-- Reveal Modal -->
<script type="text/javascript" src="{{URL::to("assets/public/default/js/jquery.reveal.js")}}"></script>
<script type="text/javascript" src="{{URL::to("assets/public/default/js/chosen.jquery.min.js")}}"></script>

<!-- Custom -->
<script type="text/javascript" src="{{URL::to("assets/public/default/js/custom.js")}}"></script>
<script>
    // Add CSRF protection tokens in ajax request also
    $.ajaxSetup({
        headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(function () {
        $("select:not(.select-menu)").chosen();
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
