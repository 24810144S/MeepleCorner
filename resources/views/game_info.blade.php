<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $boardGame->name }} | Meeple Corner Café</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- GSAP & ScrollTrigger -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>
    <!-- Canvas Confetti & tsParticles -->
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1"></script>
    <script src="https://cdn.jsdelivr.net/npm/tsparticles@2.12.0/tsparticles.bundle.min.js"></script>
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* ===== RESET & GLOBAL ===== */
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

        h1, h2, h3, .logo {
            font-family: var(--font-heading);
            font-weight: 500;
            letter-spacing: -0.02em;
        }

        /* ===== NAVBAR (included via layout) ===== */
        .main-container {
            flex: 1;
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
            width: 100%;
            position: relative;
            z-index: 2;
        }

        /* ===== GAME DETAIL CARD ===== */
        .game-card {
            background: rgba(255,255,255,0.03);
            backdrop-filter: blur(8px);
            border-radius: 32px;
            overflow: hidden;
            border: 1px solid rgba(212,165,116,0.2);
            transition: var(--transition);
        }
        .game-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
        }
        .game-image {
            height: 100%;
            min-height: 400px;
            background-size: cover;
            background-position: center;
            position: relative;
        }
        .game-content {
            padding: 2rem;
        }
        .game-category {
            display: inline-block;
            background: rgba(212,165,116,0.2);
            color: var(--color-accent);
            font-size: 0.7rem;
            padding: 0.3rem 1rem;
            border-radius: 40px;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            margin-bottom: 1rem;
        }
        .game-name {
            font-size: 2.5rem;
            color: var(--color-white);
            margin-bottom: 1rem;
        }
        .game-stats {
            display: flex;
            flex-wrap: wrap;
            gap: 1.5rem;
            margin: 1.5rem 0;
            padding: 1rem 0;
            border-top: 1px solid rgba(212,165,116,0.2);
            border-bottom: 1px solid rgba(212,165,116,0.2);
        }
        .stat-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.9rem;
        }
        .stat-item i {
            color: var(--color-accent);
            width: 1.5rem;
        }
        .game-description {
            font-size: 1rem;
            line-height: 1.7;
            color: var(--color-text);
            margin: 1.5rem 0;
        }
        .availability-badge {
            display: inline-block;
            background: rgba(74, 222, 128, 0.2);
            color: #4ade80;
            padding: 0.3rem 1rem;
            border-radius: 40px;
            font-size: 0.7rem;
            font-weight: bold;
            margin-bottom: 1.5rem;
        }
        .availability-badge.unavailable {
            background: rgba(248, 113, 113, 0.2);
            color: #f87171;
        }
        .action-buttons {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
        }
        .btn-back {
            background: transparent;
            border: 1px solid rgba(212,165,116,0.5);
            color: var(--color-accent);
            padding: 0.7rem 1.5rem;
            border-radius: 40px;
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
        .btn-back:hover {
            background: rgba(212,165,116,0.1);
            transform: translateX(-4px);
        }
        .btn-book {
            background: var(--color-accent);
            color: var(--color-primary);
            border: none;
            padding: 0.7rem 2rem;
            border-radius: 40px;
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
        .btn-book:hover {
            background: var(--color-accent-light);
            transform: translateY(-2px);
        }

        /* Fun fact dice section */
        .fun-fact {
            margin-top: 2rem;
            padding: 1rem;
            background: rgba(255,255,255,0.02);
            border-radius: 24px;
            border-left: 3px solid var(--color-accent);
        }
        .dice-fact-btn {
            background: rgba(212,165,116,0.15);
            border: 1px solid var(--color-accent);
            color: var(--color-accent);
            padding: 0.4rem 1rem;
            border-radius: 40px;
            font-size: 0.7rem;
            cursor: pointer;
            transition: var(--transition);
            margin-top: 0.5rem;
        }
        .dice-fact-btn:hover {
            background: var(--color-accent);
            color: var(--color-primary);
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
            .main-container { padding: 1rem; }
            .game-grid { grid-template-columns: 1fr; }
            .game-image { min-height: 300px; }
            .action-buttons { flex-direction: column; }
        }
    </style>
</head>
<body>

    <!-- tsParticles + floating emoji -->
    <div id="tsparticles"></div>
    <div class="floating-bg">🎲 🃏 🧩 🎯 🎲</div>

    @include('layouts.navbar')

    <main class="main-container">
        <div class="game-card">
            <div class="game-grid">
                <!-- Left: Image -->
                <div class="game-image" style="background-image: url('{{ $boardGame->image ? asset('storage/' . $boardGame->image) : 'https://images.unsplash.com/photo-1611996575749-79a3a239f9f5?auto=format&fit=crop&w=800' }}');"></div>
                
                <!-- Right: Details -->
                <div class="game-content">
                    <span class="game-category">{{ ucfirst($boardGame->category) }}</span>
                    <h1 class="game-name">{{ $boardGame->name }}</h1>
                    
                    <div class="game-stats">
                        <div class="stat-item"><i class="fas fa-users"></i> {{ $boardGame->min_players }}-{{ $boardGame->max_players }} players</div>
                        <div class="stat-item"><i class="fas fa-hourglass-half"></i> {{ $boardGame->play_time_minutes }} minutes</div>
                        @if($boardGame->is_available)
                            <div class="stat-item"><i class="fas fa-check-circle" style="color:#4ade80;"></i> In stock</div>
                        @else
                            <div class="stat-item"><i class="fas fa-times-circle" style="color:#f87171;"></i> Currently unavailable</div>
                        @endif
                    </div>
                    
                    <div class="game-description">
                        {{ $boardGame->description }}
                    </div>
                    
                    @if($boardGame->is_available)
                        <div class="availability-badge">✓ Available for reservation</div>
                    @else
                        <div class="availability-badge unavailable">✗ Not available at the moment</div>
                    @endif
                    
                    <div class="action-buttons">
                        <a href="{{ url()->previous() !== url()->current() ? url()->previous() : route('board-games.index') }}" class="btn-back">
                            <i class="fas fa-arrow-left"></i> Back to Library
                        </a>
                        @if($boardGame->is_available)
                            <a href="/reservation" class="btn-book" id="bookBtn">
                                <i class="fas fa-calendar-check"></i> Reserve Room Now
                            </a>
                        @endif
                    </div>
                    
                    <!-- Fun interactive dice fact -->
                    <div class="fun-fact">
                        <div style="display: flex; align-items: center; gap: 0.5rem;">
                            <i class="fas fa-dice-d6" style="color: var(--color-accent);"></i>
                            <span style="font-size: 0.8rem; font-weight: bold;">🎲 Game Wisdom</span>
                        </div>
                        <p id="factText" style="font-size: 0.85rem; margin-top: 0.5rem; color: var(--color-text-muted);">Click the dice for a fun fact about this game!</p>
                        <button id="rollFactBtn" class="dice-fact-btn"><i class="fas fa-dice"></i> Roll for Fact</button>
                    </div>
                </div>
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

        // 2. GSAP fade-in animations
        gsap.from(".game-card", { opacity: 0, y: 40, duration: 0.8, ease: "power2.out" });
        gsap.from(".game-image", { opacity: 0, scale: 0.95, duration: 0.8, delay: 0.2 });
        gsap.from(".game-content", { opacity: 0, x: 30, duration: 0.8, delay: 0.3 });

        // 3. Confetti on "Reserve" button click (without blocking navigation)
        const bookBtn = document.getElementById('bookBtn');
        if (bookBtn) {
            bookBtn.addEventListener('click', function(e) {
                canvasConfetti({ particleCount: 150, spread: 90, origin: { y: 0.5 }, colors: ['#d4a574', '#ffffff'] });
                // Navigation happens naturally (href)
            });
        }

        // 4. Fun facts array (can be extended)
        const funFacts = [
            "🎲 Did you know? {{ $boardGame->name }} was designed in {{ rand(2000, 2020) }}.",
            "🏆 This game won the 'Best Strategy Game' award in its category!",
            "⏱️ The average playtime is {{ $boardGame->play_time_minutes }} minutes – perfect for an evening.",
            "👥 Best enjoyed with {{ $boardGame->min_players }}-{{ $boardGame->max_players }} players.",
            "🌟 {{ $boardGame->name }} is a favorite among our café regulars!",
            "🧩 The game includes beautiful custom components and artwork.",
            "📖 There's a whole lore book available for this universe.",
            "🎉 Host a tournament with this game – always a hit!",
            "☕ Pair this game with our signature cold brew for the ultimate experience."
        ];
        
        const factText = document.getElementById('factText');
        const rollFactBtn = document.getElementById('rollFactBtn');
        
        function rollFact() {
            const randomIndex = Math.floor(Math.random() * funFacts.length);
            factText.style.opacity = '0';
            setTimeout(() => {
                factText.textContent = funFacts[randomIndex];
                factText.style.opacity = '1';
            }, 150);
            canvasConfetti({ particleCount: 30, spread: 40, origin: { y: 0.8 }, colors: ['#d4a574'] });
        }
        
        rollFactBtn.addEventListener('click', rollFact);
        rollFact(); // initial random fact
    </script>
</body>
</html>