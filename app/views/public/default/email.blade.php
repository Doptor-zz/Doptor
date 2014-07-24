<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
    <h2>Contacting from {{ Setting::value('website_name') }}</h2>

    <div>Name: {{ $name }}</div>
    <div>Email: {{ $email }} </div>
    <div>Subject: {{ $subject }} </div>
    <div>Message: {{ $message_text }} </div>
</body>
</html>
