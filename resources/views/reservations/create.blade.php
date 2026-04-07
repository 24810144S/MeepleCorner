<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600;700&family=Jost:wght@300;400;500;600&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { 
            background-color: #FDFCF6; /* Luxury Cream */
            font-family: 'Jost', sans-serif;
            color: #1A1A1A;
        }
        .serif { font-family: 'Cormorant Garamond', serif; }
        .sidebar { width: 260px; background-color: #1a1a1a; color: white; }
        .sidebar-item { transition: all 0.3s ease; letter-spacing: 0.1em; text-transform: uppercase; font-size: 11px; color: #9ca3af; }
        .sidebar-item:hover { color: #C5A059; }
        .sidebar-item.active { color: #C5A059; border-right: 3px solid #C5A059; background: linear-gradient(to right, #1a1a1a, #262626); }
        
        .accent-gold { background-color: #C5A059; }
        .text-gold { color: #C5A059; }
        
        /* Tricia Table Style */
        .table-header { background-color: #f8f8f2; color: #1a1a1a; border-bottom: 1px solid #e5e7eb; }
        input, select { 
            border: 1px solid #e5e7eb; 
            border-radius: 0 !important; 
            background-color: #fcfcfc;
        }
        input:focus, select:focus { border-color: #C5A059 !important; outline: none; }
    </style>
</head>
<body class="flex min-h-screen">

    <aside class="sidebar flex flex-col shrink-0">
        <div class="p-8">
            <div class="serif text-2xl font-bold tracking-tighter text-white">
                M<span class="text-gold">.</span>C
            </div>
            <p class="text-[10px] uppercase tracking-[0.3em] text-gray-500 mt-2">Boutique Admin</p>
        </div>

        <nav class="flex-1 px-4 space-y-2">
            <a href="/" class="sidebar-item flex items-center px-4 py-4 rounded-sm">
                <i class="fas fa-home w-6 text-xs"></i> <span>Home</span>
            </a>
            <a href="/reservation" class="sidebar-item active flex items-center px-4 py-4 rounded-sm">
                <i class="fas fa-calendar-alt w-6 text-xs"></i> <span>Reservations</span>
            </a>
            <a href="/reservation-history" class="sidebar-item flex items-center px-4 py-4 rounded-sm">
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

    <main class="flex-1 flex flex-col">
        
        <header class="h-20 bg-white border-b border-gray-100 flex items-center justify-between px-10 shrink-0">
            <div>
                <h2 class="serif text-2xl text-gray-800 italic">Table Management</h2>
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
                    <div class="w-full h-full bg-gray-200"></div>
                </div>
            </div>
        </header>

        <div class="p-10 max-w-6xl w-full mx-auto">
            
            <div class="bg-white border border-gray-100 p-10 mb-12 shadow-sm relative overflow-hidden">
                <div class="absolute top-0 left-0 w-1 h-full accent-gold"></div>
                
                <div class="mb-8">
                    <h3 class="serif text-3xl text-gray-800">New Reservation</h3>
                    <p class="text-[11px] uppercase tracking-[0.2em] text-gray-400 mt-1">Manual Entry System</p>
                </div>

                <form method="POST" action="/reservation" id="reservationForm" class="space-y-10">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-2">
                            <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-widest">Select Date</label>
                            <input type="date" name="reservation_date" required class="w-full h-12 px-4 text-sm" min="{{ date('Y-m-d') }}" value="{{ old('reservation_date') }}">
                        </div>
                        <div class="space-y-2">
                            <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-widest">Time Slot</label>
                            <select name="time_slot" required class="w-full h-12 px-4 text-sm">
                                <option value="">Select time slot</option>
                                <option value="10:00-13:00" {{ old('time_slot') == '10:00-13:00' ? 'selected' : '' }}>10:00 - 13:00</option>
                                <option value="13:00-16:00" {{ old('time_slot') == '13:00-16:00' ? 'selected' : '' }}>13:00 - 16:00</option>
                                <option value="16:00-19:00" {{ old('time_slot') == '16:00-19:00' ? 'selected' : '' }}>16:00 - 19:00</option>
                                <option value="19:00-22:00" {{ old('time_slot') == '19:00-22:00' ? 'selected' : '' }}>19:00 - 22:00</option>
                            </select>
                        </div>
                    </div>

                    <!-- Display validation errors -->
                    @if($errors->any())
                        <div class="p-4 bg-red-50 border-l-4 border-red-500 text-red-700 text-sm">
                            @foreach($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif

                    <div class="space-y-4">
                        <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-widest">Select Your Atmosphere <span class="text-red-500">*</span></label>
                        
                        @error('space_id')
                            <div class="text-red-500 text-xs mb-2">{{ $message }}</div>
                        @enderror
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            @foreach ($spaces as $space)
                                <label class="relative cursor-pointer group">
                                    <input type="radio" name="space_id" value="{{ $space->id }}" class="peer hidden" required>
                                    
                                    <div class="border border-gray-100 bg-white overflow-hidden transition-all duration-500 peer-checked:border-gold peer-checked:shadow-lg">
                                        <div class="aspect-[4/3] bg-gray-200 flex flex-col items-center justify-center text-gray-300">
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
                                            <h4 class="serif text-lg text-gray-800">{{ $space->name }}</h4>
                                            <p class="text-[9px] uppercase tracking-[0.2em] text-gold mt-1">{{ $space->capacity }} players</p>
                                            <p class="text-[10px] text-gray-400 mt-2">{{ $space->description ?? '' }}</p>
                                        </div>
                                    </div>
                                    <div class="absolute -top-2 -right-2 w-6 h-6 accent-gold rounded-full flex items-center justify-center opacity-0 peer-checked:opacity-100 transition-opacity">
                                        <i class="fas fa-check text-white text-[10px]"></i>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                        
                        <!-- Add a hint message -->
                        <p class="text-[10px] text-gray-400 mt-2 italic">Click on any table/room above to select it</p>
                    </div>

                    <div class="flex justify-end gap-4 pt-6">
                        <button type="button" onclick="document.getElementById('reservationForm').reset()" 
                            class="border border-gray-300 text-gray-500 text-[11px] font-bold uppercase tracking-[0.3em] px-8 py-4 hover:bg-gray-100 transition">
                            Clear
                        </button>
                        <button type="submit" 
                            class="accent-gold text-white text-[11px] font-bold uppercase tracking-[0.3em] px-12 py-4 hover:bg-black transition-all duration-500">
                            Confirm Adventure
                        </button>
                    </div>
                </form>
            </div>

                <div class="bg-white border border-gray-100 shadow-sm overflow-hidden">
                    <div class="p-8 border-b border-gray-50 flex justify-between items-end">
                        <div>
                            <h3 class="serif text-2xl text-gray-800 italic">Your Reservations</h3>
                            <p class="text-[10px] uppercase tracking-widest text-gray-400 mt-1">Your adventure history</p>
                        </div>
                    </div>
                    
                    @if(isset($reservations) && $reservations->count() > 0)
                        <table class="w-full text-left">
                            <thead>
                                <tr class="bg-gray-50 text-[10px] font-bold uppercase tracking-[0.2em]">
                                    <th class="px-8 py-5">Date</th>
                                    <th class="px-8 py-5">Time Slot</th>
                                    <th class="px-8 py-5">Table/Room</th>
                                    <th class="px-8 py-5 text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @foreach($reservations as $res)
                                <tr class="hover:bg-[#fdfcf6] transition-colors">
                                    <td class="px-8 py-6 text-xs text-gray-500">{{ \Carbon\Carbon::parse($res->reservation_date)->format('Y-m-d') }}</td>
                                    <td class="px-8 py-6 text-xs text-gray-600">{{ $res->time_slot }}</td>
                                    <td class="px-8 py-6 text-[11px] uppercase tracking-widest font-bold text-gray-800">
                                        <span class="border-l-2 border-gold pl-3">{{ $res->space->name }}</span>
                                    </td>
                                    <td class="px-8 py-6 text-right">
                                        @if($res->reservation_date >= date('Y-m-d'))
                                            <form method="POST" action="/reservation/{{ $res->id }}" onsubmit="return confirm('Cancel this reservation?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-gray-300 hover:text-red-600 transition-colors text-xs">
                                                    <i class="fas fa-trash-alt"></i> Cancel
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-xs text-gray-400">Completed</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="p-12 text-center">
                            <i class="fas fa-calendar-alt text-4xl text-gray-300 mb-4"></i>
                            <p class="text-gray-400 italic text-sm">No reservations yet. Book your first adventure above!</p>
                        </div>
                    @endif
                </div>

                <div class="p-6 bg-[#fcfcfc] border-t border-gray-50 flex justify-center">
                    <span class="text-[9px] text-gray-400 uppercase tracking-[0.4em] font-bold">End of Records</span>
                </div>
            </div>
        </div>

        <footer class="mt-auto p-10 text-center text-[10px] uppercase tracking-[0.3em] text-gray-400 border-t border-gray-50">
            © 2026 Meeple Corner Café — Established for the Strategic Mind
        </footer>
    </main>
<script>
    document.getElementById('reservationForm').addEventListener('submit', function(e) {
        const selectedSpace = document.querySelector('input[name="space_id"]:checked');
        if (!selectedSpace) {
            e.preventDefault();
            alert('⚠️ Please select a table or room before confirming your reservation.');
            
            // Highlight all space cards
            document.querySelectorAll('.space-card').forEach(card => {
                card.querySelector('div').classList.add('border-red-500', 'border-2');
            });
            
            // Scroll to spaces section
            document.querySelector('.space-card').scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    });
    
    // Remove highlight when a space is selected
    document.querySelectorAll('input[name="space_id"]').forEach(radio => {
        radio.addEventListener('change', function() {
            document.querySelectorAll('.space-card div').forEach(div => {
                div.classList.remove('border-red-500', 'border-2');
            });
        });
    });
</script>
</body>
</html>