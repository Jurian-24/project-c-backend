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

    <form action="{{ route('company-adding') }}" method="POST">
        @csrf
        <label for="company-name">
            Name
            <input type="text" name="company_name" id="company-name">
        </label>
        <label for="adress">
            Adress
            <input type="text" name="adress" id="adress">
        </label>
        <label for="country">
            Country
            <input type="text" name="country" id="country">
        </label>
        <label for="city">
            City
            <input type="text" name="city" id="city">
        </label>
        <label for="zip">
            Zip code
            <input type="text" name="zip" id="zip">
        </label>
        <label for="Building">
            Building
            <input type="text" name="building" id="building">
        </label>
        <button type="submit">Add company</button>
    </form>

    <a href="{{ route('home') }}">Ga naar home</a>
    <button><a href="{{ route('logout') }}">Logout</a></button>
</body>
</html>
