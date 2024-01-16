<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Employee Update</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        form {
            width: 400px;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #333333;
            margin-bottom: 10px;
        }

        h4 {
            color: #555555;
            margin-bottom: 20px;
        }

        .error {
            color: red;
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 10px;
            color: #555555;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #3498db;
            color: #ffffff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        input[type="submit"]:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>
    <h1>Almost there! 😎</h1>
    <h4>Just need to fill these details in and you're ready to go!</h4>

    @if($errors->any())
        <div class="error">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('update-employee', ['token' => $user->verification_token, 'id' => $user->id]) }}" method="POST">
        @csrf

        <label for="first-name">First name
            <input type="text" name="first_name" required>
        </label>

        <label for="middle-name">Middle name
            <input type="text" name="middle_name">
        </label>

        <label for="last-name">Last name
            <input type="text" name="last_name" required>
        </label>

        <label for="password">New Password
            <input type="password" name="password" required>
        </label>

        <input type="submit" value="Let's go!">
    </form>
</body>
</html>
