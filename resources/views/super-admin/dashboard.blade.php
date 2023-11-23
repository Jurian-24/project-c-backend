<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>Aloha {{ auth()->user()->first_name }}</h1>
    <p>Test voor de login</p>
    <p style="color: green">Je bent ingelogd</p>

    <a href="{{ route('add-company') }}">Voeg een company toe</a>
    <a href="{{ route('company-overview') }}">Company overview</a>
    <button><a href="{{ route('logout') }}">Logout</a></button>
</body>
</html>
