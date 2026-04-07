<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation History | Meeple Corner Café</title>
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
    </style>
</head>
<body class="flex min-h-screen">

    <!-- Sidebar -->
    <aside class="sidebar flex flex-col shrink-0">
        <div class="p-8">
            <div class="serif text-2xl font-bold tracking-tighter text-white">M<span class="text-gold">.</span>C</div>
            <p class="text-[10px] uppercase tracking-[0.3em] text-gray-500 mt-2">Member Portal</p>
        </div>
        <nav class="flex-1 px-4 space-y-2">
            <a href="/" class="sidebar-item flex items-center px-4 py-4 rounded-sm">
                <i class="fas fa-home w-6 text-xs"></i> <span>Home</span>
            </a>
            <a href="/reservation" class="sidebar-item flex items-center px-4 py-4 rounded-sm">
                <i class="fas fa-calendar-alt w-6 text-xs"></i> <span>Reservations</span>
            </a>
            <a href="/reservation-history" class="sidebar-item active flex items-center px-4 py-4 rounded-sm">
                <i class="fas fa-history w-6 text-xs"></i> <span>History</span>
            </a>
            <a href="/profile" class="sidebar-item flex items-center px-4 py-4 rounded-sm">
                <i class="fas fa-user w-6 text-xs"></i> <span>Profile</span>
            </a>
            <a href="{{ route('board-games') }}" class="sidebar-item flex items-center px-4 py-4 rounded-sm">
                <i class="fas fa-chess-knight w-6 text-xs"></i> <span>Game Library</span>
            </a>
            <a href="{{ route('menu') }}" class="sidebar-item flex items-center px-4 py-4 rounded-sm">
                <i class="fas fa-coffee w-6 text-xs"></i> <span>Menu</span>
            </a>
        </nav>
        <div class="p-8 border-t border-white/5">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-[10px] uppercase tracking-widest text-red-400 font-bold hover:text-red-300">
                    Sign Out
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col">
        <header class="h-20 bg-white border-b border-gray-100 flex items-center justify-between px-10 shrink-0">
            <div>
                <h2 class="serif text-2xl text-gray-800 italic">Reservation History</h2>
            </div>
            <div class="flex items-center space-x-6">
                <span class="text-[11px] uppercase tracking-widest text-gray-400">
                    @if(session()->has('member_name'))
                        Greetings, {{ session('member_name') }}
                    @else
                        Greetings, Guest
                    @endif
                </span>
                <div class="w-10 h-10 border border-gray-100 p-1">
                    <div class="w-full h-full bg-gray-200 rounded-full"></div>
                </div>
            </div>
        </header>

        <div class="p-10 max-w-6xl w-full mx-auto">
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-600 text-sm">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Upcoming Reservations -->
            <div class="bg-white border border-gray-100 shadow-sm mb-8 overflow-hidden">
                <div class="p-6 border-b border-gray-100 bg-gradient-to-r from-green-50 to-white">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-calendar-check text-green-600 text-xl"></i>
                        <h3 class="serif text-2xl text-gray-800">Upcoming Adventures</h3>
                        <span class="ml-auto text-sm text-gray-500">{{ $upcomingReservations->count() }} upcoming</span>
                    </div>
                    <p class="text-[10px] uppercase tracking-widest text-gray-400 mt-1">Your scheduled game sessions</p>
                </div>
                
                @if($upcomingReservations->count() > 0)
                    <div class="divide-y divide-gray-100">
                        @foreach($upcomingReservations as $res)
                        <div class="p-6 hover:bg-gray-50 transition flex items-center justify-between flex-wrap gap-4">
                            <div class="flex items-center gap-6">
                                <div class="text-center min-w-[80px]">
                                    <div class="text-2xl font-bold text-gold">{{ \Carbon\Carbon::parse($res->reservation_date)->format('d') }}</div>
                                    <div class="text-[10px] uppercase text-gray-400">{{ \Carbon\Carbon::parse($res->reservation_date)->format('M Y') }}</div>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-800">{{ $res->space->name }}</h4>
                                    <p class="text-sm text-gray-500">{{ $res->time_slot }} • {{ $res->space->capacity }} players</p>
                                    <p class="text-[10px] text-gold uppercase tracking-wider mt-1">{{ ucfirst($res->space->type) }} Table</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-4">
                                <span class="text-[10px] bg-green-100 text-green-700 px-3 py-1 uppercase tracking-wider">Confirmed</span>
                                <form method="POST" action="/reservation/{{ $res->id }}" onsubmit="return confirm('Cancel this reservation?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-400 hover:text-red-600 text-xs uppercase tracking-wider transition">
                                        <i class="fas fa-times-circle mr-1"></i> Cancel
                                    </button>
                                </form>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="p-12 text-center">
                        <i class="fas fa-calendar-alt text-4xl text-gray-300 mb-4"></i>
                        <p class="text-gray-400 italic">No upcoming reservations.</p>
                        <a href="/reservation" class="inline-block mt-4 text-gold text-sm uppercase tracking-wider hover:underline">Book your next adventure →</a>
                    </div>
                @endif
            </div>

            <!-- Past Reservations -->
            <div class="bg-white border border-gray-100 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-clock text-gray-500 text-xl"></i>
                        <h3 class="serif text-2xl text-gray-800">Past Adventures</h3>
                        <span class="ml-auto text-sm text-gray-500">{{ $pastReservations->count() }} completed</span>
                    </div>
                    <p class="text-[10px] uppercase tracking-widest text-gray-400 mt-1">Your completed game sessions</p>
                </div>
                
                @if($pastReservations->count() > 0)
                    <div class="divide-y divide-gray-100">
                        @foreach($pastReservations as $res)
                        <div class="p-6 hover:bg-gray-50 transition flex items-center justify-between flex-wrap gap-4 opacity-70">
                            <div class="flex items-center gap-6">
                                <div class="text-center min-w-[80px]">
                                    <div class="text-2xl font-bold text-gray-500">{{ \Carbon\Carbon::parse($res->reservation_date)->format('d') }}</div>
                                    <div class="text-[10px] uppercase text-gray-400">{{ \Carbon\Carbon::parse($res->reservation_date)->format('M Y') }}</div>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-600">{{ $res->space->name }}</h4>
                                    <p class="text-sm text-gray-400">{{ $res->time_slot }} • {{ $res->space->capacity }} players</p>
                                </div>
                            </div>
                            <div>
                                <span class="text-[10px] bg-gray-100 text-gray-500 px-3 py-1 uppercase tracking-wider">Completed</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="p-12 text-center">
                        <i class="fas fa-history text-4xl text-gray-300 mb-4"></i>
                        <p class="text-gray-400 italic">No past reservations yet.</p>
                    </div>
                @endif
            </div>

            <!-- Loyalty Summary -->
            <div class="mt-8 bg-gradient-to-r from-amber-50 to-yellow-50 border border-amber-200 p-6 flex justify-between items-center">
                <div>
                    <i class="fas fa-dice-d20 text-amber-600 text-2xl"></i>
                    <p class="text-xs text-gray-600 mt-1">Total reservations: {{ $upcomingReservations->count() + $pastReservations->count() }}</p>
                </div>
                <div class="text-right">
                    <p class="text-[10px] uppercase tracking-wider text-amber-700">Loyalty Points Earned</p>
                    <p class="text-2xl font-bold text-amber-600">{{ ($upcomingReservations->count() + $pastReservations->count()) * 50 }}</p>
                </div>
            </div>
        </div>

        <footer class="mt-auto p-10 text-center text-[10px] uppercase tracking-[0.3em] text-gray-400 border-t border-gray-50">
            © 2026 Meeple Corner Café — Established for the Strategic Mind
        </footer>
    </main>
</body>
</html>