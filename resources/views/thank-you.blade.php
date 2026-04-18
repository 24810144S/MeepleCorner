<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmed | Meeple Corner Café</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- GSAP -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <!-- tsParticles -->
    <script src="https://cdn.jsdelivr.net/npm/tsparticles@2.12.0/tsparticles.bundle.min.js"></script>
    <!-- Canvas Confetti -->
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1"></script>
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Same dark theme as other pages */
        * { margin: 0; padding: 0; box-sizing: border-box; }
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
        #tsparticles {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            pointer-events: none;
        }
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
        .main-container {
            flex: 1;
            max-width: 900px;
            margin: 0 auto;
            padding: 2rem;
            width: 100%;
            position: relative;
            z-index: 2;
        }
        .thankyou-card {
            background: rgba(255,255,255,0.03);
            backdrop-filter: blur(8px);
            border-radius: 32px;
            overflow: hidden;
            border: 1px solid rgba(212,165,116,0.2);
            padding: 2rem;
            text-align: center;
        }
        .success-icon {
            font-size: 5rem;
            color: #4ade80;
            margin-bottom: 1rem;
        }
        h1 {
            font-family: var(--font-heading);
            font-size: 2rem;
            color: var(--color-white);
            margin-bottom: 1rem;
        }
        .booking-details {
            background: rgba(0,0,0,0.3);
            border-radius: 20px;
            padding: 1.5rem;
            margin: 1.5rem 0;
            text-align: left;
        }
        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 0.5rem 0;
            border-bottom: 1px solid rgba(212,165,116,0.2);
        }
        .detail-label {
            font-weight: 600;
            color: var(--color-accent);
        }
        .btn-history {
            display: inline-block;
            background: var(--color-accent);
            color: var(--color-primary);
            padding: 0.8rem 2rem;
            border-radius: 40px;
            font-weight: bold;
            text-decoration: none;
            transition: var(--transition);
            margin-top: 1rem;
        }
        .btn-history:hover {
            background: var(--color-accent-light);
            transform: translateY(-2px);
        }
        .btn-reservation {
            display: inline-block;
            background: transparent;
            border: 1px solid var(--color-accent);
            color: var(--color-accent);
            padding: 0.8rem 2rem;
            border-radius: 40px;
            font-weight: bold;
            text-decoration: none;
            transition: var(--transition);
            margin-top: 1rem;
            margin-left: 1rem;
        }
        .btn-reservation:hover {
            background: rgba(212,165,116,0.1);
        }
        .footer {
            background-color: #0c0704;
            padding: 2rem;
            text-align: center;
            border-top: 1px solid rgba(212,165,116,0.2);
            font-size: 0.7rem;
            color: var(--color-text-muted);
            letter-spacing: 0.1em;
            margin-top: 3rem;
        }
        @media (max-width: 768px) {
            .main-container { padding: 1rem; }
            .detail-row { flex-direction: column; gap: 0.3rem; }
            .btn-reservation { margin-left: 0; margin-top: 0.5rem; }
        }
    </style>
</head>
<body>
    <div id="tsparticles"></div>
    <div class="floating-bg">🎲 🃏 🧩 🎯 🎲</div>
    @include('layouts.navbar')

    <main class="main-container">
        <div class="thankyou-card">
            <div class="success-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <h1>Thank You for Your Booking!</h1>
            <p>Your adventure at Meeple Corner Café is confirmed.</p>

            <div class="booking-details">
                <div class="detail-row">
                    <span class="detail-label">Reservation ID</span>
                    <span>#{{ $reservation->id }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Space</span>
                    <span>{{ $space->name }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Date</span>
                    <span>{{ \Carbon\Carbon::parse($reservation->reservation_date)->format('F j, Y') }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Time</span>
                    <span>{{ \Carbon\Carbon::parse($reservation->start_time)->format('g:i A') }} – {{ \Carbon\Carbon::parse($reservation->end_time)->format('g:i A') }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Players</span>
                    <span>{{ $space->capacity }} seats</span>
                </div>
            </div>

            <p>We’ve sent a confirmation to your email. You can view all your bookings below.</p>

            <div>
                <a href="{{ route('profile.history') }}" class="btn-history">View My Bookings</a>
                <a href="/reservation" class="btn-reservation">Book Another Session</a>
            </div>
        </div>
    </main>

    <footer class="footer">
        © 2026 Meeple Corner Café — Roll responsibly. Sip slowly. Play often.
    </footer>

    <script>
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
        gsap.from(".thankyou-card", { opacity: 0, y: 30, duration: 0.8, ease: "power2.out" });
        canvasConfetti({ particleCount: 200, spread: 100, origin: { y: 0.6 }, colors: ['#d4a574', '#e8c9a9', '#ffffff'] });
    </script>
</body>
</html>