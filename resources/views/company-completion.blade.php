<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>Aloha {{ $company->employee->first()->user->first_name }}</h1>
    <h4>Just needing to fill in some things here</h4>
    <a href="{{ route('home') }}">Home</a>
    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li style="color: red">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('update-company', ['company' => $company]) }}" method="POST">
        @csrf
        @method('POST')
        <label for="company-name">
            Name
            <input type="text" name="company_name" value="{{ $company->name }}" required>
        </label>
        <label for="company-adress">
            Company' address
            <input type="text" name="company_adress" value="{{ $company->adress }}" required>
        </label>
        <label for="company-country">
            Company's country
            <input type="text" name="company_country" value="{{ $company->country }}" required>
        </label>
        <label for="company-city">
            Company's city
            <input type="text" name="company_city" value="{{ $company->city }}" required>
        </label>
        <label for="company-zip-code">
            Company's zip code
            <input type="text" name="company_zip" value="{{ $company->zip }}" required>
        </label>
        <label for="company-building">
            Company's building <strong>(not required)</strong>
            <input type="text" name="company_building" value="{{ $company->building }}">
        </label>

        <button type="submit">Update company</button>
    </form>
</body>
</html>
