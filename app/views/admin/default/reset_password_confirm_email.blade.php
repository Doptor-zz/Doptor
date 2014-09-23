<h1>Password Reset Confirmation</h1>
<h2>For {{ Setting::value('website_name') }}</h2>

<p>You have successfully reset your password. If you did not do this, please click {{ HTML::link(url("suspend_user/{$user_id}/{$created_at}"), 'here') }} to suspend your user account.</p>
