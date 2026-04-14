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
    <style>
        /* ===== RESET & GLOBAL ===== */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
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
                }
                canvasConfetti({ particleCount: 150, spread: 80, origin: { y: 0.5 }, colors: ['#d4a574', '#ffffff'] });
            });
        }
    </script>
</body>
</html>