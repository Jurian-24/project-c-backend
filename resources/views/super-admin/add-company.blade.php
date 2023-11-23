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
    <p>Voeg een company toe</p>
    @if (session('success'))
        <p style="background-color: lime; color: white;">{{ session('success') }}</p>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('company-adding') }}" method="POST">
        @csrf
        <label for="company-name">
            Name
            <input type="text" name="company_name" id="company-name" required>
        </label>
        <label for="manager-frist-name">
            Manager's First Name
            <input type="text" name="manager_first_name" id="manager_first_name" required>
        </label>
        <label for="manager-email">
            Email of the manager
            <input type="text" name="manager_email" id="manager_email" required>
        </label>
        <label for="manager-password">
            Temporary password of the manager
            <input type="text" name="manager_password" id="manager_password" required>
        </label>

        <button type="submit">Add company</button>
    </form>

    <a href="{{ route('home') }}">Ga naar home</a>
    <button><a href="{{ route('logout') }}">Logout</a></button>
</body>
</html>
