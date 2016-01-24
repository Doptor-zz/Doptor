<h1>{!! trans('password_reset.reset_confirmation') !!}</h1>
<h2>For {!! Setting::value('website_name') !!}</h2>

<p>{!! trans('password_reset.reset_success', ['link' => HTML::link(url("suspend_user/{$user_id}/{$created_at}"), 'here')]) !!}</p>
