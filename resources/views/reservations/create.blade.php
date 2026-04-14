<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservations | Meeple Corner Café</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Canvas Confetti -->
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1"></script>
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
<<<<<<< Updated upstream
        /* ===== RESET & GLOBAL ===== */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
=======
        body { background-color: #FDFCF6; font-family: 'Jost', sans-serif; color: #1A1A1A; }
        .serif { font-family: 'Cormorant Garamond', serif; }
        .accent-gold { background-color: #C5A059; }
        .text-gold { color: #C5A059; }
        input, select { border: 1px solid #e5e7eb; background-color: #fcfcfc; }
        input:focus, select:focus { border-color: #C5A059; outline: none; }
        .space-card.disabled { opacity: 0.4; cursor: not-allowed; }
        .space-card.disabled:hover { transform: none; }
        
        /* Space card hover animations - matching game library */
        .space-card {
            transition: all 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.1);
        }
        
        .space-card:not(.disabled):hover {
            transform: translateY(-8px);
        }
        
        .space-card:not(.disabled):hover .space-card-image {
            transform: scale(1.05);
        }
        
        .space-card .space-card-image {
            transition: all 0.5s ease;
        }
        
        .space-card:not(.disabled):hover .space-card-icon {
            transform: scale(1.1) rotate(5deg);
        }
        
        .space-card:not(.disabled):hover .space-card-title {
            color: #C5A059;
        }
        
        .space-card:not(.disabled):hover .space-card-available {
            padding-left: 0.25rem;
        }
        
        .space-card .rounded-xl {
            border-radius: 1rem;
        }
        
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
>>>>>>> Stashed changes
        }

        :root {
            --color-primary: #1a0f07;
            --color-secondary: #2c1810;
            --color-accent: #d4a574;
            --color-accent-light: #e8c9a9;
            --color-white: #ffffff;
            --color-text: rgba(255, 255, 255, 0.82);
            --color-text-muted: rgba(255, 255, 255, 0.55);
            --spacing-xs: 0.75rem;
            --spacing-sm: 1.5rem;
            --spacing-md: 2.5rem;
            --spacing-lg: 5rem;
            --spacing-xl: 8rem;
            --font-heading: 'Playfair Display', serif;
            --font-body: 'Inter', sans-serif;
            --transition: all 0.4s cubic-bezier(0.2, 0.9, 0.4, 1.1);
        }

        /* FLEX STICKY FOOTER FIX */
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            font-family: var(--font-body);
            line-height: 1.6;
            background-color: var(--color-primary);
            color: var(--color-text);
            overflow-x: hidden;
        }

        /* subtle noise texture overlay */
        body::before {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 400 400' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.04'/%3E%3C/svg%3E");
            pointer-events: none;
            z-index: 1000;
        }

        /* ===== TYPOGRAPHY ===== */
        h1, h2, h3, .logo, .stat_number {
            font-family: var(--font-heading);
            font-weight: 500;
            letter-spacing: -0.02em;
        }

        /* ===== NAVBAR ===== */
        .navbar {
            position: relative;
            z-index: 20;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.5rem 2rem;
            background: rgba(26, 15, 7, 0.8);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(212, 165, 116, 0.2);
        }
        .logo {
            font-family: var(--font-heading);
            font-size: 1.8rem;
            font-weight: 600;
            color: var(--color-accent);
            text-decoration: none;
            transition: var(--transition);
        }
        .logo:hover {
            color: var(--color-accent-light);
            letter-spacing: 1px;
        }
        .nav-links {
            display: flex;
            gap: 2rem;
        }
        .nav-link {
            color: var(--color-text-muted);
            text-decoration: none;
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 0.2em;
            font-weight: 500;
            transition: var(--transition);
            position: relative;
        }
        .nav-link:hover {
            color: var(--color-accent);
        }
        .nav-link.active {
            color: var(--color-accent);
        }
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--color-accent);
            transition: width 0.3s ease;
        }
        .nav-link:hover::after,
        .nav-link.active::after {
            width: 100%;
        }
        .user-greeting {
            font-size: 0.7rem;
            color: var(--color-text-muted);
            letter-spacing: 0.1em;
        }
        .user-avatar {
            width: 2rem;
            height: 2rem;
            border-radius: 50%;
            border: 1px solid var(--color-accent);
            background: rgba(212,165,116,0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: var(--transition);
        }
        .user-avatar:hover {
            border-color: var(--color-accent-light);
            transform: scale(1.05);
        }

        /* ===== MAIN CONTAINER (pushes footer down) ===== */
        .main-container {
            flex: 1;
            max-width: 1400px;
            margin: 0 auto;
            padding: 2rem;
            width: 100%;
        }

        /* ===== FILTER CARD ===== */
        .filter-card {
            background: rgba(255,255,255,0.03);
            backdrop-filter: blur(8px);
            border-radius: 28px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            border: 1px solid rgba(212,165,116,0.15);
        }
        .filter-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 1rem;
            align-items: end;
        }
        .filter-label {
            display: block;
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 0.2em;
            color: var(--color-accent);
            margin-bottom: 0.5rem;
            font-weight: 600;
        }
        .filter-input, .filter-select {
            width: 100%;
            background: rgba(0,0,0,0.3);
            border: 1px solid rgba(212,165,116,0.3);
            border-radius: 40px;
            padding: 0.6rem 1rem;
            color: white;
            font-size: 0.85rem;
            transition: var(--transition);
        }
        .filter-input:focus, .filter-select:focus {
            outline: none;
            border-color: var(--color-accent);
        }
        .btn-filter {
            background: var(--color-accent);
            color: var(--color-primary);
            border: none;
            border-radius: 40px;
            padding: 0.6rem 1.2rem;
            font-size: 0.7rem;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            cursor: pointer;
            transition: var(--transition);
        }
        .btn-filter:hover {
            background: var(--color-accent-light);
            transform: translateY(-2px);
        }
        .btn-reset {
            background: transparent;
            border: 1px solid rgba(212,165,116,0.5);
            color: var(--color-accent);
        }
        .btn-reset:hover {
            background: rgba(212,165,116,0.1);
        }

        /* ===== SPACE CARDS ===== */
        .spaces-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 2rem;
            margin: 2rem 0;
        }
        .space-card {
            background: rgba(255,255,255,0.03);
            backdrop-filter: blur(4px);
            border-radius: 28px;
            overflow: hidden;
            transition: var(--transition);
            border: 1px solid rgba(212,165,116,0.1);
            cursor: pointer;
            position: relative;
        }
        .space-card:hover {
            transform: translateY(-8px);
            border-color: var(--color-accent);
            box-shadow: 0 20px 30px -12px rgba(0,0,0,0.5);
        }
        .space-card.selected {
            border: 2px solid var(--color-accent);
            box-shadow: 0 0 0 2px rgba(212,165,116,0.3);
        }
        .space-card.disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
        .space-card.disabled:hover {
            transform: none;
        }
        .space-image {
            height: 200px;
            background-size: cover;
            background-position: center;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: rgba(0,0,0,0.4);
        }
        .space-type-icon {
            font-size: 3rem;
            color: var(--color-accent);
            text-shadow: 0 2px 10px rgba(0,0,0,0.5);
        }
        .booked-badge {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: rgba(220, 38, 38, 0.9);
            color: white;
            font-size: 0.7rem;
            padding: 0.2rem 0.8rem;
            border-radius: 40px;
            font-weight: bold;
            backdrop-filter: blur(4px);
        }
        .space-content {
            padding: 1.5rem;
        }
        .space-name {
            font-size: 1.4rem;
            font-family: var(--font-heading);
            color: var(--color-white);
            margin-bottom: 0.5rem;
        }
        .space-capacity {
            display: inline-block;
            background: rgba(212,165,116,0.2);
            color: var(--color-accent);
            font-size: 0.7rem;
            padding: 0.2rem 0.8rem;
            border-radius: 30px;
            margin-bottom: 1rem;
        }
        .space-description {
            font-size: 0.85rem;
            color: var(--color-text-muted);
            line-height: 1.5;
            margin-bottom: 1rem;
        }
        .availability {
            font-size: 0.7rem;
            color: #4ade80;
            margin-top: 0.5rem;
        }
        .radio-select {
            position: absolute;
            top: 1rem;
            left: 1rem;
            width: 1.2rem;
            height: 1.2rem;
            accent-color: var(--color-accent);
            cursor: pointer;
            z-index: 2;
        }
        .space-card.disabled .radio-select {
            display: none;
        }

        /* ===== PAGINATION ===== */
        .pagination {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 0.5rem;
            margin-top: 2rem;
            padding-top: 1rem;
            border-top: 1px solid rgba(212,165,116,0.2);
        }
        .page-link {
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(212,165,116,0.2);
            border-radius: 40px;
            padding: 0.5rem 1rem;
            color: var(--color-text);
            font-size: 0.8rem;
            transition: var(--transition);
            text-decoration: none;
        }
        .page-link:hover, .page-link.active {
            background: var(--color-accent);
            color: var(--color-primary);
            border-color: var(--color-accent);
        }
        .page-disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
        .pagination-info {
            text-align: center;
            font-size: 0.7rem;
            color: var(--color-text-muted);
            margin-top: 1rem;
        }

        /* ===== ACTION BUTTONS ===== */
        .action-buttons {
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
            margin-top: 2rem;
            padding-top: 1rem;
            border-top: 1px solid rgba(212,165,116,0.2);
        }
        .btn-clear {
            background: transparent;
            border: 1px solid rgba(212,165,116,0.5);
            color: var(--color-accent);
            padding: 0.8rem 2rem;
            border-radius: 40px;
            font-size: 0.7rem;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            cursor: pointer;
            transition: var(--transition);
        }
        .btn-clear:hover {
            background: rgba(212,165,116,0.1);
        }
        .btn-submit {
            background: var(--color-accent);
            color: var(--color-primary);
            border: none;
            padding: 0.8rem 2.5rem;
            border-radius: 40px;
            font-size: 0.7rem;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            cursor: pointer;
            transition: var(--transition);
        }
        .btn-submit:hover {
            background: var(--color-accent-light);
            transform: translateY(-2px);
        }

        /* ===== ALERTS & EMPTY STATES ===== */
        .alert-error {
            background: rgba(220, 38, 38, 0.2);
            border-left: 4px solid #ef4444;
            padding: 1rem;
            border-radius: 16px;
            margin-bottom: 1.5rem;
            color: #fca5a5;
        }
        .empty-state {
            text-align: center;
            padding: 3rem;
            background: rgba(255,255,255,0.03);
            border-radius: 28px;
        }

        /* ===== FOOTER (sticky) ===== */
        .footer {
            background-color: #0c0704;
            padding: 2rem;
            text-align: center;
            border-top: 1px solid rgba(212,165,116,0.2);
            font-size: 0.7rem;
            color: var(--color-text-muted);
            letter-spacing: 0.1em;
        }

        @media (max-width: 768px) {
<<<<<<< Updated upstream
            .navbar {
                flex-direction: column;
                gap: 1rem;
                padding: 1rem;
            }
            .nav-links {
                gap: 1rem;
                flex-wrap: wrap;
                justify-content: center;
            }
            .main-container {
                padding: 1rem;
            }
            .filter-grid {
                grid-template-columns: 1fr;
            }
            .action-buttons {
                flex-direction: column;
            }
            .btn-clear, .btn-submit {
                width: 100%;
                text-align: center;
            }
=======
            .sidebar { width: 70px; overflow-x: hidden; }
            .sidebar .sidebar-item span, .sidebar .sub-sidebar-item span { display: none; }
            .sidebar .sidebar-item { justify-content: center !important; padding: 12px 0 !important; }
            .sidebar .sidebar-item i { margin-right: 0 !important; font-size: 16px !important; }
            .dropdown-toggle .flex.items-center { justify-content: center; }
            .dropdown-toggle .flex.items-center span { display: none; }
            .dropdown-menu { margin-left: 0 !important; }
            .sub-sidebar-item span { display: none; }
            .main-wrapper { margin-left: 70px; }
            .grid { grid-template-columns: 1fr !important; }
            .p-10 { padding: 1rem !important; }
            .gap-6 { gap: 1rem !important; }
            .filter-grid { grid-template-columns: 1fr !important; }
        }
        
        @media (max-width: 1024px) and (min-width: 769px) {
            .grid { grid-template-columns: repeat(2, 1fr) !important; }
>>>>>>> Stashed changes
        }
    </style>
