<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile | Meeple Corner Café</title>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600;700&family=Jost:wght@300;400;500;600&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { background-color: #FDFCF6; font-family: 'Jost', sans-serif; color: #1A1A1A; }
        .serif { font-family: 'Cormorant Garamond', serif; }
        .sidebar { width: 260px; background-color: #1a1a1a; color: white; }
        .sidebar-item { transition: all 0.3s ease; text-transform: uppercase; font-size: 11px; color: #9ca3af; }
        .sidebar-item:hover, .sidebar-item.active { color: #C5A059; }
        .sidebar-item.active { border-right: 3px solid #C5A059; background: linear-gradient(to right, #1a1a1a, #262626); }
        .accent-gold { background-color: #C5A059; }
        .text-gold { color: #C5A059; }
        input, select { border: 1px solid #e5e7eb; background-color: #fcfcfc; border-radius: 0; }
        input:focus, select:focus { border-color: #C5A059; outline: none; box-shadow: 0 0 0 2px rgba(197,160,89,0.1); }
    </style>
</head>
<body class="flex min-h-screen">

    <aside class="sidebar flex flex-col shrink-0">
        <div class="p-8">
            <div class="serif text-2xl font-bold tracking-tighter text-white">M<span class="text-gold">.</span>C</div>
            <p class="text-[10px] uppercase tracking-[0.3em] text-gray-500 mt-2">Member Portal</p>
        </div>
        <nav class="flex-1 px-4 space-y-2">
            <a href="/" class="sidebar-item flex items-center px-4 py-4 rounded-sm"><i class="fas fa-home w-6 text-xs"></i> <span>Home</span></a>
            <a href="/reservation" class="sidebar-item flex items-center px-4 py-4 rounded-sm"><i class="fas fa-calendar-alt w-6 text-xs"></i> <span>Reservations</span></a>
            <a href="/reservation-history" class="sidebar-item flex items-center px-4 py-4 rounded-sm"><i class="fas fa-history w-6 text-xs"></i> <span>History</span></a>
            <a href="/profile" class="sidebar-item active flex items-center px-4 py-4 rounded-sm"><i class="fas fa-user w-6 text-xs"></i> <span>Profile</span></a>
            <a href="{{ route('board-games') }}" class="sidebar-item flex items-center px-4 py-4 rounded-sm"><i class="fas fa-chess-knight w-6 text-xs"></i> <span>Game Library</span></a>
            <a href="{{ route('menu') }}" class="sidebar-item flex items-center px-4 py-4 rounded-sm"><i class="fas fa-coffee w-6 text-xs"></i> <span>Menu</span></a>
        </nav>
        <div class="p-8 border-t border-white/5">
            <form method="POST" action="{{ route('logout') }}">@csrf<button type="submit" class="text-[10px] uppercase tracking-widest text-red-400 font-bold hover:text-red-300">Sign Out</button></form>
        </div>
    </aside>

    <main class="flex-1 flex flex-col">
        <header class="h-20 bg-white border-b border-gray-100 flex items-center justify-between px-10 shrink-0">
            <div><h2 class="serif text-2xl text-gray-800 italic">My Profile</h2></div>
            <div class="flex items-center space-x-6">
                <span class="text-[11px] uppercase tracking-widest text-gray-400">Welcome, {{ $member->first_name }}</span>
                <div class="w-10 h-10 border border-gray-100 p-1 rounded-full"><div class="w-full h-full bg-gold rounded-full flex items-center justify-center text-white text-sm">{{ substr($member->first_name, 0, 1) }}{{ substr($member->last_name, 0, 1) }}</div></div>
            </div>
        </header>

        <div class="p-10 max-w-4xl w-full mx-auto">
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-600 text-sm">
                    @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <div class="bg-white border border-gray-100 shadow-sm overflow-hidden">
                <div class="p-8 border-b border-gray-100">
                    <div class="flex items-center gap-4">
                        <div class="w-20 h-20 bg-gradient-to-br from-gold to-amber-600 rounded-full flex items-center justify-center text-white text-2xl font-bold">
                            {{ strtoupper(substr($member->first_name, 0, 1)) }}{{ strtoupper(substr($member->last_name, 0, 1)) }}
                        </div>
                        <div>
                            <h3 class="serif text-2xl text-gray-800">{{ $member->first_name }} {{ $member->last_name }}</h3>
                            <p class="text-sm text-gray-500">Member since {{ $member->created_at->format('F Y') }}</p>
                            <div class="flex gap-2 mt-1">
                                <span class="text-[9px] bg-gray-100 px-2 py-0.5 uppercase tracking-wider">🎲 Loyalty Level: Bronze</span>
                            </div>
                        </div>
                    </div>
                </div>

                <form method="POST" action="/profile" class="p-8 space-y-6">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-1">
                            <label class="text-[10px] font-bold uppercase tracking-widest text-gray-400">First Name</label>
                            <input type="text" name="first_name" value="{{ old('first_name', $member->first_name) }}" required class="w-full px-4 py-3 text-sm">
                        </div>
                        <div class="space-y-1">
                            <label class="text-[10px] font-bold uppercase tracking-widest text-gray-400">Last Name</label>
                            <input type="text" name="last_name" value="{{ old('last_name', $member->last_name) }}" required class="w-full px-4 py-3 text-sm">
                        </div>
                    </div>

                    <div class="space-y-1">
                        <label class="text-[10px] font-bold uppercase tracking-widest text-gray-400">Mailing Address</label>
                        <input type="text" name="address" value="{{ old('address', $member->address) }}" required class="w-full px-4 py-3 text-sm">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-1">
                            <label class="text-[10px] font-bold uppercase tracking-widest text-gray-400">Phone Number</label>
                            <input type="tel" name="phone" value="{{ old('phone', $member->phone) }}" required class="w-full px-4 py-3 text-sm">
                        </div>
                        <div class="space-y-1">
                            <label class="text-[10px] font-bold uppercase tracking-widest text-gray-400">Email Address</label>
                            <input type="email" name="email" value="{{ old('email', $member->email) }}" required class="w-full px-4 py-3 text-sm">
                        </div>
                    </div>

                    <div class="border-t border-gray-100 pt-6 mt-6">
                        <h4 class="serif text-xl text-gray-700 mb-4">Change Password (Optional)</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-1">
                                <label class="text-[10px] font-bold uppercase tracking-widest text-gray-400">New Password</label>
                                <input type="password" name="password" class="w-full px-4 py-3 text-sm">
                                <p class="text-[9px] text-gray-400">Leave blank to keep current password</p>
                            </div>
                            <div class="space-y-1">
                                <label class="text-[10px] font-bold uppercase tracking-widest text-gray-400">Confirm Password</label>
                                <input type="password" name="password_confirmation" class="w-full px-4 py-3 text-sm">
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end gap-4 pt-6">
                        <a href="/" class="border border-gray-300 text-gray-500 text-[11px] font-bold uppercase tracking-[0.3em] px-8 py-4 hover:bg-gray-100 transition">Cancel</a>
                        <button type="submit" class="accent-gold text-white text-[11px] font-bold uppercase tracking-[0.3em] px-8 py-4 hover:bg-black transition-all duration-500">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>

            <!-- Loyalty Points Display -->
            <div class="mt-6 bg-gradient-to-r from-amber-50 to-yellow-50 border border-amber-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <i class="fas fa-crown text-amber-500 text-2xl"></i>
                        <h4 class="serif text-lg text-gray-800 mt-2">Loyalty Points</h4>
                        <p class="text-xs text-gray-500">Earn points with every reservation</p>
                    </div>
                    <div class="text-right">
                        <span class="text-3xl font-bold text-amber-600">1,250</span>
                        <p class="text-[10px] text-gray-500 uppercase tracking-wider">points earned</p>
                    </div>
                </div>
                <div class="mt-4 w-full bg-amber-200 rounded-full h-2">
                    <div class="bg-amber-600 h-2 rounded-full" style="width: 25%"></div>
                </div>
                <p class="text-[9px] text-gray-500 mt-2">250 more points to reach Silver tier</p>
            </div>
        </div>

        <footer class="mt-auto p-10 text-center text-[10px] uppercase tracking-[0.3em] text-gray-400 border-t border-gray-50">
            © 2026 Meeple Corner Café — Established for the Strategic Mind
        </footer>
    </main>
</body>
</html>