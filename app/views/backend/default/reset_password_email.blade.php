<h1>Password Reset Code</h1>
<h2>For {{ Setting::value('website_name') }}</h2>

Click on the following link to reset your password and change to a new one:
{{ HTML::link(url("reset_password/{$user_id}/{$resetCode}"), url("reset_password/{$user_id}/{$resetCode}")) }}