</head>
<body>

    <!-- NAVBAR -->
    <nav class="navbar">
        <a href="/" class="logo">Meeple Corner Café</a>
        <div class="nav-links">
            <a href="/" class="nav-link">Home</a>
            <a href="/board-games" class="nav-link">Board Games</a>
            <a href="/events" class="nav-link">Events</a>
            <a href="/reservation" class="nav-link active">Reservations</a>
            <a href="/menu" class="nav-link">Menu</a>
        </div>
        <div class="flex items-center gap-4">
            <span class="user-greeting">Welcome, {{ session('member_name', 'Guest') }}</span>
            <a href="/profile/info" class="user-avatar">
                <i class="fas fa-user text-gold text-sm"></i>
            </a>
            @auth
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="text-[10px] uppercase tracking-widest text-red-400 hover:text-red-300">
                        <i class="fas fa-sign-out-alt mr-1"></i> Exit
                    </button>
                </form>
            @endauth
        </div>
    </nav>

    <!-- MAIN CONTENT (flex:1 ensures footer is pushed down) -->
    <main class="main-container">
        @if($tableSizeFilter !== 'all' || $privateRoomSizeFilter !== 'all')
            <div class="flex flex-wrap gap-2 mb-4">
                @if($tableSizeFilter !== 'all')
                    <span class="text-[10px] bg-white/10 px-3 py-1 rounded-full text-gold">
                        Table: {{ $tableSizeOptions[$tableSizeFilter] ?? $tableSizeFilter }}
                    </span>
                @endif
                @if($privateRoomSizeFilter !== 'all')
                    <span class="text-[10px] bg-white/10 px-3 py-1 rounded-full text-gold">
                        Room: {{ $privateRoomSizeOptions[$privateRoomSizeFilter] ?? $privateRoomSizeFilter }}
                    </span>
                @endif
            </div>
        @endif

        <div class="filter-card">
            <h2 class="serif text-3xl text-white mb-2">Book Your Adventure</h2>
            <p class="text-sm text-text-muted mb-6">Select a date, time, and your perfect gaming spot.</p>

            @if ($errors->any())
                <div class="alert-error mb-6">
                    @foreach ($errors->all() as $error)
                        <p class="text-sm">{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="GET" action="/reservation" id="filterForm">
                <div class="filter-grid">
                    <div>
                        <label class="filter-label">Date</label>
                        <input type="date" name="reservation_date" value="{{ $selectedDate }}" class="filter-input" min="{{ date('Y-m-d') }}">
                    </div>
                    <div>
                        <label class="filter-label">Time Slot</label>
                        <select name="time_slot" class="filter-select">
                            <option value="">Select time</option>
                            <option value="10:00-13:00" {{ $selectedTimeSlot == '10:00-13:00' ? 'selected' : '' }}>10:00-13:00 (Morning)</option>
                            <option value="13:00-16:00" {{ $selectedTimeSlot == '13:00-16:00' ? 'selected' : '' }}>13:00-16:00 (Afternoon)</option>
                            <option value="16:00-19:00" {{ $selectedTimeSlot == '16:00-19:00' ? 'selected' : '' }}>16:00-19:00 (Evening)</option>
                            <option value="19:00-22:00" {{ $selectedTimeSlot == '19:00-22:00' ? 'selected' : '' }}>19:00-22:00 (Night)</option>
                        </select>
                    </div>
                    <div>
                        <label class="filter-label">Table Capacity</label>
                        <select name="table_size_filter" class="filter-select">
                            @foreach($tableSizeOptions as $value => $label)
                                <option value="{{ $value }}" {{ $tableSizeFilter == $value ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="filter-label">Room Capacity</label>
                        <select name="private_room_size_filter" class="filter-select">
                            @foreach($privateRoomSizeOptions as $value => $label)
                                <option value="{{ $value }}" {{ $privateRoomSizeFilter == $value ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex gap-2">
                        <button type="submit" class="btn-filter">Apply Filters</button>
                        <button type="button" id="resetFiltersBtn" class="btn-filter btn-reset">Reset</button>
                    </div>
                </div>
            </form>
        </div>

        <form method="POST" action="/reservation" id="reservationForm">
            @csrf
            <input type="hidden" name="reservation_date" value="{{ $selectedDate }}">
            <input type="hidden" name="time_slot" value="{{ $selectedTimeSlot }}">

            @if(!$selectedDate || !$selectedTimeSlot)
                <div class="empty-state">
                    <i class="fas fa-calendar-alt text-5xl text-gold mb-4 opacity-50"></i>
                    <p class="text-gray-400">Please select a date and time slot to see available spaces.</p>
                </div>
<<<<<<< Updated upstream
            @elseif($spaces->count() == 0)
                <div class="empty-state">
                    <i class="fas fa-exclamation-triangle text-5xl text-yellow-500 mb-4"></i>
                    <p class="text-gray-300">No spaces match your filters. Try adjusting your criteria.</p>
                    <button type="button" onclick="resetAllFilters()" class="btn-filter mt-4">Reset Filters</button>
                </div>
            @else
                <div class="spaces-grid">
                    @foreach($spaces as $space)
                        <label class="space-card {{ !$space->is_available ? 'disabled' : '' }} {{ old('space_id') == $space->id ? 'selected' : '' }}">
                            <input type="radio" name="space_id" value="{{ $space->id }}" class="radio-select" {{ !$space->is_available ? 'disabled' : '' }} {{ old('space_id') == $space->id ? 'checked' : '' }} required>
                            <div class="space-image">
                                @if(!$space->is_available)
                                    <div class="booked-badge">Booked</div>
                                @endif
                                <div class="space-type-icon">
                                    @if($space->type == 'private')
                                        <i class="fas fa-door-closed"></i>
                                    @elseif($space->type == 'premium')
                                        <i class="fas fa-crown"></i>
                                    @else
                                        <i class="fas fa-couch"></i>
                                    @endif
                                </div>
                            </div>
                            <div class="space-content">
                                <h3 class="space-name">{{ $space->name }}</h3>
                                <span class="space-capacity"><i class="fas fa-users mr-1"></i> {{ $space->capacity }} players</span>
                                @if($space->is_available)
                                    <div class="availability">✓ Available</div>
                                @endif
                                <p class="space-description">{{ $space->description ?? 'A perfect spot for your gaming session.' }}</p>
                                @if(!$space->is_available)
                                    <p class="text-red-400 text-xs mt-2">Not available for this time slot</p>
                                @endif
=======
            </header>

            <div class="p-4 md:p-10 max-w-7xl w-full mx-auto">
                
                <!-- Reservation Form -->
                <div class="bg-white border border-gray-100 p-4 md:p-10 shadow-sm relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-1 h-full accent-gold"></div>
                    
                    <div class="mb-6 md:mb-8">
                        <h3 class="serif text-2xl md:text-3xl text-gray-800">New Reservation</h3>
                        <p class="text-[10px] md:text-[11px] uppercase tracking-[0.2em] text-gray-400 mt-1">Book your gaming session</p>
                    </div>

                    @if ($errors->any())
                        <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 text-sm">
                            @foreach ($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif

                    <!-- Filter Section - Auto-refresh on change -->
                    <div class="filter-grid grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 mb-8">
                        <div>
                            <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-1">Date</label>
                            <input type="date" id="reservation_date" name="reservation_date" class="w-full h-10 px-3 text-sm filter-input" min="{{ date('Y-m-d') }}" value="{{ $selectedDate }}">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-1">Start Time</label>
                            <select id="start_time" name="start_time" class="w-full h-10 px-3 text-sm filter-input">
                                <option value="">Select start</option>
                                @foreach($timeOptions as $time)
                                    <option value="{{ $time }}" {{ $startTime == $time ? 'selected' : '' }}>{{ $time }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-1">End Time</label>
                            <select id="end_time" name="end_time" class="w-full h-10 px-3 text-sm filter-input">
                                <option value="">Select end</option>
                                @foreach($timeOptions as $time)
                                    <option value="{{ $time }}" {{ $endTime == $time ? 'selected' : '' }}>{{ $time }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-1">Table Size</label>
                            <select id="size_filter" name="size_filter" class="w-full h-10 px-3 text-sm filter-input">
                                @foreach($sizeOptions as $value => $label)
                                    <option value="{{ $value }}" {{ $sizeFilter == $value ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex items-center gap-3">
                            <input type="checkbox" id="is_private_booking" name="is_private_booking" value="1" class="w-4 h-4 accent-gold filter-input" {{ $isPrivateBooking ? 'checked' : '' }}>
                            <label for="is_private_booking" class="text-[11px] font-bold text-gray-500 uppercase tracking-widest cursor-pointer">
                                🏠 Book as Private Room
                            </label>
                        </div>
                    </div>
                    <p class="text-[9px] text-gray-400 mb-6 italic">⏰ Booking must be at least 2 hours, max 9 hours. Minutes must be 00 or 30. Hours: 08:00-22:00</p>

                    <!-- Hidden filter form for auto-submit -->
                    <form method="GET" action="/reservation" id="filterForm" style="display: none;">
                        <input type="hidden" name="reservation_date" id="filter_date">
                        <input type="hidden" name="start_time" id="filter_start_time">
                        <input type="hidden" name="end_time" id="filter_end_time">
                        <input type="hidden" name="size_filter" id="filter_size">
                        <input type="hidden" name="is_private_booking" id="filter_private">
                    </form>

                    <!-- Main Reservation Form -->
                    <form method="POST" action="/reservation" id="reservationForm">
                        @csrf
                        
                        <!-- Hidden fields to submit the selected values -->
                        <input type="hidden" name="reservation_date" value="{{ $selectedDate }}">
                        <input type="hidden" name="start_time" value="{{ $startTime }}">
                        <input type="hidden" name="end_time" value="{{ $endTime }}">
                        <input type="hidden" name="size_filter" value="{{ $sizeFilter }}">
                        <input type="hidden" name="is_private_booking" value="{{ $isPrivateBooking ? 1 : 0 }}">

                        @if(!$selectedDate || !$startTime || !$endTime)
                            <!-- Default state: Show all tables as gray (disabled) -->
                            <div class="space-y-4">
                                <div class="flex justify-between items-center">
                                    <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-widest">Select Your Atmosphere <span class="text-red-500">*</span></label>
                                    <div class="text-[10px] flex gap-4">
                                        <span class="text-gray-400">⭘ Select date & time first</span>
                                    </div>
                                </div>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                    @foreach($spaces as $space)
                                        <div class="relative space-card disabled opacity-40">
                                            <div class="border-2 border-gray-200 bg-gray-100 overflow-hidden rounded-xl">
                                                <div class="aspect-[4/3] bg-gray-200 flex flex-col items-center justify-center text-gray-400">
                                                    @if($space->type == 'premium')
                                                        <i class="fas fa-crown text-3xl mb-2"></i>
                                                    @else
                                                        <i class="fas fa-couch text-3xl mb-2"></i>
                                                    @endif
                                                    <span class="text-[9px] uppercase tracking-widest text-gray-500">{{ $space->type }}</span>
                                                </div>
                                                <div class="p-4">
                                                    <h4 class="serif text-lg text-gray-500">{{ $space->name }}</h4>
                                                    <p class="text-[9px] uppercase tracking-[0.2em] text-gray-400 mt-2">
                                                        <i class="fas fa-users"></i> {{ $space->capacity }} players
                                                    </p>
                                                    <p class="text-[10px] text-gray-400 mt-2">{{ $space->description ?? '' }}</p>
                                                    <div class="mt-3 pt-2">
                                                        <span class="text-[9px] text-gray-400 uppercase tracking-wider">Select date & time first</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                
                                <!-- Pagination for default view -->
                                @if($spaces->lastPage() > 1)
                                    <div class="flex flex-wrap justify-center items-center gap-2 mt-8 pt-4 border-t border-gray-100">
                                        @if($spaces->onFirstPage())
                                            <span class="px-3 py-2 bg-gray-100 text-gray-400 rounded-lg text-sm cursor-not-allowed">← Previous</span>
                                        @else
                                            <a href="{{ $spaces->appends(request()->query())->previousPageUrl() }}" class="px-3 py-2 bg-white border border-gray-300 text-gray-600 rounded-lg text-sm hover:border-gold">← Previous</a>
                                        @endif
                                        <div class="flex flex-wrap gap-1">
                                            @foreach(range(1, $spaces->lastPage()) as $page)
                                                @if($page == $spaces->currentPage())
                                                    <span class="px-3 py-2 accent-gold text-white rounded-lg text-sm">{{ $page }}</span>
                                                @else
                                                    <a href="{{ $spaces->appends(request()->query())->url($page) }}" class="px-3 py-2 bg-white border border-gray-300 text-gray-600 rounded-lg text-sm hover:border-gold">{{ $page }}</a>
                                                @endif
                                            @endforeach
                                        </div>
                                        @if($spaces->hasMorePages())
                                            <a href="{{ $spaces->appends(request()->query())->nextPageUrl() }}" class="px-3 py-2 bg-white border border-gray-300 text-gray-600 rounded-lg text-sm hover:border-gold">Next →</a>
                                        @else
                                            <span class="px-3 py-2 bg-gray-100 text-gray-400 rounded-lg text-sm cursor-not-allowed">Next →</span>
                                        @endif
                                    </div>
                                    <div class="text-center text-[10px] text-gray-400 mt-4">Showing {{ $spaces->firstItem() }} to {{ $spaces->lastItem() }} of {{ $spaces->total() }} spaces</div>
                                @endif
                            </div>
                            
                            <div class="flex justify-end gap-4 pt-8">
                                <button type="button" onclick="document.getElementById('reservationForm').reset()" class="border border-gray-300 text-gray-500 text-[11px] font-bold uppercase tracking-[0.3em] px-6 md:px-8 py-3 md:py-4 hover:bg-gray-100 transition">Clear</button>
                                <button type="button" disabled class="bg-gray-300 text-white text-[11px] font-bold uppercase tracking-[0.3em] px-6 md:px-12 py-3 md:py-4 cursor-not-allowed">Select Date & Time First</button>
                            </div>
                        @elseif($spaces->count() == 0)
                            <div class="p-8 text-center bg-yellow-50">
                                <i class="fas fa-exclamation-triangle text-4xl text-yellow-500 mb-3"></i>
                                <p class="text-gray-600">No spaces match your current filters. Try adjusting your criteria.</p>
                            </div>
                        @else
                            <div class="space-y-4">
                                <div class="flex justify-between items-center">
                                    <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-widest">Select Your Atmosphere <span class="text-red-500">*</span></label>
                                    <div class="text-[10px] flex gap-4">
                                        <span class="text-green-600">✓ Available</span>
                                        <span class="text-gray-400">⭘ Booked</span>
                                    </div>
                                </div>
                                
                                @error('space_id')
                                    <div class="text-red-500 text-xs mb-2">{{ $message }}</div>
                                @enderror
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                    @foreach($spaces as $space)
                                        <label class="relative cursor-pointer group space-card {{ !$space->is_available ? 'disabled opacity-40' : '' }}">
                                            <input type="radio" name="space_id" value="{{ $space->id }}" class="peer hidden" {{ !$space->is_available ? 'disabled' : '' }} required>
                                            
                                            <div class="border-2 {{ $space->is_available ? 'border-gray-100 hover:border-gold' : 'border-gray-200 bg-gray-100' }} overflow-hidden transition-all duration-300 peer-checked:border-gold peer-checked:shadow-lg rounded-xl">
                                                <div class="aspect-[4/3] bg-gray-100 flex flex-col items-center justify-center text-gray-400 relative overflow-hidden space-card-image">
                                                    @if(!$space->is_available)
                                                        <div class="absolute inset-0 bg-gray-300/50 flex items-center justify-center z-10">
                                                            <span class="text-gray-500 text-xs font-bold uppercase tracking-wider px-2 py-1 bg-gray-200 rounded">Booked</span>
                                                        </div>
                                                    @endif
                                                    @if($space->type == 'premium')
                                                        <i class="fas fa-crown text-3xl mb-2 transition-transform duration-300 space-card-icon"></i>
                                                    @else
                                                        <i class="fas fa-couch text-3xl mb-2 transition-transform duration-300 space-card-icon"></i>
                                                    @endif
                                                    <span class="text-[9px] uppercase tracking-widest text-gray-500">{{ $space->type }}</span>
                                                </div>
                                                <div class="p-4">
                                                    <h4 class="serif text-lg text-gray-800 transition-colors duration-300 space-card-title">{{ $space->name }}</h4>
                                                    <p class="text-[9px] uppercase tracking-[0.2em] text-gray-400 mt-2 flex items-center gap-2">
                                                        <i class="fas fa-users"></i> {{ $space->capacity }} players
                                                    </p>
                                                    <p class="text-[10px] text-gray-400 mt-2">{{ $space->description ?? '' }}</p>
                                                    
                                                    <!-- Available text at bottom left corner -->
                                                    @if($space->is_available)
                                                        <div class="mt-3 pt-2">
                                                            <span class="text-[9px] text-green-600 uppercase tracking-wider transition-all duration-300 space-card-available">
                                                                ✓ Available
                                                            </span>
                                                        </div>
                                                    @else
                                                        <div class="mt-3 pt-2">
                                                            <span class="text-[9px] text-gray-400 uppercase tracking-wider">⭘ Not Available</span>
                                                        </div>
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
                                
                                @if($spaces->lastPage() > 1)
                                    <div class="flex flex-wrap justify-center items-center gap-2 mt-8 pt-4 border-t border-gray-100">
                                        @if($spaces->onFirstPage())
                                            <span class="px-3 py-2 bg-gray-100 text-gray-400 rounded-lg text-sm cursor-not-allowed">← Previous</span>
                                        @else
                                            <a href="{{ $spaces->appends(request()->query())->previousPageUrl() }}" class="px-3 py-2 bg-white border border-gray-300 text-gray-600 rounded-lg text-sm hover:border-gold">← Previous</a>
                                        @endif
                                        <div class="flex flex-wrap gap-1">
                                            @foreach(range(1, $spaces->lastPage()) as $page)
                                                @if($page == $spaces->currentPage())
                                                    <span class="px-3 py-2 accent-gold text-white rounded-lg text-sm">{{ $page }}</span>
                                                @else
                                                    <a href="{{ $spaces->appends(request()->query())->url($page) }}" class="px-3 py-2 bg-white border border-gray-300 text-gray-600 rounded-lg text-sm hover:border-gold">{{ $page }}</a>
                                                @endif
                                            @endforeach
                                        </div>
                                        @if($spaces->hasMorePages())
                                            <a href="{{ $spaces->appends(request()->query())->nextPageUrl() }}" class="px-3 py-2 bg-white border border-gray-300 text-gray-600 rounded-lg text-sm hover:border-gold">Next →</a>
                                        @else
                                            <span class="px-3 py-2 bg-gray-100 text-gray-400 rounded-lg text-sm cursor-not-allowed">Next →</span>
                                        @endif
                                    </div>
                                    <div class="text-center text-[10px] text-gray-400 mt-4">Showing {{ $spaces->firstItem() }} to {{ $spaces->lastItem() }} of {{ $spaces->total() }} spaces</div>
                                @endif
                            </div>

                            <div class="flex justify-end gap-4 pt-8">
                                <button type="reset" onclick="document.getElementById('reservationForm').reset()" class="border border-gray-300 text-gray-500 text-[11px] font-bold uppercase tracking-[0.3em] px-6 md:px-8 py-3 md:py-4 hover:bg-gray-100 transition">Clear</button>
                                <button type="submit" class="accent-gold text-white text-[11px] font-bold uppercase tracking-[0.3em] px-6 md:px-12 py-3 md:py-4 hover:bg-black transition">Confirm Adventure</button>
>>>>>>> Stashed changes
                            </div>
                        </label>
                    @endforeach
                </div>

                @if($spaces->lastPage() > 1)
                    <div class="pagination">
                        @if($spaces->onFirstPage())
                            <span class="page-link page-disabled">← Previous</span>
                        @else
                            <a href="{{ $spaces->appends(request()->query())->previousPageUrl() }}" class="page-link">← Previous</a>
                        @endif

                        @foreach(range(1, $spaces->lastPage()) as $page)
                            @if($page == $spaces->currentPage())
                                <span class="page-link active">{{ $page }}</span>
                            @else
                                <a href="{{ $spaces->appends(request()->query())->url($page) }}" class="page-link">{{ $page }}</a>
                            @endif
                        @endforeach

                        @if($spaces->hasMorePages())
                            <a href="{{ $spaces->appends(request()->query())->nextPageUrl() }}" class="page-link">Next →</a>
                        @else
                            <span class="page-link page-disabled">Next →</span>
                        @endif
                    </div>
                    <div class="pagination-info">
                        Showing {{ $spaces->firstItem() }} to {{ $spaces->lastItem() }} of {{ $spaces->total() }} spaces
                    </div>
                @endif

                <div class="action-buttons">
                    <button type="reset" class="btn-clear" id="clearFormBtn">Clear Selection</button>
                    <button type="submit" class="btn-submit" id="confirmBtn">Confirm Adventure</button>
                </div>
            @endif
        </form>
    </main>

    <footer class="footer">
        © 2026 Meeple Corner Café — Roll responsibly. Sip slowly. Play often.
    </footer>

    <script>
<<<<<<< Updated upstream
        // GSAP is not loaded, so remove or keep only if you add GSAP CDN.
        // We'll keep only the essential JS without GSAP to avoid errors.
        function resetAllFilters() {
            document.querySelector('select[name="table_size_filter"]').value = 'all';
            document.querySelector('select[name="private_room_size_filter"]').value = 'all';
            document.getElementById('filterForm').submit();
        }

        const resetBtn = document.getElementById('resetFiltersBtn');
        if (resetBtn) resetBtn.addEventListener('click', resetAllFilters);

        const clearBtn = document.getElementById('clearFormBtn');
        if (clearBtn) {
            clearBtn.addEventListener('click', function(e) {
                e.preventDefault();
                document.querySelectorAll('input[name="space_id"]').forEach(radio => {
                    radio.checked = false;
                    radio.closest('.space-card')?.classList.remove('selected');
                });
            });
        }

        document.querySelectorAll('.space-card input[type="radio"]').forEach(radio => {
            radio.addEventListener('change', function() {
                document.querySelectorAll('.space-card').forEach(card => card.classList.remove('selected'));
                if (this.checked) this.closest('.space-card').classList.add('selected');
            });
            if (radio.checked) radio.closest('.space-card').classList.add('selected');
        });

        @if(session('reservation_success'))
            canvasConfetti({ particleCount: 200, spread: 100, origin: { y: 0.6 }, colors: ['#d4a574', '#e8c9a9', '#ffffff'] });
        @endif

        const confirmBtn = document.getElementById('confirmBtn');
        if (confirmBtn) {
            confirmBtn.addEventListener('click', function(e) {
                const selected = document.querySelector('input[name="space_id"]:checked');
                if (!selected) {
                    e.preventDefault();
                    alert('⚠️ Please select an available table or room before confirming.');
                    return;
=======
        // Auto-refresh when any filter changes
        const filterInputs = document.querySelectorAll('.filter-input');
        const filterForm = document.getElementById('filterForm');
        
        function submitFilters() {
            if (!filterForm) return;
            
            // Get current values
            const date = document.getElementById('reservation_date').value;
            const startTime = document.getElementById('start_time').value;
            const endTime = document.getElementById('end_time').value;
            const sizeFilter = document.getElementById('size_filter').value;
            const isPrivate = document.getElementById('is_private_booking').checked ? '1' : '';
            
            // Validate time range if both times are selected
            if (date && startTime && endTime) {
                const start = new Date(`2000-01-01T${startTime}:00`);
                const end = new Date(`2000-01-01T${endTime}:00`);
                const diffHours = (end - start) / (1000 * 60 * 60);
                
                if (diffHours < 2) {
                    alert('⚠️ Booking must be at least 2 hours.');
                    return;
                }
                if (diffHours > 9) {
                    alert('⚠️ Booking cannot exceed 9 hours.');
                    return;
                }
                
                const startMinutes = parseInt(startTime.split(':')[1]);
                const endMinutes = parseInt(endTime.split(':')[1]);
                
                if (![0, 30].includes(startMinutes)) {
                    alert('⚠️ Start time minutes must be 00 or 30.');
                    return;
                }
                if (![0, 30].includes(endMinutes)) {
                    alert('⚠️ End time minutes must be 00 or 30.');
                    return;
                }
            }
            
            // Set hidden form values
            document.getElementById('filter_date').value = date;
            document.getElementById('filter_start_time').value = startTime;
            document.getElementById('filter_end_time').value = endTime;
            document.getElementById('filter_size').value = sizeFilter;
            document.getElementById('filter_private').value = isPrivate;
            
            // Submit the form
            filterForm.submit();
        }
        
        // Add event listeners to all filter inputs
        filterInputs.forEach(input => {
            input.addEventListener('change', function() {
                setTimeout(submitFilters, 100);
            });
        });
        
        // Also trigger on checkbox change
        const privateCheckbox = document.getElementById('is_private_booking');
        if (privateCheckbox) {
            privateCheckbox.addEventListener('change', function() {
                setTimeout(submitFilters, 100);
            });
        }
        
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
        
        // Form validation for main submission
        const reservationForm = document.getElementById('reservationForm');
        if (reservationForm) {
            reservationForm.addEventListener('submit', function(e) {
                const selectedSpace = document.querySelector('input[name="space_id"]:checked');
                if (!selectedSpace) {
                    e.preventDefault();
                    alert('⚠️ Please select an available table or room before confirming your reservation.');
>>>>>>> Stashed changes
                }
                canvasConfetti({ particleCount: 150, spread: 80, origin: { y: 0.5 }, colors: ['#d4a574', '#ffffff'] });
            });
        }
    </script>
</body>
</html>