<!-- resources/views/layouts/navbar.blade.php -->
<nav class="navbar">
    <div class="navbar-container">
        <a href="/" class="logo">Meeple Corner Café</a>
        <button class="mobile-menu-btn" id="mobileMenuBtn">
            <i class="fas fa-bars"></i>
        </button>
        <div class="nav-links" id="navLinks">
            <a href="/" class="nav-link {{ Request::is('/') ? 'active' : '' }}">Home</a>
            <a href="{{ route('board-games.index') }}" class="nav-link {{ Request::is('board-games*') ? 'active' : '' }}">Board Games</a>
            <a href="/reservation" class="nav-link {{ Request::is('reservation*') ? 'active' : '' }}">Reservations</a>
            <a href="{{ route('menu') }}" class="nav-link {{ Request::is('menu*') ? 'active' : '' }}">Menu</a>
        </div>
        <div class="relative" id="userMenu">
            <button id="userMenuBtn" class="user-menu-button">
                @if(session()->has('member_id'))
                    <span class="user-greeting">Welcome, {{ session('member_nickname', 'Member') }}</span>
                    <div class="user-avatar">{{ strtoupper(substr(session('member_nickname', 'G'), 0, 1)) }}</div>
                @else
                    <span class="user-greeting">Welcome, Guest</span>
                    <div class="user-avatar"><i class="fas fa-user text-sm"></i></div>
                @endif
                <i class="fas fa-chevron-down dropdown-arrow"></i>
            </button>
            <div id="userDropdown" class="user-dropdown">
                @if(session()->has('member_id'))
                    <a href="/profile/info" class="dropdown-item"><i class="fas fa-id-card"></i> My Info</a>
                    <a href="/profile/edit" class="dropdown-item"><i class="fas fa-edit"></i> Edit Profile</a>
                    <a href="/profile/history" class="dropdown-item"><i class="fas fa-history"></i> Reservation History</a>
                    <hr class="dropdown-divider">
                    <form method="POST" action="{{ route('logout') }}" class="dropdown-logout">
                        @csrf
                        <button type="submit" class="dropdown-item signout-btn">
                            <i class="fas fa-sign-out-alt"></i> Sign Out
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="dropdown-item"><i class="fas fa-sign-in-alt"></i> Sign In</a>
                @endif
            </div>
        </div>
    </div>
</nav>

