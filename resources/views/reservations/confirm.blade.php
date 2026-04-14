<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Booking | Meeple Corner Café</title>
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

    <!-- Sidebar -->
    <aside class="sidebar flex flex-col shrink-0">
        <div class="p-8">
            <div class="serif text-2xl font-bold tracking-tighter text-white">M<span class="text-gold">.</span>C</div>
            <p class="text-[10px] uppercase tracking-[0.3em] text-gray-500 mt-2">Member Portal</p>
        </div>
        <nav class="flex-1 px-4 space-y-2">
            <a href="/" class="sidebar-item flex items-center px-4 py-4 rounded-sm" style="justify-content: flex-start;">
                <i class="fas fa-home w-5 text-xs mr-3"></i><span>Home</span>
            </a>
            
            <a href="/reservation" class="sidebar-item flex items-center px-4 py-4 rounded-sm" style="justify-content: flex-start;">
                <i class="fas fa-calendar-alt w-5 text-xs mr-3"></i><span>Reservations</span>
            </a>
            
            <div class="dropdown-container">
                <div class="sidebar-item dropdown-toggle flex items-center justify-between px-4 py-4 rounded-sm cursor-pointer">
                    <div class="flex items-center">
                        <i class="fas fa-user w-5 text-xs mr-3"></i><span>My Account</span>
                    </div>
                    <i class="fas fa-chevron-right rotate-icon text-[8px] transition-transform"></i>
                </div>
                <div class="dropdown-menu ml-6">
                    <a href="/profile/info" class="sub-sidebar-item"><i class="fas fa-id-card w-4 text-[10px] mr-3"></i> My Info</a>
                    <a href="/profile/edit" class="sub-sidebar-item"><i class="fas fa-edit w-4 text-[10px] mr-3"></i> Edit My Account</a>
                    <a href="/profile/history" class="sub-sidebar-item"><i class="fas fa-history w-4 text-[10px] mr-3"></i> Reservation History</a>
                </div>
            </div>
            
            <a href="{{ route('board-games') }}" class="sidebar-item flex items-center px-4 py-4 rounded-sm" style="justify-content: flex-start;">
                <i class="fas fa-chess-knight w-5 text-xs mr-3"></i><span>Game Library</span>
            </a>
            
            <a href="{{ route('menu') }}" class="sidebar-item flex items-center px-4 py-4 rounded-sm" style="justify-content: flex-start;">
                <i class="fas fa-coffee w-5 text-xs mr-3"></i><span>Menu</span>
            </a>
        </nav>
        <div class="p-8 border-t border-white/5">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-[10px] uppercase tracking-widest text-red-400 font-bold hover:text-red-300 flex items-center gap-2 w-full">
                    <i class="fas fa-sign-out-alt"></i> Sign Out
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="main-wrapper">
        <main class="flex-1 flex flex-col">
            <header class="h-20 bg-white border-b border-gray-100 flex items-center justify-between px-4 md:px-10 shrink-0">
                <div><h2 class="serif text-xl md:text-2xl text-gray-800 italic"><i class="fas fa-clipboard-list mr-2 text-gold"></i> Confirm Booking</h2></div>
                <div class="flex items-center space-x-4 md:space-x-6">
                    <span class="text-[10px] md:text-[11px] uppercase tracking-widest text-gray-400">Greetings, {{ session('member_name') }}</span>
                    <a href="/profile/info" class="w-8 h-8 md:w-10 md:h-10 border border-gray-100 p-1 rounded-full hover:border-gold transition-colors block">
                        <div class="w-full h-full bg-gray-200 rounded-full"></div>
                    </a>
                </div>
            </header>

            <div class="p-4 md:p-10 max-w-4xl w-full mx-auto">
                
                <!-- Confirmation Card -->
                <div class="bg-white border border-gray-100 shadow-sm overflow-hidden relative">
                    <div class="absolute top-0 left-0 w-1 h-full accent-gold"></div>
                    
                    <div class="p-6 md:p-8 border-b border-gray-100 bg-gray-50">
                        <h3 class="serif text-2xl text-gray-800">Review Your Booking</h3>
                        <p class="text-sm text-gray-500">Please verify your details before confirming</p>
                    </div>

                    <div class="p-6 md:p-8 space-y-6">
                        <!-- Warning Message -->
                        <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4">
                            <div class="flex items-center gap-3">
                                <i class="fas fa-exclamation-triangle text-yellow-600"></i>
                                <p class="text-sm text-yellow-700">Please double-check your booking details. Once confirmed, changes cannot be made online.</p>
                            </div>
                        </div>

                        <!-- Booking Details -->
                        <div class="bg-amber-50 rounded-xl p-6">
                            <h4 class="serif text-xl text-gray-800 mb-4 flex items-center gap-2">
                                <i class="fas fa-ticket-alt text-gold"></i> 
                                Booking Summary
                            </h4>
                            
                            <div class="space-y-3">
                                <div class="flex justify-between items-center pb-2 border-b border-amber-100">
                                    <span class="text-sm text-gray-600"><i class="fas fa-calendar-alt w-5"></i> Date</span>
                                    <span class="font-semibold text-gray-800">{{ \Carbon\Carbon::parse($reservationData['reservation_date'])->format('l, F j, Y') }}</span>
                                </div>
                                <div class="flex justify-between items-center pb-2 border-b border-amber-100">
                                    <span class="text-sm text-gray-600"><i class="fas fa-clock w-5"></i> Time Slot</span>
                                    <span class="font-semibold text-gray-800">{{ $reservationData['start_time'] }} - {{ $reservationData['end_time'] }}</span>
                                </div>
                                <div class="flex justify-between items-center pb-2 border-b border-amber-100">
                                    <span class="text-sm text-gray-600"><i class="fas fa-hourglass-half w-5"></i> Duration</span>
                                    <span class="font-semibold text-gray-800">
                                        {{ \Carbon\Carbon::parse($reservationData['start_time'])->diffInHours(\Carbon\Carbon::parse($reservationData['end_time'])) }} hours
                                    </span>
                                </div>
                                <div class="flex justify-between items-center pb-2 border-b border-amber-100">
                                    <span class="text-sm text-gray-600"><i class="fas fa-chair w-5"></i> Table/Room</span>
                                    <span class="font-semibold text-gray-800">{{ $space->name }}</span>
                                </div>
                                <div class="flex justify-between items-center pb-2 border-b border-amber-100">
                                    <span class="text-sm text-gray-600"><i class="fas fa-users w-5"></i> Capacity</span>
                                    <span class="font-semibold text-gray-800">{{ $space->capacity }} players</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-600"><i class="fas fa-tag w-5"></i> Table Type</span>
                                    <span class="font-semibold text-gray-800">{{ ucfirst($space->type) }}</span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Private Room Badge if applicable -->
                        @if($reservationData['is_private_booking'])
                            <div class="bg-amber-100 text-amber-800 p-4 rounded-lg flex items-center gap-3">
                                <i class="fas fa-door-closed text-xl"></i>
                                <div>
                                    <p class="font-bold text-sm">Private Room Booking</p>
                                    <p class="text-xs opacity-75">This table will be reserved as a private room</p>
                                </div>
                            </div>
                        @endif
                        
                        <!-- Member Info -->
                        <div class="bg-gray-50 rounded-xl p-6">
                            <h4 class="serif text-xl text-gray-800 mb-4 flex items-center gap-2">
                                <i class="fas fa-user-circle text-gold"></i> 
                                Your Information
                            </h4>
                            <div class="space-y-2">
                                <p><span class="text-sm text-gray-500">Name:</span> <span class="font-semibold">{{ $member->first_name }} {{ $member->last_name }}</span></p>
                                <p><span class="text-sm text-gray-500">Email:</span> <span class="font-semibold">{{ $member->email }}</span></p>
                                <p><span class="text-sm text-gray-500">Phone:</span> <span class="font-semibold">{{ $member->phone }}</span></p>
                            </div>
                        </div>

                        <!-- Game Suggestion -->
                        <div class="bg-gradient-to-r from-gold/10 to-amber-50 p-5 rounded-lg">
                            <div class="flex items-center gap-3">
                                <i class="fas fa-dice-d6 text-gold text-2xl"></i>
                                <div>
                                    <p class="text-xs uppercase tracking-wider text-gold font-bold">Recommended Game</p>
                                    <p class="font-semibold text-gray-800">🎲 Catan: Starfarers</p>
                                    <p class="text-xs text-gray-500 mt-1">Perfect for {{ $space->capacity }} players! Ask our staff to set it up.</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="flex flex-col sm:flex-row gap-4 pt-4">
                            <a href="/reservation" 
                               class="flex-1 border-2 border-gray-300 text-gray-600 text-center py-3 px-6 text-sm font-bold uppercase tracking-wider hover:border-gold hover:text-gold transition-all duration-500 rounded-lg">
                                <i class="fas fa-arrow-left mr-2"></i> Back to Edit
                            </a>
                            <form method="POST" action="{{ route('reservation.process') }}" class="flex-1">
                                @csrf
                                <button type="submit" 
                                        class="w-full accent-gold text-white text-center py-3 px-6 text-sm font-bold uppercase tracking-wider hover:bg-black transition-all duration-500 rounded-lg">
                                    <i class="fas fa-check-circle mr-2"></i> Confirm Booking
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <footer class="mt-auto p-4 md:p-10 text-center text-[10px] uppercase tracking-[0.3em] text-gray-400 border-t border-gray-50">
                © 2026 Meeple Corner Café — Established for the Strategic Mind
            </footer>
        </main>
    </div>

    <script>
        // Dropdown toggle
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