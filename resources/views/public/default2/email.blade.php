<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
    <h2>{!! trans('public.contacting_from') !!} {!! Setting::value('website_name') !!}</h2>

    <div>{!! trans('public.name') !!}: {!! $name !!}</div>
    <div>{!! trans('public.email') !!}: {!! $email !!} </div>
    <div>{!! trans('public.subject') !!}: {!! $subject !!} </div>
    <div>{!! trans('public.message') !!}: {!! $message_text !!} </div>
</body>
</html>
