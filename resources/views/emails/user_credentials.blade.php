<!DOCTYPE html>
<html>
<head>
    <title>Your FYP System Credentials</title>
</head>
<body>
    <h1>Welcome to the FYP System!</h1>
    <p>Dear {{ $user->UserName }},</p>
    <p>Your account has been successfully created. Below are your login credentials:</p>
    <ul>
        <li><strong>Username:</strong> {{ $user->Email }}</li>
        <li><strong>Temporary Password:</strong> {{ $password }}</li>
    </ul>
    <p>Please log in to the system and update your password at your earliest convenience.</p>
    <p>Best regards,</p>
    <p>The FYP System Team</p>
</body>
</html>
