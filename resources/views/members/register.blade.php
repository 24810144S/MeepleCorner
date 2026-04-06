<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600;700&family=Jost:wght@300;400;500&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { 
            background-color: #FDFCF6; /* Soft Cream Background */
            font-family: 'Jost', sans-serif;
            color: #222;
        }
        .serif { font-family: 'Cormorant Garamond', serif; }
        .accent-gold { background-color: #C5A059; }
        .text-gold { color: #C5A059; }
        .border-gold { border-color: #C5A059; }
        
        input, select {
            border: 1px solid #e5e7eb;
            transition: all 0.3s ease;
        }
        input:focus, select:focus {
            border-color: #C5A059 !important;
            box-shadow: 0 0 0 3px rgba(197,160,89,0.15);
            outline: none;
        }
        .form-card {
            background: #ffffff;
            box-shadow: 0 10px 30px rgba(0,0,0,0.03);
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen py-12 px-4">
    
    <div class="max-w-5xl w-full flex flex-col md:flex-row form-card rounded-xl overflow-hidden border border-gray-100">
        
        <div class="hidden md:flex md:w-1/3 flex-col justify-between p-12 text-white relative overflow-hidden" style="background-color: #1a1a1a;">
            <div class="relative z-10">
                <h1 class="serif text-4xl mb-4 leading-tight">Meeple Corner<br>Café</h1>
                <div class="h-1 w-12 accent-gold mb-8"></div>
                <p class="text-sm font-light leading-loose opacity-80 uppercase tracking-widest">Coffee • Strategy • Community</p>
            </div>
            
            <div class="relative z-10 space-y-6">
                <div class="flex items-start space-x-4">
                    <i class="fas fa-shield-halved text-gold mt-1"></i>
                    <p class="text-xs uppercase tracking-wider font-medium">Secured with three-tier protection</p>
                </div>
                <div class="flex items-start space-x-4">
                    <i class="fas fa-envelope-open-text text-gold mt-1"></i>
                    <p class="text-xs uppercase tracking-wider font-medium">Exclusive invitations to game nights</p>
                </div>
            </div>
            
            <div class="absolute -bottom-10 -left-10 w-40 h-40 border-8 border-gold opacity-10 rounded-full"></div>
        </div>

        <div class="flex-1 p-8 md:p-16">
            <header class="mb-10 text-center md:text-left">
                <h2 class="serif text-4xl text-gray-800 mb-2">Create Account</h2>
                <p class="text-gray-400 text-sm italic">Enter your details to join our tabletop family</p>
            </header>
            
            <form id="registrationForm" method="POST" action="/register" class="space-y-6">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-1">
                        <label class="text-[11px] font-bold uppercase tracking-widest text-gray-400">First Name</label>
                        <input type="text" name="first_name" required class="w-full px-4 py-3 text-sm rounded-none bg-gray-50">
                    </div>
                    <div class="space-y-1">
                        <label class="text-[11px] font-bold uppercase tracking-widest text-gray-400">Last Name</label>
                        <input type="text" name="last_name" required class="w-full px-4 py-3 text-sm rounded-none bg-gray-50">
                    </div>
                </div>

                <div class="space-y-1">
                    <label class="text-[11px] font-bold uppercase tracking-widest text-gray-400">Mailing Address</label>
                    <input type="text" name="address" required class="w-full px-4 py-3 text-sm rounded-none bg-gray-50">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-1">
                        <label class="text-[11px] font-bold uppercase tracking-widest text-gray-400">Phone</label>
                        <input type="tel" name="phone" required class="w-full px-4 py-3 text-sm rounded-none bg-gray-50">
                    </div>
                    <div class="space-y-1">
                        <label class="text-[11px] font-bold uppercase tracking-widest text-gray-400">Email Address</label>
                        <input type="email" name="email" required class="w-full px-4 py-3 text-sm rounded-none bg-gray-50">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4 border-t border-gray-100">
                    <div class="space-y-1">
                        <label class="text-[11px] font-bold uppercase tracking-widest text-gray-400">Password</label>
                        <input type="password" id="password" name="password" required class="w-full px-4 py-3 text-sm rounded-none bg-gray-50">
                    </div>
                    <div class="space-y-1">
                        <label class="text-[11px] font-bold uppercase tracking-widest text-gray-400">Confirm Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required class="w-full px-4 py-3 text-sm rounded-none bg-gray-50">
                        <p id="password-error" class="text-[10px] text-red-500 mt-1 hidden">Passwords do not match.</p>
                    </div>
                </div>

                <div class="pt-6 border-t border-gray-100 space-y-6">
                    <h3 class="serif text-2xl text-gray-700">Identity Recovery</h3>
                    
                    <div class="space-y-2">
                        <label class="text-[11px] font-bold uppercase tracking-widest text-gray-400">Question 1: Select a hint</label>
                        <select name="security_q1_id" class="w-full px-4 py-3 text-sm rounded-none bg-gray-50">
                            <option>What was the name of your first pet?</option>
                            <option>In what city were you born?</option>
                            <option>What was your childhood nickname?</option>
                        </select>
                        <input type="text" name="security_a1" placeholder="Your Answer" required class="w-full px-4 py-3 text-sm rounded-none">
                    </div>

                    <div class="space-y-2">
                        <label class="text-[11px] font-bold uppercase tracking-widest text-gray-400">Question 2: What is your favorite board game?</label>
                        <input type="text" name="security_a2" required placeholder="e.g. Catan" class="w-full px-4 py-3 text-sm rounded-none bg-gray-50">
                    </div>

                    <div class="space-y-3">
                        <label class="text-[11px] font-bold uppercase tracking-widest text-gray-400">Question 3: Select secret tags</label>
                        <div class="flex flex-wrap gap-4 p-4 border border-gray-100 bg-gray-50">
                            <label class="flex items-center space-x-2 text-xs text-gray-600 cursor-pointer">
                                <input type="checkbox" name="security_a3[]" value="latte" class="accent-gold h-4 w-4"> <span>Latte</span>
                            </label>
                            <label class="flex items-center space-x-2 text-xs text-gray-600 cursor-pointer">
                                <input type="checkbox" name="security_a3[]" value="meeple" class="accent-gold h-4 w-4"> <span>Meeple</span>
                            </label>
                            <label class="flex items-center space-x-2 text-xs text-gray-600 cursor-pointer">
                                <input type="checkbox" name="security_a3[]" value="d20" class="accent-gold h-4 w-4"> <span>D20</span>
                            </label>
                            <label class="flex items-center space-x-2 text-xs text-gray-600 cursor-pointer">
                                <input type="checkbox" name="security_a3[]" value="dice" class="accent-gold h-4 w-4"> <span>Dice</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="pt-8">
                    <button type="submit" class="w-full accent-gold text-white text-xs font-bold uppercase tracking-[0.2em] py-5 hover:bg-black transition-all duration-500 shadow-lg">
                        Confirm Registration
                    </button>
                    <p class="text-center mt-6 text-xs text-gray-400">
                        Already have an account? <a href="/login" class="text-gold font-bold hover:underline ml-1">Login</a>
                    </p>
                </div>
            </form>
        </div>
    </div>

    <script>
        const form = document.getElementById('registrationForm');
        const pass = document.getElementById('password');
        const conf = document.getElementById('password_confirmation');
        const error = document.getElementById('password-error');

        form.addEventListener('submit', function(e) {
            if (pass.value !== conf.value) {
                e.preventDefault(); // Stop submission
                error.classList.remove('hidden');
                conf.classList.add('border-red-400');
                conf.focus();
            }
        });

        // Clear error as the user types
        conf.addEventListener('input', function() {
            if (pass.value === conf.value) {
                error.classList.add('hidden');
                conf.classList.remove('border-red-400');
            }
        });
    </script>
</body>
</html>