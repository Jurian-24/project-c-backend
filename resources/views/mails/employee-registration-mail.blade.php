<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>Dear {{ $user->first_name }}</h1>

    <p>You have been added to the company: {{ $user->employee->name }}</p>

    <p>Please complete your registration by clicking the link below:</p>

    <a href="{{ route('registration-completion', ['id' => $user->id]) }}">Complete Registration</a>
</body>
</html>
