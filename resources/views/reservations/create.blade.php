<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservations | Meeple Corner Café</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- GSAP -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>
    <!-- Canvas Confetti -->
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1"></script>
    <!-- tsParticles -->
    <script src="https://cdn.jsdelivr.net/npm/tsparticles@2.12.0/tsparticles.bundle.min.js"></script>
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
            --font-heading: 'Playfair Display', serif;
            --font-body: 'Inter', sans-serif;
            --transition: all 0.4s cubic-bezier(0.2, 0.9, 0.4, 1.1);
        }

        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            font-family: var(--font-body);
            background-color: var(--color-primary);
            color: var(--color-text);
            overflow-x: hidden;
        }

        /* noise texture */
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

        /* particles background */
        #tsparticles {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            pointer-events: none;
        }

        /* floating emoji */
        .floating-bg {
            position: fixed;
            bottom: 20px;
            right: 20px;
            font-size: 55px;
            opacity: 0.1;
            pointer-events: none;
            z-index: 1;
            animation: floatAround 20s infinite linear;
        }
        @keyframes floatAround {
            0% { transform: translateY(0px) rotate(0deg); opacity: 0.05; }
            50% { transform: translateY(-25px) rotate(8deg); opacity: 0.12; }
            100% { transform: translateY(0px) rotate(0deg); opacity: 0.05; }
        }

        /* main container */
        .main-container {
            flex: 1;
            max-width: 1400px;
            margin: 0 auto;
            padding: 2rem;
            width: 100%;
            position: relative;
            z-index: 2;
        }

        /* header */
        .page-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        .page-header h1 {
            font-family: var(--font-heading);
            font-size: 2.8rem;
            color: var(--color-white);
            margin-bottom: 0.5rem;
        }
        .page-header p {
            font-size: 0.8rem;
            color: var(--color-text-muted);
            letter-spacing: 0.2em;
        }

        /* filter card */
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

        /* space cards grid */
        .spaces-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 2rem;
            margin: 2rem 0;
        }

        /* space card */
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

        /* default gray card */
        .space-card-default {
            background: rgba(255,255,255,0.02);
            border: 1px solid rgba(212,165,116,0.1);
            border-radius: 28px;
            overflow: hidden;
            opacity: 0.5;
            cursor: not-allowed;
        }
        .space-card-default .space-image {
            filter: grayscale(0.5);
        }
        .space-card-default .space-name {
            color: var(--color-text-muted);
        }
        .space-card-default .space-capacity {
            background: rgba(212,165,116,0.1);
            color: var(--color-text-muted);
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

        /* pagination */
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

        /* action buttons */
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
        .btn-submit:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        /* alerts */
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

        /* loading overlay */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.7);
            z-index: 9999;
            display: none;
            justify-content: center;
            align-items: center;
        }
        .loading-spinner {
            width: 50px;
            height: 50px;
            border: 3px solid var(--color-accent);
            border-top-color: transparent;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* filter badge */
        .filter-badge {
            display: inline-block;
            background: rgba(212,165,116,0.15);
            color: var(--color-accent);
            font-size: 0.7rem;
            padding: 0.3rem 0.8rem;
            border-radius: 40px;
            margin-right: 0.5rem;
            margin-bottom: 0.5rem;
        }

        /* footer */
        .footer {
            background-color: #0c0704;
            padding: 2rem;
            text-align: center;
            border-top: 1px solid rgba(212,165,116,0.2);
            font-size: 0.7rem;
            color: var(--color-text-muted);
            letter-spacing: 0.1em;
            margin-top: 2rem;
        }

        @media (max-width: 768px) {
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
            .spaces-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>

    @include('layouts.navbar')

    <!-- Particles Background -->
    <div id="tsparticles"></div>
    <div class="floating-bg">🎲 🃏 🧩 🎯 🎲</div>

    <!-- Loading Overlay -->
    <div id="loadingOverlay" class="loading-overlay">
        <div class="loading-spinner"></div>
    </div>

    <main class="main-container">
        <div class="page-header">
            <h1>🎲 Book Your Adventure</h1>
            <p>Select a date, time, and your perfect gaming spot</p>
        </div>

        @if($tableSizeFilter !== 'all' || $isPrivateBooking)
            <div class="flex flex-wrap gap-2 mb-4">
                @if($tableSizeFilter !== 'all')
                    <span class="filter-badge">
                        <i class="fas fa-table"></i> Table: {{ $tableSizeOptions[$tableSizeFilter] ?? $tableSizeFilter }}
                    </span>
                @endif
                @if($isPrivateBooking)
                    <span class="filter-badge">
                        <i class="fas fa-door-closed"></i> Private Room Mode: ON
                    </span>
                @endif
            </div>
        @endif

        <div class="filter-card">
            @if ($errors->any())
                <div class="alert-error mb-6">
                    @foreach ($errors->all() as $error)
                        <p class="text-sm">{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <!-- Auto-submit form - no Apply Filters button -->
            <form method="GET" action="/reservation" id="filterForm">
                <div class="filter-grid">
                    <div>
                        <label class="filter-label">📅 Date</label>
                        <input type="date" name="reservation_date" id="reservation_date" value="{{ $selectedDate }}" class="filter-input auto-submit" min="{{ date('Y-m-d') }}">
                    </div>
                    <div>
                        <label class="filter-label">⏰ Start Time</label>
                        <select name="start_time" id="start_time" class="filter-select auto-submit">
                            <option value="">Select start</option>
                            @foreach($timeOptions as $time)
                                <option value="{{ $time }}" {{ $startTime == $time ? 'selected' : '' }}>{{ $time }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="filter-label">⏰ End Time</label>
                        <select name="end_time" id="end_time" class="filter-select auto-submit">
                            <option value="">Select end</option>
                            @foreach($timeOptions as $time)
                                <option value="{{ $time }}" {{ $endTime == $time ? 'selected' : '' }}>{{ $time }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="filter-label">📏 Table Size</label>
                        <select name="table_size_filter" id="table_size_filter" class="filter-select auto-submit">
                            @foreach($tableSizeOptions as $value => $label)
                                <option value="{{ $value }}" {{ $tableSizeFilter == $value ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="filter-label">🏠 Private Room</label>
                        <div class="flex items-center gap-2 mt-2">
                            <input type="checkbox" name="is_private_booking" id="is_private_booking" value="1" class="auto-submit" {{ $isPrivateBooking ? 'checked' : '' }}>
                            <label for="is_private_booking" class="text-sm text-white cursor-pointer">Book as Private Room</label>
                        </div>
                        <p class="text-[10px] text-gray-400 mt-1">(Medium/Large tables only)</p>
                    </div>
                </div>
                <p class="text-[10px] text-gray-400 mt-4 italic">⏰ Booking must be at least 2 hours, max 9 hours. Minutes must be 00 or 30. Hours: 08:00-22:00</p>
            </form>
        </div>

        <form method="POST" action="/reservation" id="reservationForm">
            @csrf
            <input type="hidden" name="reservation_date" value="{{ $selectedDate }}">
            <input type="hidden" name="start_time" value="{{ $startTime }}">
            <input type="hidden" name="end_time" value="{{ $endTime }}">
            <input type="hidden" name="is_private_booking" value="{{ $isPrivateBooking ? 1 : 0 }}">

            @if(!$selectedDate || !$startTime || !$endTime)
                <!-- Default state: Show all tables as gray (disabled) -->
                <div class="empty-state">
                    <i class="fas fa-calendar-alt text-5xl text-gold mb-4 opacity-50"></i>
                    <p class="text-gray-400">Please select a date, start time, and end time to see available spaces.</p>
                    <p class="text-xs text-gray-500 mt-2">Minimum 2 hours booking, maximum 9 hours.</p>
                </div>
                
                <!-- Show grayed out spaces as preview -->
                <div class="spaces-grid">
                    @foreach($spaces as $space)
                        <div class="space-card-default">
                            <div class="space-image">
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
                                <p class="space-description">{{ $space->description ?? 'A perfect spot for your gaming session.' }}</p>
                                <div class="text-[10px] text-gray-500 mt-2">Select date & time to check availability</div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination for default view -->
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
                    <button type="button" disabled class="btn-submit">Select Date & Time First</button>
                </div>
            @elseif($spaces->count() == 0)
                <div class="empty-state">
                    <i class="fas fa-exclamation-triangle text-5xl text-yellow-500 mb-4"></i>
                    <p class="text-gray-300">No spaces match your filters. Try adjusting your criteria.</p>
                    <button type="button" onclick="resetAllFilters()" class="btn-clear mt-4">Reset Filters</button>
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
                                @if($space->show_private_badge)
                                    <div class="text-[10px] text-amber-400 mt-1">🏠 Private Room Booking</div>
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
                    <button type="submit" class="btn-submit" id="confirmBtn">Review & Confirm</button>
                </div>
            @endif
        </form>
    </main>

    <footer class="footer">
        © 2026 Meeple Corner Café — Roll responsibly. Sip slowly. Play often.
    </footer>

    <script>
        // Initialize tsParticles
        tsParticles.load("tsparticles", {
            fpsLimit: 60,
            particles: {
                number: { value: 40, density: { enable: true, value_area: 800 } },
                color: { value: ["#d4a574", "#e8c9a9", "#2a9d8f", "#9b5de5"] },
                shape: { type: ["circle", "square", "triangle"] },
                opacity: { value: 0.3, random: true },
                size: { value: 5, random: true },
                move: { enable: true, speed: 1, direction: "none", random: true, straight: false, outModes: "out" }
            },
            interactivity: {
                events: { onHover: { enable: true, mode: "repulse" }, onClick: { enable: true, mode: "push" } }
            }
        });

        // GSAP animation
        gsap.from(".page-header", { opacity: 0, y: 30, duration: 0.8, ease: "power2.out" });
        gsap.from(".filter-card", { opacity: 0, y: 20, duration: 0.6, delay: 0.2 });

        // Auto-submit on any filter change
        const autoSubmitElements = document.querySelectorAll('.auto-submit');
        const filterForm = document.getElementById('filterForm');
        const loadingOverlay = document.getElementById('loadingOverlay');

        function showLoading() {
            loadingOverlay.style.display = 'flex';
        }

        function hideLoading() {
            loadingOverlay.style.display = 'none';
        }

        function autoSubmit() {
            if (filterForm) {
                showLoading();
                filterForm.submit();
            }
        }

        // Add event listeners to all auto-submit elements
        autoSubmitElements.forEach(element => {
            element.addEventListener('change', function() {
                // Validate time selection before submitting
                const startTime = document.getElementById('start_time')?.value;
                const endTime = document.getElementById('end_time')?.value;
                const selectedDate = document.getElementById('reservation_date')?.value;
                
                if (selectedDate && startTime && endTime) {
                    const startHour = parseInt(startTime.split(':')[0]);
                    const startMin = parseInt(startTime.split(':')[1]);
                    const endHour = parseInt(endTime.split(':')[0]);
                    const endMin = parseInt(endTime.split(':')[1]);
                    
                    const startTotal = startHour * 60 + startMin;
                    const endTotal = endHour * 60 + endMin;
                    const diffMinutes = endTotal - startTotal;
                    
                    if (diffMinutes < 120) {
                        alert('⚠️ Booking must be at least 2 hours.');
                        return;
                    }
                    if (diffMinutes > 540) {
                        alert('⚠️ Booking cannot exceed 9 hours.');
                        return;
                    }
                    if (startMin !== 0 && startMin !== 30) {
                        alert('⚠️ Start time minutes must be 00 or 30.');
                        return;
                    }
                    if (endMin !== 0 && endMin !== 30) {
                        alert('⚠️ End time minutes must be 00 or 30.');
                        return;
                    }
                }
                
                setTimeout(autoSubmit, 100);
            });
        });

        // Also trigger on checkbox click
        const privateCheckbox = document.getElementById('is_private_booking');
        if (privateCheckbox) {
            privateCheckbox.addEventListener('change', function() {
                setTimeout(autoSubmit, 100);
            });
        }

        function resetAllFilters() {
            document.getElementById('table_size_filter').value = 'all';
            document.getElementById('is_private_booking').checked = false;
            autoSubmit();
        }

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
        
        // Hide loading overlay when page loads
        window.addEventListener('load', function() {
            hideLoading();
        });
    </script>
</body>
</html>