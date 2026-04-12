<style>
    /* Sidebar base styles - FIXED POSITION */
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
    
    /* Main content wrapper - pushes content to the right */
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
        display: flex;
        align-items: center;
    }
    .sub-sidebar-item:hover { color: #C5A059; border-left-color: #C5A059; background: linear-gradient(to right, #1a1a1a, #222222); }
    .sub-sidebar-item.active { color: #C5A059; border-left-color: #C5A059; background: linear-gradient(to right, #1a1a1a, #262626); }
    .accent-gold { background-color: #C5A059; }
    .text-gold { color: #C5A059; }
    .serif { font-family: 'Cormorant Garamond', serif; }
</style>

<aside class="sidebar flex flex-col shrink-0">
    <div class="p-8">
        <div class="serif text-2xl font-bold tracking-tighter text-white">M<span class="text-gold">.</span>C</div>
        <p class="text-[10px] uppercase tracking-[0.3em] text-gray-500 mt-2">Boutique Cafe</p>
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