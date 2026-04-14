<style>
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
    
    .dropdown-menu { 
        max-height: 0; 
        overflow: hidden; 
        transition: max-height 0.3s ease; 
    }
    .dropdown-menu.show { 
        max-height: 400px; 
    }
    .rotate-icon { 
        transition: transform 0.3s ease; 
    }
    .rotate-icon.rotated { 
        transform: rotate(90deg); 
    }
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
    .sub-sidebar-item:hover { 
        color: #C5A059; 
        border-left-color: #C5A059; 
        background: linear-gradient(to right, #1a1a1a, #222222); 
    }
    .sub-sidebar-item.active { 
        color: #C5A059; 
        border-left-color: #C5A059; 
        background: linear-gradient(to right, #1a1a1a, #262626); 
    }
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
        <!-- Home -->
        <a href="/" class="sidebar-item flex items-center px-4 py-4 rounded-sm {{ Request::is('/') ? 'active' : '' }}" style="justify-content: flex-start;">
            <i class="fas fa-home w-5 text-xs mr-3"></i><span>Home</span>
        </a>
        
        <!-- Reservations -->
        <a href="/reservation" class="sidebar-item flex items-center px-4 py-4 rounded-sm {{ Request::is('reservation*') ? 'active' : '' }}" style="justify-content: flex-start;">
            <i class="fas fa-calendar-alt w-5 text-xs mr-3"></i><span>Reservations</span>
        </a>
        
        <!-- My Account Dropdown -->
        @php
            $isProfileActive = Request::is('profile*');
            $isInfoActive = Request::is('profile/info');
            $isEditActive = Request::is('profile/edit');
            $isHistoryActive = Request::is('profile/history');
        @endphp
        
        <div class="dropdown-container">
            <div class="sidebar-item dropdown-toggle flex items-center justify-between px-4 py-4 rounded-sm cursor-pointer {{ $isProfileActive ? 'active' : '' }}">
                <div class="flex items-center">
                    <i class="fas fa-user w-5 text-xs mr-3"></i><span>My Account</span>
                </div>
                <i class="fas fa-chevron-right rotate-icon text-[8px] transition-transform {{ $isProfileActive ? 'rotated' : '' }}"></i>
            </div>
            <div class="dropdown-menu ml-6 {{ $isProfileActive ? 'show' : '' }}">
                <a href="/profile/info" class="sub-sidebar-item {{ $isInfoActive ? 'active' : '' }}">
                    <i class="fas fa-id-card w-4 text-[10px] mr-3"></i> My Info
                </a>
                <a href="/profile/edit" class="sub-sidebar-item {{ $isEditActive ? 'active' : '' }}">
                    <i class="fas fa-edit w-4 text-[10px] mr-3"></i> Edit My Account
                </a>
                <a href="/profile/history" class="sub-sidebar-item {{ $isHistoryActive ? 'active' : '' }}">
                    <i class="fas fa-history w-4 text-[10px] mr-3"></i> Reservation History
                </a>
            </div>
        </div>
        
        <!-- Game Library -->
        
        <!-- Menu -->
        <a href="{{ route('menu') }}" class="sidebar-item flex items-center px-4 py-4 rounded-sm {{ Request::is('menu*') ? 'active' : '' }}" style="justify-content: flex-start;">
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

<script>
    // Wait for DOM to be fully loaded
    document.addEventListener('DOMContentLoaded', function() {
        // Get all dropdown toggles
        const dropdownToggles = document.querySelectorAll('.dropdown-toggle');
        
        // Function to close all dropdowns
        function closeAllDropdowns(exceptThis = null) {
            document.querySelectorAll('.dropdown-container').forEach(container => {
                if (exceptThis && container === exceptThis) return;
                const menu = container.querySelector('.dropdown-menu');
                const icon = container.querySelector('.rotate-icon');
                if (menu) menu.classList.remove('show');
                if (icon) icon.classList.remove('rotated');
            });
        }
        
        // Add click event to each dropdown toggle
        dropdownToggles.forEach(toggle => {
            toggle.addEventListener('click', function(event) {
                event.preventDefault();
                event.stopPropagation();
                
                const container = this.closest('.dropdown-container');
                const menu = container.querySelector('.dropdown-menu');
                const icon = this.querySelector('.rotate-icon');
                
                // Check if this dropdown is already open
                const isOpen = menu.classList.contains('show');
                
                // Close all dropdowns first
                closeAllDropdowns(container);
                
                // If it wasn't open, open it
                if (!isOpen) {
                    menu.classList.add('show');
                    icon.classList.add('rotated');
                }
            });
        });
        
        // Optional: Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            if (!event.target.closest('.dropdown-container')) {
                closeAllDropdowns();
            }
        });
    });
</script>