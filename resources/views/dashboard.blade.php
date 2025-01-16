<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
    <h1>Welcome to Your Dashboard</h1>
    <p>Hello, {{ $user->UserName }}!</p>
    <p>Your role: {{ $user->Role }}</p>
    <p>Your email: {{ $user->email }}</p>
    <p>Your program: {{ $user->Program }}</p>

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit">Logout</button>
    </form>
</body>
</html>
