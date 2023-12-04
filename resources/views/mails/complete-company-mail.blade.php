<!-- resources/views/emails/welcome.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <title>Welcome Email</title>
</head>
<body>
    <p>Dear {{ $user->first_name }}</p>
    <p>Please complete the verification of your company: {{ $company->name }}</p>
    <button>
        <a href="{{ route('company-verification', ['token' => $company->verification_token,'id' => $company->id]) }}">Verify</a>
    </button>
</body>
</html>
