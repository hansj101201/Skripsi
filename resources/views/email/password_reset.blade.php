<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset</title>
</head>
<body>
    <p>Dear User,</p>
    <p>You have requested to reset your password. Please click the following link to reset your password:</p>
    <a href="{{ route('password.reset', ['token' => $token]) }}">Reset Password</a>
    <p>If you did not request this password reset, please ignore this email.</p>
    <p>Thank you.</p>
</body>
</html>
