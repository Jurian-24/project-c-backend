<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    @if (session('success'))
        <div style="background-color: lime; color: white;">
            {{ session('success') }}
        </div>
    @endif
    <form
        action="{{ route('update-attendance', [
            'weekNumber' => $attendances[0]->week_number,
            ])
        }}"
        method="POST"
        id="attendance-form"
    >
        <h1>My attendance for week {{ $attendances[0]->week_number }}</h1>
        @csrf
        @foreach($attendances as $attendance)

            @php
                $dayName = now()->startOfWeek()->addDays($attendance->week_day - 1)->formatLocalized('%A');
            @endphp

            <label for="{{ $attendance->week_day }}">{{ $dayName }}</label>
            <input type="checkbox" name="{{ $attendance->week_day }}"
                @if($attendance->onSite)
                    checked
                @endif
            >

        @endforeach
        <button type="submit">Save Attendance</button>
    </form>

    <a href="{{ route('copy-attendance') }}">Copy from last week</a>

</body>
</html>
