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
        .accent-gold { background-color: #C5A059; }
        .text-gold { color: #C5A059; }
        
        /* Sidebar styles */
        .sidebar { 
            width: 260px; 
            background-color: #1a1a1a; 
            color: white; 
            position: fixed; 
            top: 0;
            left: 0;
            bottom: 0;
            z-index: 20; 
            overflow-y: auto; 
        }
        
        .main-wrapper {
            margin-left: 260px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        
        .sidebar-item { 
            transition: all 0.3s ease; 
            text-transform: uppercase; 
            font-size: 11px; 
            color: #9ca3af; 
            cursor: pointer; 
            width: 100%; 
        }
        .sidebar-item:hover, .sidebar-item.active { color: #C5A059; }
        .sidebar-item.active { border-right: 3px solid #C5A059; background: linear-gradient(to right, #1a1a1a, #262626); }
        
        .dropdown-menu { max-height: 0; overflow: hidden; transition: max-height 0.3s ease; }
        .dropdown-menu.show { max-height: 400px; }
        .rotate-icon { transition: transform 0.3s ease; }
        .rotate-icon.rotated { transform: rotate(90deg); }
        .sub-sidebar-item {
            transition: all 0.3s ease;
            font-size: 10px;
            color: #7a7a7a;
            border-left: 3px solid transparent;
            padding: 10px 16px 10px 32px;
            border-radius: 4px;
            width: 100%;
            display: flex;
            align-items: center;
        }
        .sub-sidebar-item:hover { color: #C5A059; border-left-color: #C5A059; background: linear-gradient(to right, #1a1a1a, #222222); }
        .sub-sidebar-item.active { color: #C5A059; border-left-color: #C5A059; background: linear-gradient(to right, #1a1a1a, #262626); }
    </style>
</head>
<body>

    @include('layouts.sidebar')

    <div class="main-wrapper">
        <main class="flex-1 flex flex-col">
            <header class="h-20 bg-white border-b border-gray-100 flex items-center justify-between px-10">
                <div><h2 class="serif text-2xl text-gray-800 italic"><i class="fas fa-history mr-2 text-gold"></i> Reservation History</h2></div>
                <div class="flex items-center space-x-6">
                    <span class="text-[11px] uppercase tracking-widest text-gray-400">Welcome, {{ $member->first_name }}</span>
                    <div class="w-10 h-10 bg-gold rounded-full flex items-center justify-center text-white font-bold">{{ strtoupper(substr($member->first_name, 0, 1)) }}</div>
                </div>
            </header>

            <div class="p-10 max-w-5xl w-full mx-auto">
                @if(session('success'))
                    <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 text-sm">{{ session('success') }}</div>
                @endif

                @if(session('error'))
                    <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-600 text-sm">{{ session('error') }}</div>
                @endif

                <!-- Upcoming Reservations -->
                <div class="bg-white border border-gray-100 shadow-sm mb-8 overflow-hidden">
                    <div class="p-6 border-b border-gray-100 bg-gradient-to-r from-green-50 to-white">
                        <div class="flex items-center gap-3">
                            <i class="fas fa-calendar-check text-green-600 text-xl"></i>
                            <h3 class="serif text-2xl text-gray-800">Upcoming Adventures</h3>
                            <span class="ml-auto text-sm text-gray-500">{{ $upcomingReservations->count() }} upcoming</span>
                        </div>
                    </div>
                    
                    @if($upcomingReservations->count() > 0)
                        @foreach($upcomingReservations as $res)
                        <div class="p-6 border-b border-gray-100 flex justify-between items-center hover:bg-gray-50">
                            <div>
                                <p class="font-bold text-lg">{{ \Carbon\Carbon::parse($res->reservation_date)->format('l, F j, Y') }}</p>
                                <p class="text-gray-600">{{ $res->time_slot }}</p>
                                <p class="text-sm text-gold mt-1">{{ $res->space->name }} ({{ $res->space->capacity }} players)</p>
                            </div>
                            <form method="POST" action="/reservation/{{ $res->id }}" onsubmit="return confirm('Cancel this reservation?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-4 py-2 bg-red-500 text-white text-xs uppercase tracking-wider rounded hover:bg-red-700 transition">
                                    Cancel
                                </button>
                            </form>
                        </div>
                        @endforeach
                    @else
                        <div class="p-12 text-center">
                            <i class="fas fa-calendar-week text-4xl text-gray-300 mb-4"></i>
                            <p class="text-gray-400">No upcoming reservations</p>
                            <a href="/reservation" class="inline-block mt-4 text-gold text-sm hover:underline">Book a session →</a>
                        </div>
                    @endif
                </div>

                <!-- Past Reservations -->
                <div class="bg-white border border-gray-100 shadow-sm overflow-hidden">
                    <div class="p-6 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white">
                        <div class="flex items-center gap-3">
                            <i class="fas fa-history text-gray-500 text-xl"></i>
                            <h3 class="serif text-2xl text-gray-800">Past Adventures</h3>
                            <span class="ml-auto text-sm text-gray-500">{{ $pastReservations->count() }} completed</span>
                        </div>
                    </div>
                    
                    @if($pastReservations->count() > 0)
                        @foreach($pastReservations as $res)
                        <div class="p-6 border-b border-gray-100 opacity-75">
                            <p class="font-bold">{{ \Carbon\Carbon::parse($res->reservation_date)->format('l, F j, Y') }}</p>
                            <p class="text-gray-500 text-sm">{{ $res->time_slot }} - {{ $res->space->name }}</p>
                        </div>
                        @endforeach
                    @else
                        <div class="p-12 text-center">
                            <i class="fas fa-clock text-4xl text-gray-300 mb-4"></i>
                            <p class="text-gray-400">No past reservations yet</p>
                        </div>
                    @endif
                </div>

                <!-- Stats Summary -->
                <div class="mt-6 bg-gradient-to-r from-amber-50 to-yellow-50 border border-amber-200 p-6 flex justify-between items-center rounded-lg">
                    <div><i class="fas fa-dice-d20 text-amber-600 text-2xl"></i><p class="text-xs text-gray-600 mt-1">Total reservations: {{ $upcomingReservations->count() + $pastReservations->count() }}</p></div>
                    <div class="text-right"><p class="text-[10px] uppercase tracking-wider text-amber-700">Loyalty Points Earned</p><p class="text-2xl font-bold text-amber-600">{{ ($upcomingReservations->count() + $pastReservations->count()) * 50 }}</p></div>
                </div>
            </div>

            <footer class="mt-auto p-10 text-center text-[10px] uppercase tracking-[0.3em] text-gray-400 border-t border-gray-50">
                © 2026 Meeple Corner Café — Established for the Strategic Mind
            </footer>
        </main>
    </div>

    <script>
        document.querySelectorAll('.dropdown-toggle').forEach(toggle => {
            toggle.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                const container = this.closest('.dropdown-container');
                const menu = container.querySelector('.dropdown-menu');
                const icon = this.querySelector('.rotate-icon');
                
                document.querySelectorAll('.dropdown-container').forEach(other => {
                    if (other !== container) {
                        other.querySelector('.dropdown-menu')?.classList.remove('show');
                        other.querySelector('.rotate-icon')?.classList.remove('rotated');
                    }
                });
                
                menu.classList.toggle('show');
                icon.classList.toggle('rotated');
            });
        });
    </script>
</body>
</html>