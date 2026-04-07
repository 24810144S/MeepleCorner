<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

    <aside class="sidebar flex flex-col shrink-0">
        <div class="p-8">
            <div class="serif text-2xl font-bold tracking-tighter text-white">M<span class="text-gold">.</span>C</div>
            <p class="text-[10px] uppercase tracking-[0.3em] text-gray-500 mt-2">Boutique Admin</p>
        </div>
        <nav class="flex-1 px-4 space-y-2">
            <a href="/" class="sidebar-item flex items-center px-4 py-4 rounded-sm"><i class="fas fa-home w-6 text-xs"></i> <span>Home</span></a>
            <a href="/reservation" class="sidebar-item flex items-center px-4 py-4 rounded-sm"><i class="fas fa-calendar-alt w-6 text-xs"></i> <span>Reservations</span></a>
            <a href="/reservation-history" class="sidebar-item flex items-center px-4 py-4 rounded-sm"><i class="fas fa-history w-6 text-xs"></i> <span>History</span></a>
            <a href="/profile" class="sidebar-item flex items-center px-4 py-4 rounded-sm"><i class="fas fa-user w-6 text-xs"></i> <span>Profile</span></a>
            <a href="{{ route('board-games') }}" class="sidebar-item active flex items-center px-4 py-4 rounded-sm"><i class="fas fa-chess-knight w-6 text-xs"></i> <span>Game Library</span></a>
            <a href="{{ route('menu') }}" class="sidebar-item flex items-center px-4 py-4 rounded-sm"><i class="fas fa-coffee w-6 text-xs"></i> <span>Menu</span></a>
        </nav>
        <div class="p-8 border-t border-white/5">
            <form method="POST" action="{{ route('logout') }}">@csrf<button type="submit" class="text-[10px] uppercase tracking-widest text-red-400 font-bold hover:text-red-300">Sign Out</button></form>
        </div>
    </aside>

    <main class="flex-1 flex flex-col">
        <header class="h-20 bg-white border-b border-gray-100 flex items-center justify-between px-10 shrink-0">
            <div><h2 class="serif text-2xl text-gray-800 italic">Game Library</h2></div>
            <div class="flex items-center space-x-6">
                <span class="text-[11px] uppercase tracking-widest text-gray-400">
                    @if(session()->has('member_name')) Greetings, {{ session('member_name') }} @else Greetings, Guest @endif
                </span>
                <div class="w-10 h-10 border border-gray-100 p-1"><div class="w-full h-full bg-gray-200"></div></div>
            </div>
        </header>

        <div class="p-10 max-w-7xl w-full mx-auto">
            <div class="bg-white border border-gray-100 p-8 shadow-sm">
                <div class="mb-8 flex justify-between items-end border-b border-gray-100 pb-4">
                    <div>
                        <h3 class="serif text-3xl text-gray-800 italic">Board Game Collection</h3>
                        <p class="text-[11px] uppercase tracking-[0.2em] text-gray-400 mt-1">Borrow & play at your table</p>
                    </div>
                    <span class="text-[10px] text-gold">{{ $boardGames->count() }} titles available</span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($boardGames as $game)
                        <div class="border border-gray-100 hover:shadow-md transition-all duration-300 group">
                            <div class="aspect-[4/3] bg-gray-100 relative overflow-hidden">
                                @if($game->image)
                                    <img src="{{ asset('storage/'.$game->image) }}" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition duration-700">
                                @else
                                    <div class="w-full h-full flex flex-col items-center justify-center text-gray-300">
                                        <i class="fas fa-chess-board text-4xl mb-2"></i>
                                        <span class="text-[9px] uppercase">No cover</span>
                                    </div>
                                @endif
                                <div class="absolute bottom-0 right-0 bg-black/70 text-white text-[9px] px-3 py-1 uppercase tracking-wider">
                                    {{ $game->category }}
                                </div>
                            </div>
                            <div class="p-4">
                                <h4 class="serif text-lg font-bold text-gray-800">{{ $game->name }}</h4>
                                <p class="text-xs text-gray-500 mt-1 leading-relaxed">{{ $game->description }}</p>
                                <div class="flex flex-wrap gap-3 mt-3 text-[10px] text-gray-400 uppercase tracking-wider">
                                    <span><i class="fas fa-users"></i> {{ $game->min_players }}-{{ $game->max_players }}</span>
                                    @if($game->play_time_minutes)
                                        <span><i class="fas fa-hourglass-half"></i> {{ $game->play_time_minutes }} min</span>
                                    @endif
                                </div>
                                <div class="mt-3 pt-2 border-t border-gray-50 flex justify-end">
                                    @if($game->is_available)
                                        <span class="text-[9px] text-green-600 font-bold uppercase tracking-wider">✓ Available now</span>
                                    @else
                                        <span class="text-[9px] text-red-500 uppercase tracking-wider">✗ Borrowed</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full text-center text-gray-400 py-8">No board games found. Add some in the database.</div>
                    @endforelse
                </div>
            </div>
        </div>

        <footer class="mt-auto p-10 text-center text-[10px] uppercase tracking-[0.3em] text-gray-400 border-t border-gray-50">
            © 2026 Meeple Corner Café — Established for the Strategic Mind
        </footer>
    </main>
</body>
</html>