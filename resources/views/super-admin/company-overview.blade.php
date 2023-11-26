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
    <h4>Company overview</h4>
    <a href="{{ route('home') }}">Home</a>

    @if (session('success'))
        <div style="background-color: lime; color: white">
            {{ session('success') }}
        </div>
    @endif

    @foreach ($companies as $company)
        <h3>{{ $company->name }}</h3>
        <h3>{{ $company->employee->count() }}</h3>

        <form action="{{ route('delete-company', $company->id) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit" style="background-color: red; color: white">Delete</button>
        </form>
    @endforeach
</body>
</html>
