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
            <a href="#" class="sidebar-item flex items-center px-4 py-4 rounded-sm">
                <i class="fas fa-th-large w-6 text-xs"></i> <span>Overview</span>
            </a>
            <a href="#" class="sidebar-item active flex items-center px-4 py-4 rounded-sm">
                <i class="fas fa-calendar-alt w-6 text-xs"></i> <span>Reservations</span>
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

                

            <form method="POST" action="/reservation" class="space-y-10">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-2">
                        <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-widest">Select Date</label>
                        <input type="date" name="reservation_date" required class="w-full h-12 px-4 text-sm">
                    </div>
                    <div class="space-y-2">
                        <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-widest">Time Slot</label>
                        <select name="time_slot" required class="w-full h-12 px-4 text-sm">
                            <option>14:00 - 17:00</option>
                            <option>17:00 - 20:00</option>
                            <option>20:00 - 23:00</option>
                        </select>
                    </div>
                </div>

                <div class="space-y-4">
                    <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-widest">Select Your Atmosphere</label>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @foreach ($spaces as $space)
                            <label class="relative cursor-pointer group">
                                <input type="radio" name="space_id" value="{{ $space->id }}" class="peer hidden" required>
                                
                                <div class="border border-gray-100 bg-white overflow-hidden transition-all duration-500 peer-checked:border-gold peer-checked:shadow-lg">
                                    <div class="aspect-[4/3] bg-gray-200 relative overflow-hidden">
                                        @if($space->image)
                                            <img src="/images/{{ $space->image }}" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-700">
                                        @else
                                            <div class="w-full h-full flex flex-col items-center justify-center text-gray-300">
                                                <i class="fas fa-couch text-3xl mb-2"></i>
                                                <span class="text-[9px] uppercase tracking-widest">No Preview</span>
                                            </div>
                                        @endif
                                        <div class="absolute bottom-0 right-0 bg-black/80 text-white text-[9px] px-3 py-1 uppercase tracking-tighter">
                                            {{ $space->capacity }} Seats
                                        </div>
                                    </div>

                                    <div class="p-4">
                                        <h4 class="serif text-lg text-gray-800">{{ $space->name }}</h4>
                                        <p class="text-[9px] uppercase tracking-[0.2em] text-gold mt-1">{{ $space->type }}</p>
                                    </div>
                                </div>

                                <div class="absolute -top-2 -right-2 w-6 h-6 accent-gold rounded-full flex items-center justify-center opacity-0 peer-checked:opacity-100 transition-opacity">
                                    <i class="fas fa-check text-white text-[10px]"></i>
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="flex justify-end pt-6">
                    <button type="submit" 
                        class="accent-gold text-white text-[11px] font-bold uppercase tracking-[0.3em] px-12 py-5 hover:bg-black transition-all duration-500">
                        Confirm Adventure
                    </button>
                </div>
            </form>
            </div>

            <div class="bg-white border border-gray-100 shadow-sm overflow-hidden">
                <div class="p-8 border-b border-gray-50 flex justify-between items-end">
                    <div>
                        <h3 class="serif text-2xl text-gray-800 italic">Past Adventures</h3>
                        <p class="text-[10px] uppercase tracking-widest text-gray-400 mt-1">Reservation Archive</p>
                    </div>
                    <button class="text-[11px] uppercase tracking-widest text-gold font-bold border-b border-gold pb-1">Export PDF</button>
                </div>
                <table class="w-full text-left">
                    <thead>
                        <tr class="table-header text-[10px] font-bold uppercase tracking-[0.2em]">
                            <th class="px-8 py-5">Date</th>
                            <th class="px-8 py-5">Time Window</th>
                            <th class="px-8 py-5">Designated Table</th>
                            <th class="px-8 py-5 text-right">Manage</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($reservations as $res)
                        <tr class="hover:bg-[#fdfcf6] transition-colors">
                            <td class="px-8 py-6 text-xs text-gray-500 tracking-wider">{{ $res->reservation_date }}</td>
                            <td class="px-8 py-6 text-xs text-gray-600 font-medium">{{ $res->time_slot }}</td>
                            <td class="px-8 py-6 text-[11px] uppercase tracking-widest font-bold text-gray-800">
                                <span class="border-l-2 border-gold pl-3">{{ $res->space->name }}</span>
                            </td>
                            <td class="px-8 py-6 text-right">
                                <button class="text-gray-300 hover:text-gold transition-colors mx-2 text-xs"><i class="fas fa-edit"></i></button>
                                <button class="text-gray-300 hover:text-red-800 transition-colors mx-2 text-xs"><i class="fas fa-trash-alt"></i></button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="p-16 text-center text-gray-300 italic text-sm serif">The archive is currently empty.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="p-6 bg-[#fcfcfc] border-t border-gray-50 flex justify-center">
                    <span class="text-[9px] text-gray-400 uppercase tracking-[0.4em] font-bold">End of Records</span>
                </div>
            </div>
        </div>

        <footer class="mt-auto p-10 text-center text-[10px] uppercase tracking-[0.3em] text-gray-400 border-t border-gray-50">
            © 2026 Meeple Corner Café — Established for the Strategic Mind
        </footer>
    </main>

</body>
</html>