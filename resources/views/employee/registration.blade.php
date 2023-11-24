<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>Almost there!😎</h1>
    <h4>Just need to fill these details in and your ready to go!</h4>
    @if($errors->any())
        <ul>
            @foreach($errors->all() as $error)
                <li style="color: red;">{{ $error }}</li>
            @endforeach
        </ul>
    @endif
    <form action="{{ route('update-employee', ['token' => $user->verification_token, 'id' => $user->id]) }}" method="POST">
        @csrf
        <label for="first-name">
            First name
            <input type="text" name="first_name">
        </label>
        <label for="middle-name">
            Middle name
            <input type="text" name="middle_name">
        </label>
        <label for="last-name">
            Last name
            <input type="text" name="last_name">
        </label>
        <label for="password">
            New Password
            <input type="text" name="password">
        </label>
        <input type="submit" value="Let's go!">
    </form>
</body>
</html>
