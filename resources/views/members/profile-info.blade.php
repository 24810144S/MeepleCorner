<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Info | Meeple Corner Café</title>
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
        /* ===== HOMEPAGE CSS VARIABLES (dark theme) ===== */
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

        /* subtle noise texture */
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

        /* ===== NAVBAR (exactly like homepage) ===== */
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
        .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 0;
            width: 100%;
            height: 2px;
            background: var(--color-accent);
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
            text-decoration: none;
            color: var(--color-accent);
            font-weight: bold;
        }
        .user-avatar:hover {
            border-color: var(--color-accent-light);
            transform: scale(1.05);
        }
        .logout-btn {
            background: none;
            border: none;
            color: #f87171;
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            cursor: pointer;
            transition: var(--transition);
        }
        .logout-btn:hover {
            color: #ef4444;
        }

        /* ===== MAIN CONTENT (pushes footer down) ===== */
        .main-container {
            flex: 1;
            max-width: 900px;
            margin: 0 auto;
            padding: 2rem;
            width: 100%;
            position: relative;
            z-index: 2;
        }

        /* ===== PROFILE CARD ===== */
        .profile-card {
            background: rgba(255,255,255,0.03);
            backdrop-filter: blur(8px);
            border-radius: 32px;
            overflow: hidden;
            border: 1px solid rgba(212,165,116,0.2);
            margin-bottom: 2rem;
        }
        .card-header {
            padding: 1.8rem 2rem;
            border-bottom: 1px solid rgba(212,165,116,0.15);
            background: rgba(0,0,0,0.2);
        }
        .card-header h2 {
            font-family: var(--font-heading);
            font-size: 1.8rem;
            color: var(--color-white);
            margin-bottom: 0.25rem;
        }
        .card-header p {
            font-size: 0.8rem;
            color: var(--color-text-muted);
        }
        .edit-note {
            font-size: 0.7rem;
            color: var(--color-accent);
            margin-top: 0.5rem;
        }
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
            padding: 2rem;
        }
        .info-item {
            background: rgba(0,0,0,0.2);
            border-radius: 24px;
            padding: 1.2rem;
            border-left: 3px solid var(--color-accent);
        }
        .info-label {
            display: block;
            font-size: 0.65rem;
            text-transform: uppercase;
            letter-spacing: 0.2em;
            color: var(--color-accent);
            margin-bottom: 0.5rem;
            font-weight: 600;
        }
        .info-value {
            font-size: 1.1rem;
            color: var(--color-white);
            word-break: break-word;
        }
        .member-since {
            background: linear-gradient(135deg, rgba(212,165,116,0.1), rgba(0,0,0,0.2));
            border-left-color: var(--color-accent-light);
        }
        .edit-btn-wrapper {
            padding: 0 2rem 2rem 2rem;
            display: flex;
            justify-content: flex-end;
        }
        .btn-edit {
            background: var(--color-accent);
            color: var(--color-primary);
            border: none;
            border-radius: 40px;
            padding: 0.7rem 1.8rem;
            font-size: 0.7rem;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        .btn-edit:hover {
            background: var(--color-accent-light);
            transform: translateY(-2px);
        }

        /* Loyalty points card */
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

        /* Alert success */
        .alert-success {
            background: rgba(74, 222, 128, 0.15);
            border-left: 4px solid #4ade80;
            padding: 1rem;
            border-radius: 16px;
            margin-bottom: 1.5rem;
            color: #86efac;
            font-size: 0.85rem;
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
            .info-grid {
                grid-template-columns: 1fr;
                padding: 1.2rem;
            }
            .card-header {
                padding: 1.2rem;
            }
            .edit-btn-wrapper {
                padding: 0 1.2rem 1.2rem 1.2rem;
            }
        }
    </style>
</head>
<body>

    <!-- tsParticles container + floating emoji -->
    <div id="tsparticles"></div>
    <div class="floating-bg">🎲 🃏 🧩 🎯 🎲</div>

    @include('layouts.navbar')

    <main class="main-container">
        @if(session('success'))
            <div class="alert-success">
                <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
            </div>
        @endif

        <!-- Profile Information Card -->
        <div class="profile-card">
            <div class="card-header">
                <h2>Profile Information</h2>
                <p>Your personal details on file</p>
                <div class="edit-note">✏️ To edit, go to <strong>Edit My Account</strong></div>
            </div>

            <div class="info-grid">
                <div class="info-item">
                    <span class="info-label"><i class="fas fa-user mr-1"></i> First Name</span>
                    <div class="info-value">{{ $member->first_name }}</div>
                </div>
                <div class="info-item">
                    <span class="info-label"><i class="fas fa-user mr-1"></i> Last Name</span>
                    <div class="info-value">{{ $member->last_name }}</div>
                </div>
                <div class="info-item">
                    <span class="info-label"><i class="fas fa-map-marker-alt mr-1"></i> Address</span>
                    <div class="info-value">{{ $member->address }}</div>
                </div>
                <div class="info-item">
                    <span class="info-label"><i class="fas fa-phone mr-1"></i> Phone Number</span>
                    <div class="info-value">{{ $member->phone }}</div>
                </div>
                <div class="info-item">
                    <span class="info-label"><i class="fas fa-envelope mr-1"></i> Email Address</span>
                    <div class="info-value">{{ $member->email }}</div>
                </div>
                <div class="info-item member-since">
                    <span class="info-label"><i class="fas fa-calendar-alt mr-1"></i> Member Since</span>
                    <div class="info-value">{{ $member->created_at->format('F j, Y') }}</div>
                </div>
            </div>

            <div class="edit-btn-wrapper">
                <a href="/profile/edit" class="btn-edit">
                    <i class="fas fa-edit"></i> Edit Profile
                </a>
            </div>
        </div>

        <!-- Loyalty Points Card (static example – you can replace with actual data) -->
        <div class="loyalty-card">
            <div class="loyalty-left">
                <i class="fas fa-crown"></i>
                <p>Loyalty Program</p>
            </div>
            <div class="loyalty-right">
                <div class="loyalty-points">1,250</div>
                <div class="loyalty-label">points earned</div>
            </div>
        </div>
    </main>

    <footer class="footer">
        © 2026 Meeple Corner Café — Established for the Strategic Mind
    </footer>

    <script>
        // 1. Initialize tsParticles (same as board games library)
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

        // 2. GSAP fade-in animations
        gsap.from(".profile-card", { opacity: 0, y: 30, duration: 0.8, ease: "power2.out" });
        gsap.from(".loyalty-card", { opacity: 0, y: 20, duration: 0.6, delay: 0.2, ease: "power2.out" });
        gsap.from(".info-item", { opacity: 0, x: -10, duration: 0.5, stagger: 0.05, delay: 0.3 });
    </script>
</body>
</html>