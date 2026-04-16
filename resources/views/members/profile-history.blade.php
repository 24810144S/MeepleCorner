<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation History | Meeple Corner Café</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- GSAP & ScrollTrigger -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>
    <!-- tsParticles -->
    <script src="https://cdn.jsdelivr.net/npm/tsparticles@2.12.0/tsparticles.bundle.min.js"></script>
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* ===== DARK THEME VARIABLES ===== */
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

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
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

        /* tsParticles background */
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

        /* ===== MAIN CONTAINER ===== */
        .main-container {
            flex: 1;
            max-width: 1000px;
            margin: 0 auto;
            padding: 2rem;
            width: 100%;
            position: relative;
            z-index: 2;
        }

        /* ===== CARDS ===== */
        .history-card {
            background: rgba(255,255,255,0.03);
            backdrop-filter: blur(8px);
            border-radius: 28px;
            overflow: hidden;
            border: 1px solid rgba(212,165,116,0.2);
            margin-bottom: 2rem;
        }
        .card-header {
            padding: 1.2rem 2rem;
            border-bottom: 1px solid rgba(212,165,116,0.15);
            background: rgba(0,0,0,0.2);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 0.5rem;
        }
        .card-header h3 {
            font-family: var(--font-heading);
            font-size: 1.5rem;
            color: var(--color-white);
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        .badge-count {
            background: rgba(212,165,116,0.2);
            color: var(--color-accent);
            padding: 0.2rem 0.6rem;
            border-radius: 40px;
            font-size: 0.7rem;
        }
        .reservation-item {
            padding: 1.2rem 2rem;
            border-bottom: 1px solid rgba(212,165,116,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
            transition: var(--transition);
        }
        .reservation-item:hover {
            background: rgba(212,165,116,0.05);
        }
        .reservation-date {
            min-width: 70px;
            text-align: center;
        }
        .reservation-day {
            font-size: 1.4rem;
            font-weight: bold;
            color: var(--color-accent);
            line-height: 1;
        }
        .reservation-month {
            font-size: 0.65rem;
            text-transform: uppercase;
            color: var(--color-text-muted);
        }
        .reservation-time {
            min-width: 110px;
        }
        .reservation-time p {
            font-size: 0.8rem;
            color: var(--color-text);
        }
        .reservation-details h4 {
            font-size: 1rem;
            color: var(--color-white);
            margin-bottom: 0.25rem;
        }
        .reservation-details .meta {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            font-size: 0.7rem;
            color: var(--color-text-muted);
        }
        .status-badge {
            background: rgba(74,222,128,0.15);
            color: #4ade80;
            padding: 0.2rem 0.8rem;
            border-radius: 40px;
            font-size: 0.7rem;
            font-weight: bold;
        }
        .status-badge.completed {
            background: rgba(156,163,175,0.2);
            color: #9ca3af;
        }
        .cancel-btn {
            background: none;
            border: none;
            color: #f87171;
            font-size: 0.7rem;
            cursor: pointer;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
        }
        .cancel-btn:hover {
            color: #ef4444;
        }
        .empty-state {
            padding: 3rem;
            text-align: center;
            color: var(--color-text-muted);
        }
        .empty-state i {
            font-size: 3rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        /* Highlight animation for new booking */
        @keyframes highlightFlash {
            0% { background-color: transparent; border-left-color: transparent; }
            30% { background-color: rgba(212,165,116,0.15); border-left-color: var(--color-accent); }
            100% { background-color: transparent; border-left-color: transparent; }
        }
        .highlight-new {
            animation: highlightFlash 2s ease-in-out 3;
            border-left: 3px solid var(--color-accent);
        }

        /* ===== LOYALTY CARD ===== */
        .loyalty-card {
            background: linear-gradient(135deg, rgba(212,165,116,0.1), rgba(0,0,0,0.3));
            border-radius: 24px;
            padding: 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border: 1px solid rgba(212,165,116,0.2);
            backdrop-filter: blur(4px);
        }
        .loyalty-left i {
            font-size: 2rem;
            color: var(--color-accent);
        }
        .loyalty-left p {
            font-size: 0.7rem;
            color: var(--color-text-muted);
            margin-top: 0.3rem;
        }
        .loyalty-right {
            text-align: right;
        }
        .loyalty-points {
            font-size: 2rem;
            font-weight: bold;
            color: var(--color-accent);
            line-height: 1;
        }
        .loyalty-label {
            font-size: 0.65rem;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: var(--color-text-muted);
        }

        /* ===== ALERTS ===== */
        .alert-success {
            background: rgba(74,222,128,0.15);
            border-left: 4px solid #4ade80;
            padding: 1rem;
            border-radius: 16px;
            margin-bottom: 1.5rem;
            color: #86efac;
        }
        .alert-error {
            background: rgba(220,38,38,0.2);
            border-left: 4px solid #ef4444;
            padding: 1rem;
            border-radius: 16px;
            margin-bottom: 1.5rem;
            color: #fca5a5;
        }

        /* ===== FOOTER ===== */
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
            .main-container {
                padding: 1rem;
            }
            .card-header, .reservation-item {
                padding: 1rem;
            }
            .reservation-date {
                min-width: 60px;
            }
            .reservation-day {
                font-size: 1.2rem;
            }
            .reservation-time {
                min-width: auto;
            }
        }
    </style>
</head>
<body>

    <!-- tsParticles + floating emoji -->
    <div id="tsparticles"></div>
    <div class="floating-bg">🎲 🃏 🧩 🎯 🎲</div>

    @include('layouts.navbar')

    <main class="main-container">
        @if(session('success'))
            <div class="alert-success">
                <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
            </div>
        @endif

        @if(session('booking_success'))
            <div class="alert-success">
                <i class="fas fa-check-circle mr-2"></i> {{ session('booking_success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert-error">
                <i class="fas fa-exclamation-circle mr-2"></i> {{ session('error') }}
            </div>
        @endif

        <!-- Upcoming Reservations -->
        <div class="history-card">
            <div class="card-header">
                <h3>
                    <i class="fas fa-calendar-check text-gold"></i> Upcoming Adventures
                </h3>
                <span class="badge-count">{{ $upcomingReservations->count() }} upcoming</span>
            </div>
            @if($upcomingReservations->count() > 0)
                @foreach($upcomingReservations as $res)
                    @php $isNew = session('new_reservation_id') == $res->id; @endphp
                    <div class="reservation-item {{ $isNew ? 'highlight-new' : '' }}">
                        <div class="flex flex-wrap items-center gap-4 flex-1">
                            <div class="reservation-date">
                                <div class="reservation-day">{{ \Carbon\Carbon::parse($res->reservation_date)->format('d') }}</div>
                                <div class="reservation-month">{{ \Carbon\Carbon::parse($res->reservation_date)->format('M Y') }}</div>
                            </div>
                            <div class="reservation-time">
                                <p><i class="far fa-clock text-gold mr-1"></i> {{ \Carbon\Carbon::parse($res->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($res->end_time)->format('H:i') }}</p>
                                <p class="text-xs text-text-muted">{{ \Carbon\Carbon::parse($res->start_time)->diffInHours(\Carbon\Carbon::parse($res->end_time)) }} hours</p>
                            </div>
                            <div class="reservation-details flex-1">
                                <h4>{{ $res->space->name }}</h4>
                                <div class="meta">
                                    <span><i class="fas fa-users"></i> {{ $res->space->capacity }} players</span>
                                    <span><i class="fas fa-tag"></i> {{ ucfirst($res->space->type) }}</span>
                                    @if($res->is_private_booking)
                                        <span><i class="fas fa-door-closed"></i> Private Room</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="status-badge"><i class="fas fa-check-circle mr-1"></i> Confirmed</span>
                            <form method="POST" action="/reservation/{{ $res->id }}" onsubmit="return confirm('Cancel this reservation?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="cancel-btn">
                                    <i class="fas fa-times-circle"></i> Cancel
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="empty-state">
                    <i class="fas fa-calendar-alt"></i>
                    <p>No upcoming reservations.</p>
                    <a href="/reservation" class="inline-block mt-2 text-gold text-sm hover:underline">Book your next adventure →</a>
                </div>
            @endif
        </div>

        <!-- Past Reservations -->
        <div class="history-card">
            <div class="card-header">
                <h3>
                    <i class="fas fa-clock text-gold"></i> Past Adventures
                </h3>
                <span class="badge-count">{{ $pastReservations->count() }} completed</span>
            </div>
            @if($pastReservations->count() > 0)
                @foreach($pastReservations as $res)
                    <div class="reservation-item opacity-70 hover:opacity-100">
                        <div class="flex flex-wrap items-center gap-4 flex-1">
                            <div class="reservation-date">
                                <div class="reservation-day">{{ \Carbon\Carbon::parse($res->reservation_date)->format('d') }}</div>
                                <div class="reservation-month">{{ \Carbon\Carbon::parse($res->reservation_date)->format('M Y') }}</div>
                            </div>
                            <div class="reservation-time">
                                <p><i class="far fa-clock text-gray-400 mr-1"></i> {{ \Carbon\Carbon::parse($res->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($res->end_time)->format('H:i') }}</p>
                            </div>
                            <div class="reservation-details flex-1">
                                <h4>{{ $res->space->name }}</h4>
                                <div class="meta">
                                    <span><i class="fas fa-users"></i> {{ $res->space->capacity }} players</span>
                                    <span><i class="fas fa-tag"></i> {{ ucfirst($res->space->type) }}</span>
                                    @if($res->is_private_booking)
                                        <span><i class="fas fa-door-closed"></i> Private Room</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div>
                            <span class="status-badge completed"><i class="fas fa-check-circle mr-1"></i> Completed</span>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="empty-state">
                    <i class="fas fa-history"></i>
                    <p>No past reservations yet.</p>
                </div>
            @endif
        </div>

        <!-- Loyalty Summary -->
        <div class="loyalty-card">
            <div class="loyalty-left">
                <i class="fas fa-dice-d20"></i>
                <p>Total reservations: {{ $upcomingReservations->count() + $pastReservations->count() }}</p>
            </div>
            <div class="loyalty-right">
                <div class="loyalty-points">{{ ($upcomingReservations->count() + $pastReservations->count()) * 50 }}</div>
                <div class="loyalty-label">Loyalty Points Earned</div>
            </div>
        </div>
    </main>

    <footer class="footer">
        © 2026 Meeple Corner Café — Roll responsibly. Sip slowly. Play often.
    </footer>

    <script>
        // 1. Initialize tsParticles
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

        </script>
</body>
</html>