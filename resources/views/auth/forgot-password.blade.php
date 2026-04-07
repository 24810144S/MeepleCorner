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
    <div class="max-w-md w-full bg-white border border-gray-100 shadow-sm p-8 relative">
        <div class="absolute top-0 left-0 w-1 h-full accent-gold"></div>

        <div class="text-center mb-8">
            <div class="serif text-3xl font-bold text-gray-800">M<span class="text-gold">.</span>C</div>
            <p class="text-[10px] uppercase tracking-[0.3em] text-gray-400 mt-2">Reset your password</p>
        </div>

        @if (session('status'))
            <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 text-sm">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="/forgot-password">
            @csrf

            <div class="mb-6">
                <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-widest mb-2">Email Address</label>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus
                       class="w-full h-12 px-4 text-sm @error('email') border-red-500 @enderror">
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit"
                    class="w-full accent-gold text-white text-[11px] font-bold uppercase tracking-[0.3em] py-4 hover:bg-black transition-all duration-500">
                Send Reset Link
            </button>
        </form>
         <form method="POST" action="/forgot-password">
            @csrf
            <div class="mb-4">
                <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-widest mb-2">Email Address</label>
                <input type="email" name="email" value="{{ old('email') }}" required class="w-full h-12 px-4 text-sm">
            </div>

            <div class="mb-6">
                <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-widest mb-2">Security Question</label>
                <select name="security_question" required class="w-full h-12 px-4 text-sm">
                    <option value="">Select your question</option>
                    <option>What is your mother's maiden name?</option>
                    <option>What was your first pet's name?</option>
                    <option>What city were you born in?</option>
                </select>
            </div>

            <div class="mb-6">
                <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-widest mb-2">Answer</label>
                <input type="text" name="answer" required class="w-full h-12 px-4 text-sm">
            </div>

            <button type="submit" class="w-full accent-gold text-white text-[11px] font-bold uppercase tracking-[0.3em] py-4 hover:bg-black transition">
                Verify & Reset Password
            </button>
        </form>

        <div class="mt-6 text-center">
            <a href="{{ route('login') }}" class="text-[10px] uppercase tracking-widest text-gold hover:underline">
                ← Back to Login
            </a>
        </div>
    </div>
</body>
</html>