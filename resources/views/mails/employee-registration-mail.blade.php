<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Email Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin: 20px auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #333333;
        }

        p {
            color: #555555;
            line-height: 1.5;
        }

        a {
            display: inline-block;
            background-color: #4caf50;
            color: #ffffff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 3px;
            margin-top: 15px;
        }

        a:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Email Confirmation</h1>
        <p>Dear {{ $user->first_name }},</p>
        <p>You have been added to the company: {{ $user->employee->name }}</p>
        <p>Please complete your registration by clicking the link below:</p>
        <a href="{{ route('registration-completion', ['token' => $user->verification_token]) }}">Complete Registration</a>
    </div>
</body>
</html>
