<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password | Meeple Corner</title>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600;700&family=Jost:wght@300;400;500;600&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background-color: #FDFCF6;
            font-family: 'Jost', sans-serif;
        }
        .serif { font-family: 'Cormorant Garamond', serif; }
        .accent-gold { background-color: #C5A059; }
        .text-gold { color: #C5A059; }
        input {
            border: 1px solid #e5e7eb;
            background-color: #fcfcfc;
        }
        input:focus {
            border-color: #C5A059;
            outline: none;
            box-shadow: 0 0 0 1px #C5A059;
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen p-4">
    <h1>Forgot Password</h1>

<p>Enter your registered email address and we will send you a password reset link.</p>

@if(session('success'))
    <p style="color: green;">{{ session('success') }}</p>
@endif

@if ($errors->any())
    <ul style="color:red;">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<form method="POST" action="/forgot-password">
    @csrf

    <label>Email:</label>
    <input type="email" name="email" value="{{ old('email') }}">
    <br><br>

    <button type="submit">Send Reset Link</button>
</form>

<br>
<a href="/login">Back to Login</a>
</body>
</html>