<style>
    /* ===== NAVBAR STYLES ===== */
    .navbar {
        position: relative;
        z-index: 20;
        background: rgba(26, 15, 7, 0.8);
        backdrop-filter: blur(12px);
        border-bottom: 1px solid rgba(212, 165, 116, 0.2);
        padding: 1rem 2rem;
    }
    .navbar-container {
        max-width: 1400px;
        margin: 0 auto;
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        width: 100%;
    }
    .logo {
        font-family: 'Playfair Display', serif;
        font-size: 1.8rem;
        font-weight: 600;
        color: #d4a574;
        text-decoration: none;
        transition: all 0.4s ease;
        margin-right: 2rem;
    }
    .logo:hover {
        color: #e8c9a9;
        letter-spacing: 1px;
    }
    .mobile-menu-btn {
        display: none;
        background: none;
        border: none;
        color: #d4a574;
        font-size: 1.5rem;
        cursor: pointer;
    }
    .nav-links {
        display: flex;
        gap: 2rem;
        margin: 0 auto;
    }
    .nav-link {
        color: rgba(255, 255, 255, 0.55);
        text-decoration: none;
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 0.2em;
        font-weight: 500;
        transition: all 0.4s ease;
        position: relative;
    }
    .nav-link:hover, .nav-link.active {
        color: #d4a574;
    }
    .nav-link.active::after {
        content: '';
        position: absolute;
        bottom: -8px;
        left: 0;
        width: 100%;
        height: 2px;
        background: #d4a574;
    }
    #userMenu {
        margin-left: auto;
        flex-shrink: 0;
    }
    .user-menu-button {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        background: none;
        border: none;
        cursor: pointer;
        padding: 0.25rem 0.5rem;
        border-radius: 40px;
        transition: all 0.3s ease;
    }
    .user-menu-button:hover {
        background: rgba(212, 165, 116, 0.1);
    }
    .user-greeting {
        font-size: 0.7rem;
        color: rgba(255, 255, 255, 0.55);
        letter-spacing: 0.1em;
    }
    .user-avatar {
        width: 2rem;
        height: 2rem;
        border-radius: 50%;
        border: 1px solid #d4a574;
        background: rgba(212, 165, 116, 0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #d4a574;
        font-weight: bold;
        font-size: 0.8rem;
        transition: all 0.3s ease;
    }
    .user-menu-button:hover .user-avatar {
        transform: scale(1.05);
        border-color: #e8c9a9;
    }
    .dropdown-arrow {
        font-size: 0.7rem;
        color: #d4a574;
        transition: transform 0.3s ease;
    }
    .user-dropdown {
        position: absolute;
        right: 0;
        top: calc(100% + 0.75rem);
        width: 220px;
        background: #1a1a1a;
        border: 1px solid rgba(212, 165, 116, 0.3);
        border-radius: 1rem;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(8px);
        z-index: 50;
        display: none;
        overflow: hidden;
        animation: dropdownFade 0.2s ease;
    }
    .user-dropdown.show {
        display: block;
    }
    .dropdown-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.75rem 1rem;
        color: #d1d5db;
        text-decoration: none;
        font-size: 0.85rem;
        transition: all 0.2s ease;
    }
    .dropdown-item i {
        width: 1.25rem;
        color: #d4a574;
    }
    .dropdown-item:hover {
        background: rgba(212, 165, 116, 0.1);
        color: #d4a574;
    }
    .dropdown-divider {
        margin: 0.5rem 0;
        border-color: rgba(212, 165, 116, 0.2);
    }
    /* Sign Out button - not white by default */
    /* Sign Out button - no white background */
    .dropdown-logout .signout-btn {
        color: #f87171;
        background: transparent !important;
        transition: all 0.2s ease;
    }
    .dropdown-logout .signout-btn i {
        color: #f87171;
    }
    .dropdown-logout .signout-btn:hover {
        background: rgba(220, 38, 38, 0.2) !important;
        color: #ff6b6b !important;
    }
    .dropdown-logout .signout-btn:hover i {
        color: #ff6b6b !important;
    }
    
    @keyframes dropdownFade {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    @media (max-width: 768px) {
        .navbar {
            padding: 1rem;
        }
        .mobile-menu-btn {
            display: block;
        }
        .nav-links {
            display: none;
            flex-direction: column;
            width: 100%;
            gap: 1rem;
            margin: 1rem 0 0 0;
            padding-top: 1rem;
            border-top: 1px solid rgba(212, 165, 116, 0.2);
            align-items: center;
        }
        .nav-links.show {
            display: flex;
        }
        .user-menu-button .user-greeting {
            display: none;
        }
        .user-dropdown {
            right: -1rem;
            width: 200px;
        }
        .navbar-container {
            justify-content: space-between;
        }
        .nav-links {
            order: 3;
            margin: 0;
        }
        #userMenu {
            margin-left: auto;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const mobileBtn = document.getElementById('mobileMenuBtn');
        const navLinks = document.getElementById('navLinks');
        if (mobileBtn && navLinks) {
            mobileBtn.addEventListener('click', () => {
                navLinks.classList.toggle('show');
            });
        }

        const userBtn = document.getElementById('userMenuBtn');
        const userDropdown = document.getElementById('userDropdown');
        const arrow = document.querySelector('.dropdown-arrow');

        function toggleDropdown(e) {
            e.stopPropagation();
            const isOpen = userDropdown.classList.contains('show');
            if (isOpen) {
                userDropdown.classList.remove('show');
                if (arrow) arrow.style.transform = 'rotate(0deg)';
            } else {
                userDropdown.classList.add('show');
                if (arrow) arrow.style.transform = 'rotate(180deg)';
            }
        }

        if (userBtn && userDropdown) {
            userBtn.addEventListener('click', toggleDropdown);
        }

        document.addEventListener('click', function(e) {
            if (userBtn && !userBtn.contains(e.target) && userDropdown) {
                userDropdown.classList.remove('show');
                if (arrow) arrow.style.transform = 'rotate(0deg)';
            }
        });
    });
</script>