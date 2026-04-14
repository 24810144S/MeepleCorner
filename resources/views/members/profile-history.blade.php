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
        
        /* Highlight animation for new booking */
        @keyframes highlightFlash {
            0% { background-color: transparent; border-left-color: transparent; }
            30% { background-color: #fef3c7; border-left-color: #C5A059; }
            100% { background-color: transparent; border-left-color: transparent; }
        }
        .highlight-new {
            animation: highlightFlash 2s ease-in-out 3;
            border-left: 3px solid #C5A059;
        }
        
        @media (max-width: 768px) {
            .sidebar { width: 70px; overflow-x: hidden; }
            .sidebar .sidebar-item span, .sidebar .sub-sidebar-item span { display: none; }
            .sidebar .sidebar-item { justify-content: center !important; padding: 12px 0 !important; }
            .sidebar .sidebar-item i { margin-right: 0 !important; font-size: 16px !important; }
            .dropdown-toggle .flex.items-center { justify-content: center; }
            .dropdown-toggle .flex.items-center span { display: none; }
            .dropdown-menu { margin-left: 0 !important; }
            .sub-sidebar-item span { display: none; }
            .main-wrapper { margin-left: 70px; }
            .p-10 { padding: 1rem !important; }
        }
    </style>
</head>
<body>

    @include('layouts.sidebar')

    <div class="main-wrapper">
        <main class="flex-1 flex flex-col">
            <header class="h-20 bg-white border-b border-gray-100 flex items-center justify-between px-4 md:px-10">
                <div><h2 class="serif text-xl md:text-2xl text-gray-800 italic"><i class="fas fa-history mr-2 text-gold"></i> Reservation History</h2></div>
                <div class="flex items-center space-x-4 md:space-x-6">
                    <span class="text-[10px] md:text-[11px] uppercase tracking-widest text-gray-400">@if(session()->has('member_name')) Greetings, {{ session('member_name') }} @else Greetings, Guest @endif</span>
                    <a href="/profile/info" class="w-8 h-8 md:w-10 md:h-10 bg-gold rounded-full flex items-center justify-center text-white font-bold hover:opacity-80 transition-opacity">
                        {{ strtoupper(substr($member->first_name, 0, 1)) }}
                    </a>
                </div>
            </header>

            <div class="p-4 md:p-10 max-w-5xl w-full mx-auto">
                @if(session('success'))
                    <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 text-sm rounded-lg flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <i class="fas fa-check-circle text-green-600 text-xl"></i>
                            <span>{{ session('success') }}</span>
                        </div>
                        <button onclick="this.parentElement.remove()" class="text-green-600 hover:text-green-800">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                @endif

                @if(session('booking_success'))
                    <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 text-sm rounded-lg flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <i class="fas fa-check-circle text-green-600 text-xl"></i>
                            <span>{{ session('booking_success') }}</span>
                        </div>
                        <button onclick="this.parentElement.remove()" class="text-green-600 hover:text-green-800">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-600 text-sm rounded-lg">
                        {{ session('error') }}
                    </div>
                @endif

                <!-- Upcoming Reservations -->
                <div class="bg-white border border-gray-100 shadow-sm mb-8 overflow-hidden">
                    <div class="p-4 md:p-6 border-b border-gray-100 bg-gradient-to-r from-green-50 to-white">
                        <div class="flex items-center gap-3">
                            <i class="fas fa-calendar-check text-green-600 text-xl"></i>
                            <h3 class="serif text-xl md:text-2xl text-gray-800">Upcoming Adventures</h3>
                            <span class="ml-auto text-xs md:text-sm text-gray-500">{{ $upcomingReservations->count() }} upcoming</span>
                        </div>
                        <p class="text-[9px] md:text-[10px] uppercase tracking-widest text-gray-400 mt-1">Your scheduled game sessions</p>
                    </div>
                    
                    @if($upcomingReservations->count() > 0)
                        @foreach($upcomingReservations as $res)
                        @php $isNew = session('new_reservation_id') == $res->id; @endphp
                        <div class="p-4 md:p-6 border-b border-gray-100 flex flex-col md:flex-row justify-between items-start md:items-center gap-4 hover:bg-gray-50 transition {{ $isNew ? 'highlight-new' : '' }}">
                            <div class="flex flex-wrap items-center gap-4 md:gap-6">
                                <!-- Date -->
                                <div class="text-center min-w-[70px]">
                                    <div class="text-xl md:text-2xl font-bold text-gold">{{ \Carbon\Carbon::parse($res->reservation_date)->format('d') }}</div>
                                    <div class="text-[9px] md:text-[10px] uppercase text-gray-400">{{ \Carbon\Carbon::parse($res->reservation_date)->format('M Y') }}</div>
                                </div>
                                
                                <!-- Time Slot -->
                                <div class="min-w-[100px]">
                                    <div class="text-xs md:text-sm font-semibold text-gray-700">
                                        <i class="far fa-clock text-gold mr-1"></i> 
                                        {{ \Carbon\Carbon::parse($res->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($res->end_time)->format('H:i') }}
                                    </div>
                                    <div class="text-[10px] text-gray-400 mt-1">
                                        {{ \Carbon\Carbon::parse($res->start_time)->diffInHours(\Carbon\Carbon::parse($res->end_time)) }} hours
                                    </div>
                                </div>
                                
                                <!-- Space Info -->
                                <div>
                                    <h4 class="font-bold text-gray-800 text-sm md:text-base">{{ $res->space->name }}</h4>
                                    <div class="flex flex-wrap gap-2 mt-1">
                                        <span class="text-[9px] md:text-[10px] text-gray-500"><i class="fas fa-users"></i> {{ $res->space->capacity }} players</span>
                                        <span class="text-[9px] md:text-[10px] text-gray-500"><i class="fas fa-tag"></i> {{ ucfirst($res->space->type) }}</span>
                                        @if($res->is_private_booking)
                                            <span class="text-[9px] md:text-[10px] bg-amber-100 text-amber-800 px-2 py-0.5 rounded">🏠 Private Room Booking</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            
                            <div class="flex items-center gap-3 w-full md:w-auto justify-end">
                                <span class="text-[9px] md:text-[10px] bg-green-100 text-green-700 px-2 md:px-3 py-1 uppercase tracking-wider rounded">Confirmed</span>
                                <form method="POST" action="/reservation/{{ $res->id }}" onsubmit="return confirm('Cancel this reservation?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-400 hover:text-red-600 text-xs uppercase tracking-wider transition flex items-center gap-1">
                                        <i class="fas fa-times-circle"></i> Cancel
                                    </button>
                                </form>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="p-8 md:p-12 text-center">
                            <i class="fas fa-calendar-week text-4xl text-gray-300 mb-4"></i>
                            <p class="text-gray-400">No upcoming reservations</p>
                            <a href="/reservation" class="inline-block mt-4 text-gold text-xs md:text-sm uppercase tracking-wider hover:underline">Book a session →</a>
                        </div>
                    @endif
                </div>

                <!-- Past Reservations -->
                <div class="bg-white border border-gray-100 shadow-sm overflow-hidden">
                    <div class="p-4 md:p-6 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white">
                        <div class="flex items-center gap-3">
                            <i class="fas fa-history text-gray-500 text-xl"></i>
                            <h3 class="serif text-xl md:text-2xl text-gray-800">Past Adventures</h3>
                            <span class="ml-auto text-xs md:text-sm text-gray-500">{{ $pastReservations->count() }} completed</span>
                        </div>
                        <p class="text-[9px] md:text-[10px] uppercase tracking-widest text-gray-400 mt-1">Your completed game sessions</p>
                    </div>
                    
                    @if($pastReservations->count() > 0)
                        @foreach($pastReservations as $res)
                        <div class="p-4 md:p-6 border-b border-gray-100 opacity-75 hover:opacity-100 transition">
                            <div class="flex flex-wrap items-center gap-4 md:gap-6">
                                <!-- Date -->
                                <div class="text-center min-w-[70px]">
                                    <div class="text-xl md:text-2xl font-bold text-gray-500">{{ \Carbon\Carbon::parse($res->reservation_date)->format('d') }}</div>
                                    <div class="text-[9px] md:text-[10px] uppercase text-gray-400">{{ \Carbon\Carbon::parse($res->reservation_date)->format('M Y') }}</div>
                                </div>
                                
                                <!-- Time Slot -->
                                <div class="min-w-[100px]">
                                    <div class="text-xs md:text-sm text-gray-500">
                                        <i class="far fa-clock text-gray-400 mr-1"></i> 
                                        {{ \Carbon\Carbon::parse($res->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($res->end_time)->format('H:i') }}
                                    </div>
                                </div>
                                
                                <!-- Space Info -->
                                <div class="flex-1">
                                    <h4 class="font-bold text-gray-600 text-sm md:text-base">{{ $res->space->name }}</h4>
                                    <div class="flex flex-wrap gap-2 mt-1">
                                        <span class="text-[9px] md:text-[10px] text-gray-400"><i class="fas fa-users"></i> {{ $res->space->capacity }} players</span>
                                        <span class="text-[9px] md:text-[10px] text-gray-400"><i class="fas fa-tag"></i> {{ ucfirst($res->space->type) }}</span>
                                        @if($res->is_private_booking)
                                            <span class="text-[9px] md:text-[10px] bg-amber-50 text-amber-600 px-2 py-0.5 rounded">🏠 Private Room Booking</span>
                                        @endif
                                    </div>
                                </div>
                                
                                <div>
                                    <span class="text-[9px] md:text-[10px] bg-gray-100 text-gray-500 px-2 md:px-3 py-1 uppercase tracking-wider rounded">Completed</span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="p-8 md:p-12 text-center">
                            <i class="fas fa-clock text-4xl text-gray-300 mb-4"></i>
                            <p class="text-gray-400">No past reservations yet</p>
                        </div>
                    @endif
                </div>

                <!-- Stats Summary -->
                <div class="mt-6 bg-gradient-to-r from-amber-50 to-yellow-50 border border-amber-200 p-4 md:p-6 flex flex-col sm:flex-row justify-between items-center gap-4 rounded-lg">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-dice-d20 text-amber-600 text-2xl"></i>
                        <div>
                            <p class="text-xs text-gray-600">Total reservations</p>
                            <p class="text-lg font-bold text-gray-800">{{ $upcomingReservations->count() + $pastReservations->count() }}</p>
                        </div>
                    </div>
                    <div class="text-center sm:text-right">
                        <p class="text-[9px] md:text-[10px] uppercase tracking-wider text-amber-700">Loyalty Points Earned</p>
                        <p class="text-xl md:text-2xl font-bold text-amber-600">{{ ($upcomingReservations->count() + $pastReservations->count()) * 50 }}</p>
                    </div>
                </div>
            </div>

            <footer class="mt-auto p-4 md:p-10 text-center text-[10px] uppercase tracking-[0.3em] text-gray-400 border-t border-gray-50">
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