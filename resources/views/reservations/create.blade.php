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

        /* ===== ENHANCED FILTER CARD ===== */
        .filter-card {
            background: rgba(255,255,255,0.03);
            backdrop-filter: blur(8px);
            border-radius: 28px;
            padding: 1.8rem;
            margin-bottom: 2rem;
            border: 1px solid rgba(212,165,116,0.15);
            transition: var(--transition);
        }
        .filter-card:hover {
            border-color: rgba(212,165,116,0.3);
        }
        .filter-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.2rem;
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
        .filter-label i {
            margin-right: 0.4rem;
        }
        .filter-input, .filter-select {
            width: 100%;
            background: rgba(0,0,0,0.3);
            border: 1px solid rgba(212,165,116,0.3);
            border-radius: 40px;
            padding: 0.7rem 1.2rem;
            color: white;
            font-size: 0.85rem;
            transition: var(--transition);
        }
        .filter-input:focus, .filter-select:focus {
            outline: none;
            border-color: var(--color-accent);
            background: rgba(0,0,0,0.5);
        }
        .filter-hint {
            font-size: 0.7rem;
            color: var(--color-accent);
            margin-top: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        /* ===== EMPTY STATE ===== */
        .empty-state-wrapper {
            text-align: center;
            padding: 3rem 2rem;
            background: linear-gradient(135deg, rgba(212,165,116,0.05), rgba(0,0,0,0.2));
            border-radius: 32px;
            border: 1px dashed rgba(212,165,116,0.3);
            margin: 2rem 0;
        }
        .empty-state-icon {
            width: 80px;
            height: 80px;
            background: rgba(212,165,116,0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            border: 1px solid rgba(212,165,116,0.3);
        }
        .empty-state-icon i {
            font-size: 2.5rem;
            color: var(--color-accent);
        }
        .empty-state-title {
            font-family: var(--font-heading);
            font-size: 1.5rem;
            color: var(--color-white);
            margin-bottom: 0.5rem;
        }
        .empty-state-message {
            color: var(--color-text-muted);
            font-size: 0.9rem;
            margin-bottom: 1rem;
        }
        .empty-state-rules {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 1rem;
            margin-top: 1.5rem;
        }
        .rule-badge {
            background: rgba(212,165,116,0.1);
            padding: 0.4rem 1rem;
            border-radius: 40px;
            font-size: 0.7rem;
            color: var(--color-accent);
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        /* space cards grid */
        .spaces-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 2rem;
            margin: 2rem 0;
        }

        /* space card - clickable */
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

        /* ===== MODAL STYLES ===== */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.85);
            backdrop-filter: blur(8px);
            z-index: 9999;
            display: none;
            justify-content: center;
            align-items: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        .modal-overlay.show {
            display: flex;
            opacity: 1;
        }
        .modal-container {
            max-width: 500px;
            width: 90%;
            background: linear-gradient(135deg, #1a1a1a, #0f0f0f);
            border-radius: 32px;
            border: 1px solid rgba(212,165,116,0.3);
            overflow: hidden;
            transform: scale(0.9);
            transition: transform 0.3s ease;
            box-shadow: 0 25px 50px -12px rgba(0,0,0,0.5);
        }
        .modal-overlay.show .modal-container {
            transform: scale(1);
        }
        .modal-header {
            padding: 1.2rem 1.5rem;
            background: rgba(0,0,0,0.3);
            border-bottom: 1px solid rgba(212,165,116,0.2);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .modal-header h3 {
            font-family: var(--font-heading);
            font-size: 1.4rem;
            color: var(--color-white);
            margin: 0;
        }
        .modal-close {
            background: none;
            border: none;
            color: var(--color-text-muted);
            font-size: 1.5rem;
            cursor: pointer;
            transition: var(--transition);
        }
        .modal-close:hover {
            color: var(--color-accent);
            transform: rotate(90deg);
        }
        .modal-body {
            padding: 1.5rem;
        }
        .modal-space-image {
            width: 100%;
            height: 200px;
            background-size: cover;
            background-position: center;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: rgba(0,0,0,0.4);
            margin-bottom: 1.5rem;
        }
        .modal-space-name {
            font-size: 1.8rem;
            font-family: var(--font-heading);
            color: var(--color-white);
            margin-bottom: 0.5rem;
        }
        .modal-space-details {
            display: flex;
            gap: 1rem;
            margin: 1rem 0;
            flex-wrap: wrap;
        }
        .modal-detail-badge {
            background: rgba(212,165,116,0.15);
            padding: 0.3rem 0.8rem;
            border-radius: 40px;
            font-size: 0.7rem;
            color: var(--color-accent);
        }
        .modal-space-description {
            color: var(--color-text-muted);
            font-size: 0.9rem;
            line-height: 1.6;
            margin: 1rem 0;
        }
        .recommended-game {
            background: rgba(212,165,116,0.08);
            border-left: 3px solid var(--color-accent);
            padding: 1rem;
            border-radius: 16px;
            margin: 1rem 0;
        }
        .recommended-game h4 {
            font-size: 0.8rem;
            color: var(--color-accent);
            margin-bottom: 0.5rem;
        }
        .recommended-game-list {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-top: 0.5rem;
        }
        .game-tag {
            background: rgba(212,165,116,0.1);
            padding: 0.2rem 0.6rem;
            border-radius: 20px;
            font-size: 0.7rem;
            color: var(--color-text);
        }
        .modal-footer {
            padding: 1rem 1.5rem 1.5rem;
        }
        .modal-book-btn {
            width: 100%;
            background: var(--color-accent);
            color: var(--color-primary);
            border: none;
            border-radius: 40px;
            padding: 1rem;
            font-size: 0.8rem;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.2em;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.8rem;
        }
        .modal-book-btn:hover {
            background: var(--color-accent-light);
            transform: translateY(-2px);
        }

        /* ===== PAGINATION - ORIGINAL STYLE ===== */
        .pagination {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 0.5rem;
            margin-top: 2rem;
            padding-top: 1rem;
            border-top: 1px solid rgba(212,165,116,0.2);
        }
        .pagination .page-link {
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(212,165,116,0.2);
            border-radius: 40px;
            padding: 0.5rem 1rem;
            color: var(--color-text);
            font-size: 0.8rem;
            transition: var(--transition);
            text-decoration: none;
            display: inline-block;
        }
        .pagination .page-link:hover {
            background: var(--color-accent);
            color: var(--color-primary);
            border-color: var(--color-accent);
        }
        .pagination .active span {
            background: var(--color-accent);
            color: var(--color-primary);
            border-color: var(--color-accent);
        }
        .pagination .disabled span {
            opacity: 0.5;
            cursor: not-allowed;
        }
        .pagination-info {
            text-align: center;
            font-size: 0.7rem;
            color: var(--color-text-muted);
            margin-top: 1rem;
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

        /* loading overlay */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.7);
            z-index: 9998;
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
            .spaces-grid {
                grid-template-columns: 1fr;
            }
            .modal-container {
                width: 95%;
            }
            .empty-state-rules {
                flex-direction: column;
                align-items: center;
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

    <!-- Modal Popup -->
    <div id="spaceModal" class="modal-overlay">
        <div class="modal-container">
            <div class="modal-header">
                <h3><i class="fas fa-chair text-gold mr-2"></i> Table Details</h3>
                <button class="modal-close" onclick="closeModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <div id="modalSpaceImage" class="modal-space-image">
                    <i class="fas fa-couch text-5xl text-gold"></i>
                </div>
                <h2 id="modalSpaceName" class="modal-space-name"></h2>
                <div class="modal-space-details">
                    <span id="modalCapacity" class="modal-detail-badge"><i class="fas fa-users"></i> 0 players</span>
                    <span id="modalType" class="modal-detail-badge"><i class="fas fa-tag"></i> Standard</span>
                    <span id="modalStatus" class="modal-detail-badge"><i class="fas fa-check-circle"></i> Available</span>
                </div>
                <p id="modalDescription" class="modal-space-description"></p>
                <div class="recommended-game">
                    <h4><i class="fas fa-dice-d6 mr-2"></i> Recommended Games</h4>
                    <div id="recommendedGameList" class="recommended-game-list">
                        Loading...
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button id="modalBookBtn" class="modal-book-btn" onclick="bookSelectedSpace()">
                    <i class="fas fa-calendar-check"></i> BOOK THIS TABLE
                </button>
            </div>
        </div>
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

        <!-- ENHANCED FILTER CARD -->
        <div class="filter-card">
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
                        <label class="filter-label"><i class="fas fa-calendar-alt"></i> Date</label>
                        <input type="date" name="reservation_date" id="reservation_date" value="{{ $selectedDate }}" class="filter-input auto-submit" min="{{ date('Y-m-d') }}">
                    </div>
                    <div>
                        <label class="filter-label"><i class="fas fa-hourglass-start"></i> Start Time</label>
                        <select name="start_time" id="start_time" class="filter-select auto-submit">
                            <option value="">Select start</option>
                            @foreach($timeOptions as $time)
                                <option value="{{ $time }}" {{ $startTime == $time ? 'selected' : '' }}>{{ $time }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="filter-label"><i class="fas fa-hourglass-end"></i> End Time</label>
                        <select name="end_time" id="end_time" class="filter-select auto-submit">
                            <option value="">Select end</option>
                            @foreach($timeOptions as $time)
                                <option value="{{ $time }}" {{ $endTime == $time ? 'selected' : '' }}>{{ $time }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="filter-label"><i class="fas fa-arrows-alt"></i> Table Size</label>
                        <select name="table_size_filter" id="table_size_filter" class="filter-select auto-submit">
                            @foreach($tableSizeOptions as $value => $label)
                                <option value="{{ $value }}" {{ $tableSizeFilter == $value ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="filter-label"><i class="fas fa-door-closed"></i> Private Room</label>
                        <div class="flex items-center gap-2 mt-2">
                            <input type="checkbox" name="is_private_booking" id="is_private_booking" value="1" class="auto-submit w-4 h-4 accent-gold" {{ $isPrivateBooking ? 'checked' : '' }}>
                            <label for="is_private_booking" class="text-sm text-white cursor-pointer">Book as Private Room</label>
                        </div>
                        <div class="filter-hint">
                            <i class="fas fa-info-circle"></i> Medium/Large tables only
                        </div>
                    </div>
                </div>
                <div class="filter-hint mt-4 justify-center">
                    <i class="fas fa-clock"></i> Booking: min 2h, max 9h | Minutes: 00 or 30 | Hours: 08:00-22:00
                </div>
            </form>
        </div>

        <form method="POST" action="/reservation" id="reservationForm">
            @csrf
            <input type="hidden" name="reservation_date" id="form_date" value="{{ $selectedDate }}">
            <input type="hidden" name="start_time" id="form_start_time" value="{{ $startTime }}">
            <input type="hidden" name="end_time" id="form_end_time" value="{{ $endTime }}">
            <input type="hidden" name="table_size_filter" id="form_table_size" value="{{ $tableSizeFilter }}">
            <input type="hidden" name="is_private_booking" id="form_is_private" value="{{ $isPrivateBooking ? 1 : 0 }}">
            <input type="hidden" name="space_id" id="selected_space_id" value="">

            @if(!$selectedDate || !$startTime || !$endTime)
                <!-- BEAUTIFIED EMPTY STATE -->
                <div class="empty-state-wrapper">
                    <div class="empty-state-icon">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <h3 class="empty-state-title">Awaiting Your Selection</h3>
                    <p class="empty-state-message">Please select a date, start time, and end time to see available spaces.</p>
                    <div class="empty-state-rules">
                        <span class="rule-badge"><i class="fas fa-hourglass-half"></i> Minimum 2 hours</span>
                        <span class="rule-badge"><i class="fas fa-hourglass-end"></i> Maximum 9 hours</span>
                        <span class="rule-badge"><i class="fas fa-clock"></i> Minutes: 00 or 30</span>
                        <span class="rule-badge"><i class="fas fa-sun"></i> Hours: 08:00 - 22:00</span>
                    </div>
                </div>
                
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
                                <div class="text-[10px] text-gray-500 mt-2 text-center">Select date & time to check availability</div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- RESTORED PAGINATION STYLE -->
                @if($spaces->lastPage() > 1)
                    <div class="pagination">
                        {{ $spaces->links() }}
                    </div>
                    <div class="pagination-info">
                        Showing {{ $spaces->firstItem() }} to {{ $spaces->lastItem() }} of {{ $spaces->total() }} spaces
                    </div>
                @endif
                
            @elseif($spaces->count() == 0)
                <div class="empty-state-wrapper">
                    <div class="empty-state-icon">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <h3 class="empty-state-title">No Spaces Available</h3>
                    <p class="empty-state-message">No spaces match your current filters. Try adjusting your criteria.</p>
                    <button type="button" onclick="resetAllFilters()" class="book-now-btn" style="width: auto; padding: 0.5rem 1.5rem; margin-top: 1rem;">Reset Filters</button>
                </div>
            @else
                <div class="spaces-grid">
                    @foreach($spaces as $space)
                        <div class="space-card {{ !$space->is_available ? 'disabled' : '' }}" 
                             data-space-id="{{ $space->id }}" 
                             data-space-name="{{ $space->name }}" 
                             data-space-capacity="{{ $space->capacity }}" 
                             data-space-type="{{ $space->type }}" 
                             data-space-description="{{ $space->description }}" 
                             data-space-available="{{ $space->is_available ? 'true' : 'false' }}"
                             onclick="if({{ $space->is_available ? 'true' : 'false' }}) showModal(this)">
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
                                <p class="space-description">{{ Str::limit($space->description ?? 'A perfect spot for your gaming session.', 80) }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- RESTORED PAGINATION STYLE -->
                @if($spaces->lastPage() > 1)
                    <div class="pagination">
                        {{ $spaces->links() }}
                    </div>
                    <div class="pagination-info">
                        Showing {{ $spaces->firstItem() }} to {{ $spaces->lastItem() }} of {{ $spaces->total() }} spaces
                    </div>
                @endif
            @endif
        </form>
    </main>

    <footer class="footer">
        © 2026 Meeple Corner Café — Roll responsibly. Sip slowly. Play often.
    </footer>

    <script>
        // Recommended games based on table capacity (multiple games)
        const recommendedGamesList = {
            2: ['Patchwork', '7 Wonders Duel', 'Jaipur', 'Chess', 'Hive', 'Onitama', 'Lost Cities', 'Schotten Totten'],
            3: ['Catan', 'Ticket to Ride', 'Carcassonne', 'Azul', 'Splendor', 'King of Tokyo', 'Dominion', 'Small World'],
            4: ['Catan', 'Pandemic', 'Codenames', 'Ticket to Ride', 'Terraforming Mars', 'Wingspan', 'Sagrada', 'Everdell'],
            5: ['Catan (5-6 players)', 'Pandemic', 'Mysterium', 'King of Tokyo', 'Betrayal at House on the Hill', 'Cosmic Encounter', 'The Resistance', 'Bang!'],
            6: ['Codenames', 'Werewolf', 'Dixit', '7 Wonders', 'Sushi Go Party', 'Mafia de Cuba', 'Deception: Murder in Hong Kong', 'One Night Ultimate Werewolf'],
            8: ['Twilight Imperium', 'D&D Campaign', 'Codenames', 'Telestrations', 'Eclipse', 'Rising Sun', 'Scythe', 'Root'],
            10: ['D&D Campaign', 'Werewolf', 'Two Rooms and a Boom', 'Ultimate Werewolf', 'Blood on the Clocktower', 'The Resistance: Avalon', 'Captain Sonar', 'Formula D']
        };

        let selectedSpaceForModal = null;

        function showModal(cardElement) {
            const isAvailable = cardElement.getAttribute('data-space-available') === 'true';
            if (!isAvailable) return;
            
            const id = cardElement.getAttribute('data-space-id');
            const name = cardElement.getAttribute('data-space-name');
            const capacity = parseInt(cardElement.getAttribute('data-space-capacity'));
            const type = cardElement.getAttribute('data-space-type');
            const description = cardElement.getAttribute('data-space-description');
            
            selectedSpaceForModal = id;
            
            document.getElementById('modalSpaceName').textContent = name;
            document.getElementById('modalCapacity').innerHTML = '<i class="fas fa-users"></i> ' + capacity + ' players';
            document.getElementById('modalType').innerHTML = '<i class="fas fa-tag"></i> ' + (type === 'private' ? 'Private Room' : type === 'premium' ? 'Premium Table' : 'Standard Table');
            document.getElementById('modalStatus').innerHTML = '<i class="fas fa-check-circle"></i> Available';
            document.getElementById('modalDescription').textContent = description || 'A perfect spot for your gaming session.';
            
            // Get recommended games based on capacity
            let capacityKey = capacity;
            if (capacity <= 2) capacityKey = 2;
            else if (capacity <= 3) capacityKey = 3;
            else if (capacity <= 4) capacityKey = 4;
            else if (capacity <= 5) capacityKey = 5;
            else if (capacity <= 6) capacityKey = 6;
            else if (capacity <= 8) capacityKey = 8;
            else capacityKey = 10;
            
            const games = recommendedGamesList[capacityKey] || recommendedGamesList[4];
            const gameTags = games.map(game => `<span class="game-tag"><i class="fas fa-dice-d6 mr-1 text-gold"></i> ${game}</span>`).join('');
            document.getElementById('recommendedGameList').innerHTML = gameTags;
            
            // Change icon based on type
            const modalImage = document.getElementById('modalSpaceImage');
            if (type === 'private') {
                modalImage.innerHTML = '<i class="fas fa-door-closed text-6xl text-gold"></i>';
            } else if (type === 'premium') {
                modalImage.innerHTML = '<i class="fas fa-crown text-6xl text-gold"></i>';
            } else {
                modalImage.innerHTML = '<i class="fas fa-couch text-6xl text-gold"></i>';
            }
            
            document.getElementById('spaceModal').classList.add('show');
            document.body.style.overflow = 'hidden';
            
            // GSAP animation for modal
            gsap.from(".modal-container", { scale: 0.8, opacity: 0, duration: 0.3, ease: "back.out(0.5)" });
        }

        function closeModal() {
            document.getElementById('spaceModal').classList.remove('show');
            document.body.style.overflow = '';
            selectedSpaceForModal = null;
        }

        function bookSelectedSpace() {
            if (selectedSpaceForModal) {
                document.getElementById('selected_space_id').value = selectedSpaceForModal;
                document.getElementById('reservationForm').submit();
            }
        }

        // Close modal when clicking outside
        document.getElementById('spaceModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && document.getElementById('spaceModal').classList.contains('show')) {
                closeModal();
            }
        });

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

        autoSubmitElements.forEach(element => {
            element.addEventListener('change', function() {
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
        
        // Hide loading overlay when page loads
        window.addEventListener('load', function() {
            hideLoading();
        });
    </script>
</body>
</html>