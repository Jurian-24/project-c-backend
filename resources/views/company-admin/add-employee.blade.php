<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Add Employee</title>
</head>
<body>
    <h1>Add A Employee</h1>

    <form action="{{ route('add-employee') }}" method="POST">
        @csrf
        <label for="email">
            Email
            <input type="email" name="email">
        </label>
        <label for="password">
            Temporary password
            <input type="password" name="password">
        </label>

        <input type="submit" value="Add Employee">
    </form>
</body>
</html>
