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
        .table-header { background-color: #f8f8f2; border-bottom: 1px solid #e5e7eb; }
        input, select { border: 1px solid #e5e7eb; background-color: #fcfcfc; }
        input:focus, select:focus { border-color: #C5A059 !important; outline: none; }
        
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

        <aside class="sidebar flex flex-col shrink-0" style="background-color: #1a1a1a;">
            <div class="p-8">
                <div class="serif text-2xl font-bold tracking-tighter text-white">M<span class="text-gold">.</span>C</div>
                <p class="text-[10px] uppercase tracking-[0.3em] text-gray-500 mt-2">Boutique Admin</p>
            </div>
            <nav class="flex-1 px-4 space-y-2">
                <!-- Home -->
                <a href="/" class="sidebar-item flex items-center px-4 py-4 rounded-sm" style="justify-content: flex-start;">
                    <i class="fas fa-home w-5 text-xs mr-3"></i><span>Home</span>
                </a>
                
                <!-- Reservations -->
                <a href="/reservation" class="sidebar-item flex items-center px-4 py-4 rounded-sm" style="justify-content: flex-start;">
                    <i class="fas fa-calendar-alt w-5 text-xs mr-3"></i><span>Reservations</span>
                </a>
                
                <!-- My Account Dropdown -->
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
                
                <!-- Game Library -->
                <a href="{{ route('board-games') }}" class="sidebar-item flex items-center px-4 py-4 rounded-sm" style="justify-content: flex-start;">
                    <i class="fas fa-chess-knight w-5 text-xs mr-3"></i><span>Game Library</span>
                </a>
                
                <!-- Menu (ACTIVE) -->
                <a href="{{ route('menu') }}" class="sidebar-item active flex items-center px-4 py-4 rounded-sm" style="justify-content: flex-start;">
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

        <main class="flex-1 flex flex-col">
            <header class="h-20 bg-white border-b border-gray-100 flex items-center justify-between px-10 shrink-0">
                <div><h2 class="serif text-2xl text-gray-800 italic">Our Menu</h2></div>
                <div class="flex items-center space-x-6">
                    <span class="text-[11px] uppercase tracking-widest text-gray-400">
                        @if(session()->has('member_name')) Greetings, {{ session('member_name') }} @else Greetings, Guest @endif
                    </span>
                    <div class="w-10 h-10 border border-gray-100 p-1"><div class="w-full h-full bg-gray-200"></div></div>
                </div>
            </header>

            <div class="p-10 max-w-7xl w-full mx-auto">
                <div class="bg-white border border-gray-100 p-8 shadow-sm">
                    <div class="mb-8 border-b border-gray-100 pb-4">
                        <h3 class="serif text-3xl text-gray-800 italic">Kitchen & Bar</h3>
                        <p class="text-[11px] uppercase tracking-[0.2em] text-gray-400 mt-1">Curated for the discerning palate</p>
                    </div>

                    @forelse($groupedMenu as $category => $items)
                        <div class="mb-12">
                            <h4 class="text-[13px] font-bold uppercase tracking-[0.3em] text-gold mb-4">{{ $category }}</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                @foreach($items as $item)
                                    <div class="flex justify-between items-start border-b border-gray-50 pb-3 hover:bg-gray-50/30 px-2 transition">
                                        <div class="flex-1">
                                            <div class="flex items-center gap-3">
                                                @if($item->image)
                                                    <img src="{{ asset('storage/'.$item->image) }}" class="w-12 h-12 object-cover grayscale hover:grayscale-0 transition">
                                                @else
                                                    <div class="w-12 h-12 bg-gray-100 flex items-center justify-center text-gray-300"><i class="fas fa-utensils"></i></div>
                                                @endif
                                                <div>
                                                    <h5 class="font-bold text-gray-800 tracking-wide">{{ $item->name }}</h5>
                                                    <p class="text-[10px] text-gray-400 uppercase tracking-wider">{{ $item->description }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <span class="text-gold font-bold text-sm ml-4">${{ number_format($item->price, 2) }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-gray-400 py-8">No menu items available yet.</p>
                    @endforelse
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