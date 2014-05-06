<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>{{ $title}}</title>

    <link rel="stylesheet" type="text/css" href="{{ URL::to('assets/shared/countdown/jquery.countdown.css')}}">

    <script type="text/javascript" src="{{ URL::to('assets/shared/countdown/jquery.min.js')}}"></script>
    <script type="text/javascript" src="{{ URL::to('assets/shared/countdown/jquery.plugin.js')}}"></script>
    <script type="text/javascript" src="{{ URL::to('assets/shared/countdown/jquery.countdown.min.js')}}"></script>
</head>
<body>

    <div id="container">
        <h1>Site Offline</h1>

        <div>
            {{ Setting::value('offline_message') }}
        </div>

        <!-- START COUNTDOWN -->
        <script src="{{ URL::to('assets/shared/countdown/countdown.js') }}" type="text/javascript"></script>
        <?php
            $offline_end = Setting::value("{$link_type}_offline_end");
            $offline_end = ($offline_end) ? Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $offline_end) : '';
        ?>

        @if ($offline_end)
            <div>
                <h3>We'll be online in:</h3>
                <div id="countdown"></div>
            </div>

            <script type="application/javascript">

                $('#countdown').countdown({
                        until: new Date({{ $offline_end->year }}, {{ $offline_end->month }}-1, {{ $offline_end->day }}, {{ $offline_end->hour }}, {{ $offline_end->minute }}, {{ $offline_end->second }}),
                        onExpiry: reloadPage
                    });

                function reloadPage() {
                    location.reload(true);
                }

            </script>
        @endif
        <!-- END COUNTDOWN -->
    </div>

</body>
</html>
