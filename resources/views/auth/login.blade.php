<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Meeple Corner Café</title>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600;700&family=Jost:wght@300;400;500&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { 
            background-color: #FDFCF6; 
            font-family: 'Jost', sans-serif;
            color: #1A1A1A;
        }
        .serif { font-family: 'Cormorant Garamond', serif; }
        .accent-gold { background-color: #C5A059; }
        .text-gold { color: #C5A059; }
        
        input {
            border: 1px solid #e5e7eb;
            transition: all 0.3s ease;
            border-radius: 0 !important; /* Tricia style is sharp-edged */
        }
        input:focus {
            border-color: #C5A059 !important;
            outline: none;
            background-color: #fff !important;
        }
        .btn-luxury {
            transition: all 0.5s ease;
            letter-spacing: 0.2em;
        }
        .btn-luxury:hover {
            background-color: #1a1a1a;
            color: white;
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen p-4">

    <div class="max-w-4xl w-full bg-white flex flex-col md:flex-row shadow-2xl border border-gray-100 overflow-hidden">
        
        <div class="hidden md:flex flex-1 flex-col justify-between p-12 text-white relative" style="background-color: #1a1a1a;">
            <div>
                <h1 class="serif text-4xl mb-2">Welcome Back</h1>
                <div class="h-0.5 w-10 accent-gold mb-6"></div>
                <p class="text-xs uppercase tracking-[0.2em] font-light opacity-70">The board is set. Your table awaits.</p>
            </div>

            <div class="mt-auto">
                <p class="serif italic text-lg opacity-80">"Victory belongs to the most persevering."</p>
                <p class="text-[10px] uppercase tracking-widest text-gold mt-2">— Napoléon Bonaparte</p>
            </div>

            <div class="absolute top-0 right-0 w-32 h-32 border-r border-t border-gold opacity-10 m-4"></div>
        </div>

        <div class="flex-1 p-8 md:p-14">
            <div class="text-center md:text-left mb-10">
                <h2 class="serif text-4xl text-gray-800 mb-2">Sign In</h2>
                <p class="text-gray-400 text-xs uppercase tracking-widest">Enter your credentials</p>
            </div>

            @if ($errors->any())
                <div class="mb-6 p-3 bg-red-50 border-l-2 border-red-500 text-red-600 text-xs font-medium">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="/login" class="space-y-5">
                @csrf
                <div>
                    <label class="text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-1 block">Email Address</label>
                    <input type="email" name="email" value="{{ old('email') }}" required 
                        class="w-full px-4 py-3 bg-gray-50 text-sm focus:bg-white">
                </div>

                <div>
                    <label class="text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-1 block">Password</label>
                    <input type="password" name="password" required 
                        class="w-full px-4 py-2 bg-gray-50 text-sm focus:bg-white">
                </div>

                <div class="flex items-center justify-between text-[11px] uppercase tracking-wider text-gray-500">
                    <label class="flex items-center cursor-pointer hover:text-gold transition">
                        <input type="checkbox" name="remember" class="mr-2 accent-gold"> Remember Me
                    </label>
                    <a href="/forgot-password" class="hover:text-gold transition font-bold">Forgot Password?</a>
                </div>

                <button type="submit" class="w-full accent-gold text-white font-bold py-4 text-[11px] uppercase tracking-[0.2em] shadow-lg btn-luxury mt-4">
                    Authenticate
                </button>
            </form>

            <div class="mt-12 pt-8 border-t border-gray-100 text-center">
                <p class="text-xs text-gray-400 tracking-wide mb-6">New to the Meeple Corner?</p>
                <a href="/register" class="inline-block border border-gray-200 px-8 py-3 text-[10px] uppercase tracking-[0.2em] font-bold text-gray-600 hover:border-gold hover:text-gold transition duration-500">
                    Create An Account
                </a>
            </div>

            <div class="mt-8 flex justify-center space-x-6 text-gray-300">
                <a href="#" class="hover:text-gold transition"><i class="fab fa-facebook-f text-xs"></i></a>
                <a href="#" class="hover:text-gold transition"><i class="fab fa-google text-xs"></i></a>
                <a href="#" class="hover:text-gold transition"><i class="fab fa-instagram text-xs"></i></a>
            </div>
        </div>
    </div>

</body>
</html>