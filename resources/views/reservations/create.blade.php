<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservations | Meeple Corner Café</title>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600;700&family=Jost:wght@300;400;500;600&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { background-color: #FDFCF6; font-family: 'Jost', sans-serif; color: #1A1A1A; }
        .serif { font-family: 'Cormorant Garamond', serif; }
        .sidebar { width: 260px; background-color: #1a1a1a; color: white; position: relative; z-index: 20; height: 100vh; overflow-y: auto; }
        .sidebar-item { transition: all 0.3s ease; text-transform: uppercase; font-size: 11px; color: #9ca3af; cursor: pointer; width: 100%; }
        .sidebar-item:hover, .sidebar-item.active { color: #C5A059; }
        .sidebar-item.active { border-right: 3px solid #C5A059; background: linear-gradient(to right, #1a1a1a, #262626); }
        .accent-gold { background-color: #C5A059; }
        .text-gold { color: #C5A059; }
        input, select { border: 1px solid #e5e7eb; background-color: #fcfcfc; }
        input:focus, select:focus { border-color: #C5A059; outline: none; }
        .space-card.disabled { opacity: 0.5; cursor: not-allowed; }
        
        .main-wrapper {
        margin-left: 260px;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        }
        
        /* Sidebar base styles */
        .sidebar { width: 260px; background-color: #1a1a1a; color: white; position: relative; z-index: 20; height: 100vh; overflow-y: auto; }
        .sidebar-item { transition: all 0.3s ease; text-transform: uppercase; font-size: 11px; color: #9ca3af; cursor: pointer; width: 100%; }
        .sidebar-item:hover, .sidebar-item.active { color: #C5A059; }
        .sidebar-item.active { border-right: 3px solid #C5A059; background: linear-gradient(to right, #1a1a1a, #262626); }

        /* Dropdown styles */
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
        }
        .sub-sidebar-item:hover { color: #C5A059; border-left-color: #C5A059; background: linear-gradient(to right, #1a1a1a, #222222); }
        .sub-sidebar-item.active { color: #C5A059; border-left-color: #C5A059; background: linear-gradient(to right, #1a1a1a, #262626); }
    </style>
</head>
<body>
    @include('layouts.sidebar')
    <div class="main-wrapper">

        <!-- Sidebar -->
        <aside class="sidebar flex flex-col shrink-0" style="background-color: #1a1a1a;">
            <div class="p-8">
                <div class="serif text-2xl font-bold tracking-tighter text-white">M<span class="text-gold">.</span>C</div>
                <p class="text-[10px] uppercase tracking-[0.3em] text-gray-500 mt-2">Member Portal</p>
            </div>
            <nav class="flex-1 px-4 space-y-2">
                <a href="/" class="sidebar-item flex items-center px-4 py-4 rounded-sm" style="justify-content: flex-start;">
                    <i class="fas fa-home w-5 text-xs mr-3"></i><span>Home</span>
                </a>
                
                <a href="/reservation" class="sidebar-item active flex items-center px-4 py-4 rounded-sm" style="justify-content: flex-start;">
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
                        <a href="/profile/info" class="sub-sidebar-item flex items-center px-4 py-3 rounded-sm">
                            <i class="fas fa-id-card w-4 text-[10px] mr-3"></i> My Info
                        </a>
                        <a href="/profile/edit" class="sub-sidebar-item flex items-center px-4 py-3 rounded-sm">
                            <i class="fas fa-edit w-4 text-[10px] mr-3"></i> Edit My Account
                        </a>
                        <a href="/profile/history" class="sub-sidebar-item flex items-center px-4 py-3 rounded-sm">
                            <i class="fas fa-history w-4 text-[10px] mr-3"></i> Reservation History
                        </a>
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
        <main class="flex-1 flex flex-col">
            <header class="h-20 bg-white border-b border-gray-100 flex items-center justify-between px-10 shrink-0">
                <div><h2 class="serif text-2xl text-gray-800 italic">Table Management</h2></div>
                <div class="flex items-center space-x-6">
                    <span class="text-[11px] uppercase tracking-widest text-gray-400">Greetings, {{ session('member_name') }}</span>
                    <div class="w-10 h-10 border border-gray-100 p-1"><div class="w-full h-full bg-gray-200 rounded-full"></div></div>
                </div>
            </header>

            <div class="p-10 max-w-7xl w-full mx-auto">
                
                <!-- Filter Info Bar -->
                <div class="mb-6 flex flex-wrap gap-2">
                    @if($tableSizeFilter !== 'all')
                        <span class="text-[10px] bg-gray-100 px-3 py-1 rounded-full">
                            Table Filter: {{ $tableSizeOptions[$tableSizeFilter] ?? $tableSizeFilter }}
                        </span>
                    @endif
                    @if($privateRoomSizeFilter !== 'all')
                        <span class="text-[10px] bg-gray-100 px-3 py-1 rounded-full">
                            Room Filter: {{ $privateRoomSizeOptions[$privateRoomSizeFilter] ?? $privateRoomSizeFilter }}
                        </span>
                    @endif
                </div>

                <!-- Reservation Form -->
                <div class="bg-white border border-gray-100 p-10 shadow-sm relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-1 h-full accent-gold"></div>
                    
                    <div class="mb-8">
                        <h3 class="serif text-3xl text-gray-800">New Reservation</h3>
                        <p class="text-[11px] uppercase tracking-[0.2em] text-gray-400 mt-1">Book your gaming session</p>
                    </div>

                    @if ($errors->any())
                        <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 text-sm">
                            @foreach ($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif

                    <form method="GET" action="/reservation" id="filterForm" class="mb-8">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                            <div>
                                <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-1">Date</label>
                                <input type="date" name="reservation_date" value="{{ $selectedDate }}" class="w-full h-10 px-3 text-sm" min="{{ date('Y-m-d') }}">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-1">Time Slot</label>
                                <select name="time_slot" class="w-full h-10 px-3 text-sm">
                                    <option value="">Select time</option>
                                    <option value="10:00-13:00" {{ $selectedTimeSlot == '10:00-13:00' ? 'selected' : '' }}>10:00-13:00 (Morning)</option>
                                    <option value="13:00-16:00" {{ $selectedTimeSlot == '13:00-16:00' ? 'selected' : '' }}>13:00-16:00 (Afternoon)</option>
                                    <option value="16:00-19:00" {{ $selectedTimeSlot == '16:00-19:00' ? 'selected' : '' }}>16:00-19:00 (Evening)</option>
                                    <option value="19:00-22:00" {{ $selectedTimeSlot == '19:00-22:00' ? 'selected' : '' }}>19:00-22:00 (Night)</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-1">🍽️ Table Filter</label>
                                <select name="table_size_filter" class="w-full h-10 px-3 text-sm">
                                    @foreach($tableSizeOptions as $value => $label)
                                        <option value="{{ $value }}" {{ $tableSizeFilter == $value ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                                <p class="text-[8px] text-gray-400 mt-1">Filters standard & premium tables</p>
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-1">🚪 Private Room Filter</label>
                                <select name="private_room_size_filter" class="w-full h-10 px-3 text-sm">
                                    @foreach($privateRoomSizeOptions as $value => $label)
                                        <option value="{{ $value }}" {{ $privateRoomSizeFilter == $value ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                                <p class="text-[8px] text-gray-400 mt-1">Filters private rooms only</p>
                            </div>
                            <div class="flex items-end gap-2">
                                <button type="submit" class="accent-gold text-white text-[11px] font-bold uppercase tracking-[0.3em] px-4 py-2 h-10 hover:bg-black transition">
                                    Apply Filters
                                </button>
                                <button type="button" id="resetFiltersBtn" class="border border-gray-300 text-gray-500 text-[11px] font-bold uppercase tracking-[0.3em] px-4 py-2 h-10 hover:bg-gray-100 transition">
                                    Reset
                                </button>
                            </div>
                        </div>
                    </form>

                    <form method="POST" action="/reservation" id="reservationForm">
                        @csrf
                        <input type="hidden" name="reservation_date" value="{{ $selectedDate }}">
                        <input type="hidden" name="time_slot" value="{{ $selectedTimeSlot }}">

                        @if(!$selectedDate || !$selectedTimeSlot)
                            <div class="p-8 text-center bg-gray-50">
                                <i class="fas fa-filter text-4xl text-gray-300 mb-3"></i>
                                <p class="text-gray-500">Please select a date and time slot above to see available spaces.</p>
                            </div>
                        @elseif($spaces->count() == 0)
                            <div class="p-8 text-center bg-yellow-50">
                                <i class="fas fa-exclamation-triangle text-4xl text-yellow-500 mb-3"></i>
                                <p class="text-gray-600">No spaces match your current filters. Try adjusting your criteria.</p>
                                <button type="button" onclick="resetAllFilters()" class="mt-4 text-gold text-sm uppercase tracking-wider hover:underline">Reset All Filters</button>
                            </div>
                        @else
                            <div class="space-y-4">
                                <div class="flex justify-between items-center">
                                    <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-widest">Select Your Atmosphere <span class="text-red-500">*</span></label>
                                    <div class="text-[10px] text-gray-400">
                                        <span class="inline-flex items-center mr-3"><span class="w-2 h-2 bg-green-500 rounded-full mr-1"></span> Available</span>
                                        <span class="inline-flex items-center"><span class="w-2 h-2 bg-red-500 rounded-full mr-1"></span> Booked</span>
                                    </div>
                                </div>
                                
                                @error('space_id')
                                    <div class="text-red-500 text-xs mb-2">{{ $message }}</div>
                                @enderror
                                
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                    @foreach($spaces as $space)
                                        <label class="relative cursor-pointer group space-card {{ !$space->is_available ? 'disabled opacity-50' : '' }}">
                                            <input type="radio" name="space_id" value="{{ $space->id }}" class="peer hidden" {{ !$space->is_available ? 'disabled' : '' }} required>
                                            
                                            <div class="border-2 {{ $space->is_available ? 'border-gray-100 hover:border-gold' : 'border-red-200 bg-gray-50' }} overflow-hidden transition-all duration-500 peer-checked:border-gold peer-checked:shadow-lg">
                                                <div class="aspect-[4/3] bg-gray-200 flex flex-col items-center justify-center text-gray-300 relative">
                                                    @if(!$space->is_available)
                                                        <div class="absolute inset-0 bg-black/50 flex items-center justify-center">
                                                            <span class="text-white text-xs font-bold uppercase tracking-wider px-2 py-1 bg-red-600 rounded">Booked</span>
                                                        </div>
                                                    @endif
                                                    @if($space->type == 'private')
                                                        <i class="fas fa-door-closed text-3xl mb-2"></i>
                                                    @elseif($space->type == 'premium')
                                                        <i class="fas fa-crown text-3xl mb-2"></i>
                                                    @else
                                                        <i class="fas fa-couch text-3xl mb-2"></i>
                                                    @endif
                                                    <span class="text-[9px] uppercase tracking-widest">{{ $space->type }}</span>
                                                </div>
                                                <div class="p-4">
                                                    <div class="flex justify-between items-start">
                                                        <h4 class="serif text-lg text-gray-800">{{ $space->name }}</h4>
                                                        <span class="text-[8px] px-2 py-0.5 rounded {{ $space->type == 'private' ? 'bg-amber-100 text-amber-800' : 'bg-gray-100 text-gray-600' }}">
                                                            {{ $space->type }}
                                                        </span>
                                                    </div>
                                                    <p class="text-[9px] uppercase tracking-[0.2em] text-gold mt-1 flex items-center gap-2">
                                                        <i class="fas fa-users"></i> {{ $space->capacity }} players
                                                    </p>
                                                    <p class="text-[10px] text-gray-400 mt-2">{{ $space->description ?? '' }}</p>
                                                    @if(!$space->is_available)
                                                        <p class="text-[10px] text-red-500 mt-2">❌ Not available for this time slot</p>
                                                    @endif
                                                </div>
                                            </div>
                                            @if($space->is_available)
                                                <div class="absolute -top-2 -right-2 w-6 h-6 accent-gold rounded-full flex items-center justify-center opacity-0 peer-checked:opacity-100 transition-opacity">
                                                    <i class="fas fa-check text-white text-[10px]"></i>
                                                </div>
                                            @endif
                                        </label>
                                    @endforeach
                                </div>
                                <p class="text-[10px] text-gray-400 mt-2 italic">👆 Click on any available table/room above to select it</p>
                            </div>

                            <div class="flex justify-end gap-4 pt-8">
                                <button type="button" onclick="document.getElementById('reservationForm').reset()" 
                                    class="border border-gray-300 text-gray-500 text-[11px] font-bold uppercase tracking-[0.3em] px-8 py-4 hover:bg-gray-100 transition">
                                    Clear
                                </button>
                                <button type="submit" 
                                    class="accent-gold text-white text-[11px] font-bold uppercase tracking-[0.3em] px-12 py-4 hover:bg-black transition-all duration-500">
                                    Confirm Adventure
                                </button>
                            </div>
                        @endif
                    </form>
                </div>
            </div>

            <footer class="mt-auto p-10 text-center text-[10px] uppercase tracking-[0.3em] text-gray-400 border-t border-gray-50">
                © 2026 Meeple Corner Café — Established for the Strategic Mind
            </footer>
        </main>
    </div>

    <script>
        // Reset filters function - keeps date and time
        function resetAllFilters() {
            document.querySelector('select[name="table_size_filter"]').value = 'all';
            document.querySelector('select[name="private_room_size_filter"]').value = 'all';
            document.getElementById('filterForm').submit();
        }
        
        // Reset button handler
        document.getElementById('resetFiltersBtn').addEventListener('click', function() {
            resetAllFilters();
        });
        
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
        
        // Prevent selection of disabled spaces
        document.querySelectorAll('.space-card input[type="radio"]').forEach(radio => {
            if (radio.disabled) {
                radio.closest('.space-card').style.cursor = 'not-allowed';
            }
        });

        // Form validation
        document.getElementById('reservationForm')?.addEventListener('submit', function(e) {
            const selectedSpace = document.querySelector('input[name="space_id"]:checked');
            if (!selectedSpace) {
                e.preventDefault();
                alert('⚠️ Please select an available table or room before confirming your reservation.');
                
                document.querySelectorAll('.space-card:not(.disabled)').forEach(card => {
                    if (!card.querySelector('input:checked')) {
                        card.querySelector('div').classList.add('border-red-500', 'border-2');
                    }
                });
            }
        });
    </script>
</body>
</html>