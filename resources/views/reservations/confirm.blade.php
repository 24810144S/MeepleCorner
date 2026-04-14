<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Booking | Meeple Corner Café</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Canvas Confetti -->
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1"></script>
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
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
            font-family: var(--font-body);
            line-height: 1.6;
            background-color: var(--color-primary);
            color: var(--color-text);
            min-height: 100vh;
        }

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

        h1, h2, h3, .logo {
            font-family: var(--font-heading);
            font-weight: 500;
            letter-spacing: -0.02em;
        }

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

        .main-container {
            max-width: 800px;
            margin: 2rem auto;
            padding: 2rem;
        }

        .confirm-card {
            background: rgba(255,255,255,0.03);
            backdrop-filter: blur(8px);
            border-radius: 32px;
            border: 1px solid rgba(212,165,116,0.2);
            overflow: hidden;
        }

        .confirm-header {
            padding: 2rem;
            text-align: center;
            border-bottom: 1px solid rgba(212,165,116,0.2);
            background: rgba(0,0,0,0.2);
        }

        .confirm-icon {
            font-size: 4rem;
            color: var(--color-accent);
            margin-bottom: 1rem;
        }

        .confirm-title {
            font-size: 2rem;
            color: var(--color-white);
        }

        .confirm-subtitle {
            color: var(--color-text-muted);
            margin-top: 0.5rem;
        }

        .confirm-body {
            padding: 2rem;
        }

        .warning-box {
            background: rgba(234, 179, 8, 0.1);
            border-left: 4px solid #eab308;
            padding: 1rem;
            border-radius: 12px;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .warning-box i {
            color: #eab308;
            font-size: 1.5rem;
        }

        .details-section {
            background: rgba(0,0,0,0.2);
            border-radius: 24px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .section-title {
            font-size: 1.2rem;
            color: var(--color-accent);
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 0.75rem 0;
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }

        .detail-label {
            color: var(--color-text-muted);
            font-size: 0.85rem;
        }

        .detail-value {
            color: var(--color-white);
            font-weight: 500;
        }

        .private-badge {
            background: rgba(212,165,116,0.2);
            color: var(--color-accent);
            padding: 0.5rem 1rem;
            border-radius: 40px;
            font-size: 0.7rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            margin-top: 1rem;
        }

        .info-section {
            background: rgba(212,165,116,0.05);
            border-radius: 24px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .info-title {
            font-size: 1rem;
            color: var(--color-white);
            margin-bottom: 0.5rem;
        }

        .info-text {
            color: var(--color-text-muted);
            font-size: 0.85rem;
        }

        .action-buttons {
            display: flex;
            gap: 1rem;
            margin-top: 1.5rem;
        }

        .btn-back {
            flex: 1;
            background: transparent;
            border: 1px solid rgba(212,165,116,0.5);
            color: var(--color-accent);
            padding: 0.8rem;
            border-radius: 40px;
            font-size: 0.7rem;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            cursor: pointer;
            transition: var(--transition);
            text-align: center;
            text-decoration: none;
        }
        .btn-back:hover {
            background: rgba(212,165,116,0.1);
            transform: translateX(-4px);
        }

        .btn-confirm {
            flex: 1;
            background: var(--color-accent);
            color: var(--color-primary);
            border: none;
            padding: 0.8rem;
            border-radius: 40px;
            font-size: 0.7rem;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            cursor: pointer;
            transition: var(--transition);
        }
        .btn-confirm:hover {
            background: var(--color-accent-light);
            transform: translateY(-2px);
        }

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
            .action-buttons {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>

    <nav class="navbar">
        <a href="/" class="logo">Meeple Corner Café</a>
        <div class="nav-links">
            <a href="/" class="nav-link">Home</a>
            <a href="/board-games" class="nav-link">Board Games</a>
            <a href="/events" class="nav-link">Events</a>
            <a href="/reservation" class="nav-link">Reservations</a>
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

    <main class="main-container">
        <div class="confirm-card">
            <div class="confirm-header">
                <div class="confirm-icon">
                    <i class="fas fa-clipboard-list"></i>
                </div>
                <h1 class="confirm-title">Review Your Booking</h1>
                <p class="confirm-subtitle">Please verify your details before confirming</p>
            </div>

            <div class="confirm-body">
                <div class="warning-box">
                    <i class="fas fa-exclamation-triangle"></i>
                    <p class="text-sm">Please double-check your booking details. Once confirmed, changes cannot be made online.</p>
                </div>

                <div class="details-section">
                    <div class="section-title">
                        <i class="fas fa-ticket-alt"></i>
                        <span>Booking Summary</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label"><i class="far fa-calendar-alt mr-2"></i> Date</span>
                        <span class="detail-value">{{ \Carbon\Carbon::parse($reservationData['reservation_date'])->format('l, F j, Y') }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label"><i class="far fa-clock mr-2"></i> Time Slot</span>
                        <span class="detail-value">{{ $reservationData['start_time'] }} - {{ $reservationData['end_time'] }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label"><i class="fas fa-hourglass-half mr-2"></i> Duration</span>
                        <span class="detail-value">
                            {{ \Carbon\Carbon::parse($reservationData['start_time'])->diffInHours(\Carbon\Carbon::parse($reservationData['end_time'])) }} hours
                        </span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label"><i class="fas fa-chair mr-2"></i> Table/Room</span>
                        <span class="detail-value">{{ $space->name }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label"><i class="fas fa-users mr-2"></i> Capacity</span>
                        <span class="detail-value">{{ $space->capacity }} players</span>
                    </div>
                    
                    @if($reservationData['is_private_booking'])
                        <div class="private-badge">
                            <i class="fas fa-door-closed"></i> Private Room Booking
                        </div>
                    @endif
                </div>

                <div class="info-section">
                    <div class="info-title">
                        <i class="fas fa-user-circle mr-2"></i> Your Information
                    </div>
                    <div class="info-text">{{ $member->first_name }} {{ $member->last_name }}</div>
                    <div class="info-text">{{ $member->email }}</div>
                    <div class="info-text">{{ $member->phone }}</div>
                </div>

                <div class="info-section">
                    <div class="info-title">
                        <i class="fas fa-dice-d6 mr-2"></i> Recommended Game
                    </div>
                    <div class="info-text">🎲 Catan: Starfarers - Perfect for {{ $space->capacity }} players! Ask our staff to set it up.</div>
                </div>

                <div class="action-buttons">
                    <a href="/reservation" class="btn-back">
                        <i class="fas fa-arrow-left mr-2"></i> Back to Edit
                    </a>
                    <form method="POST" action="{{ route('reservation.process') }}" style="flex: 1;">
                        @csrf
                        <button type="submit" class="btn-confirm">
                            <i class="fas fa-check-circle mr-2"></i> Confirm Booking
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <footer class="footer">
        © 2026 Meeple Corner Café — Roll responsibly. Sip slowly. Play often.
    </footer>

    <script>
        // Small confetti on page load for visual delight
        document.addEventListener('DOMContentLoaded', function() {
            canvasConfetti({ particleCount: 50, spread: 50, origin: { y: 0.7 }, colors: ['#d4a574'] });
        });
    </script>
</body>
</html>