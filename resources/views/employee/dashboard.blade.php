<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>EMPLOYEE</h1>

    <h2>Attendance Schedule</h2>
    @if(session()->has('success'))
        <p style="color: green;">{{ session()->get('success') }}</p>
    @endif

    <a href="{{ route('attendance-schedule') }}">My schedule</a>
</body>
</html>
