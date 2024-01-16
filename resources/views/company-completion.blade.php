<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Company Update</title>
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

        a {
            text-decoration: none;
            color: #3498db;
            margin-bottom: 20px;
            display: block;
        }

        a:hover {
            text-decoration: underline;
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

        button {
            background-color: #4caf50;
            color: #ffffff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #45a049;
        }

        .error {
            color: red;
        }
    </style>
</head>
<body>
    <h1>Aloha {{ $company->employee->first()->user->first_name }} 🌟</h1>
    <h4>Just needing to fill in some things here</h4>
    <a href="{{ route('home') }}">Home</a>

    @if ($errors->any())
        <div class="error">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('update-company', ['company' => $company]) }}" method="POST">
        @csrf
        @method('POST')

        <label for="company-name">Name
            <input type="text" name="company_name" value="{{ $company->name }}" required>
        </label>

        <label for="company-adress">Company's address
            <input type="text" name="company_adress" value="{{ $company->adress }}" required>
        </label>

        <label for="company-country">Company's country
            <input type="text" name="company_country" value="{{ $company->country }}" required>
        </label>

        <label for="company-city">Company's city
            <input type="text" name="company_city" value="{{ $company->city }}" required>
        </label>

        <label for="company-zip-code">Company's zip code
            <input type="text" name="company_zip" value="{{ $company->zip }}" required>
        </label>

        <label for="company-building">Company's building <strong>(not required)</strong>
            <input type="text" name="company_building" value="{{ $company->building }}">
        </label>

        <button type="submit">Update Company</button>
    </form>
</body>
</html>
