<!DOCTYPE html>
<html>
<head>
    <title>Welcome Email</title>
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
            background-color: #4caf50;
            color: #ffffff;
            padding: 10px 20px;
            border: none;
            border-radius: 3px;
            text-decoration: none;
            cursor: pointer;
            display: inline-block;
            font-size: 16px;
            margin-top: 15px;
        }

        a:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome Email</h1>
        <p>Dear {{ $user->first_name }},</p>
        <p>Please complete the verification of your company: {{ $company->name }}</p>
        <a href="{{ route('company-verification', ['token' => $company->verification_token, 'id' => $company->id]) }}">Verify</a>
    </div>
</body>
</html>
