<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game Library | Meeple Corner Café</title>
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
        .library-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        .library-header h1 {
            font-family: var(--font-heading);
            font-size: 2.5rem;
            color: var(--color-white);
            margin-bottom: 0.5rem;
        }
        .library-header p {
            font-size: 0.8rem;
            color: var(--color-text-muted);
            letter-spacing: 0.2em;
        }

        /* filter buttons */
        .filter-bar {
            display: flex;
            justify-content: center;
            gap: 1rem;
            flex-wrap: wrap;
            margin-bottom: 2rem;
        }
        .filter-btn {
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(212,165,116,0.3);
            color: var(--color-text-muted);
            padding: 0.5rem 1.2rem;
            border-radius: 40px;
            font-size: 0.7rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            cursor: pointer;
            transition: var(--transition);
        }
        .filter-btn:hover, .filter-btn.active {
            background: var(--color-accent);
            color: var(--color-primary);
            border-color: var(--color-accent);
        }

        /* card container */
        .games-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 2rem;
        }
        .game-card {
            background: rgba(255,255,255,0.03);
            backdrop-filter: blur(8px);
            border-radius: 28px;
            overflow: hidden;
            transition: var(--transition);
            border: 1px solid rgba(212,165,116,0.1);
            cursor: pointer;
            transform: translateY(0);
        }
        .game-card:hover {
            transform: translateY(-8px);
            border-color: var(--color-accent);
            box-shadow: 0 20px 30px -12px rgba(0,0,0,0.5);
        }
        .game-img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        .game-card:hover .game-img {
            transform: scale(1.05);
        }
        .card-content {
            padding: 1.5rem;
        }
        .game-title {
            font-family: var(--font-heading);
            font-size: 1.4rem;
            color: var(--color-white);
            margin-bottom: 0.5rem;
        }
        .game-category {
            display: inline-block;
            background: rgba(212,165,116,0.2);
            color: var(--color-accent);
            font-size: 0.7rem;
            padding: 0.2rem 0.8rem;
            border-radius: 30px;
            margin-bottom: 1rem;
        }
        .game-description {
            font-size: 0.85rem;
            color: var(--color-text-muted);
            line-height: 1.5;
            margin-bottom: 1rem;
        }
        .game-stats {
            display: flex;
            gap: 1rem;
            margin-bottom: 1rem;
            font-size: 0.7rem;
            color: var(--color-accent-light);
        }
        .game_link {
            color: var(--color-accent);
            text-decoration: none;
            font-weight: 600;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: var(--transition);
        }
        .game_link:hover { letter-spacing: 2px; }

        .availability {
            font-size: 0.7rem;
            margin-bottom: 1rem;
        }
        .availability.available {
            color: #4ade80;
        }
        .availability.unavailable {
            color: #f87171;
        }
        .play-btn {
            background: transparent;
            border: 1px solid var(--color-accent);
            color: var(--color-accent);
            padding: 0.5rem 1rem;
            border-radius: 40px;
            font-size: 0.7rem;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            cursor: pointer;
            transition: var(--transition);
            width: 100%;
        }
        .play-btn:hover {
            background: var(--color-accent);
            color: var(--color-primary);
            transform: translateY(-2px);
        }

        /* random button */
        .random-btn {
            background: rgba(212,165,116,0.15);
            border: 1px solid var(--color-accent);
            color: var(--color-accent);
            padding: 0.6rem 1.2rem;
            border-radius: 40px;
            font-size: 0.7rem;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            cursor: pointer;
            transition: var(--transition);
            margin: 0 auto 2rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            animation: pulse-gold 1.5s infinite;
        }
        .random-btn:hover {
            background: var(--color-accent);
            color: var(--color-primary);
            transform: scale(1.05);
        }
        @keyframes pulse-gold {
            0% { box-shadow: 0 0 0 0 rgba(212,165,116,0.4); }
            70% { box-shadow: 0 0 0 10px rgba(212,165,116,0); }
            100% { box-shadow: 0 0 0 0 rgba(212,165,116,0); }
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
            margin-top: 3rem;
        }

        @media (max-width: 768px) {
            .main-container {
                padding: 1rem;
            }
            .games-grid {
                grid-template-columns: 1fr;
            }
            .filter-bar {
                gap: 0.5rem;
            }
            .filter-btn {
                padding: 0.3rem 0.8rem;
                font-size: 0.6rem;
            }
        }
    </style>
</head>
<body>

    @include('layouts.navbar')

    <div id="tsparticles"></div>
    <div class="floating-bg">🎲 🃏 🧩 🎯 🎲</div>

    <main class="main-container">
        <div class="library-header">
            <h1>🎲 Game Library</h1>
            <p>Borrow & play at your table — roll the dice!</p>
            <div class="flex justify-center mt-4">
                <button id="randomGameBtn" class="random-btn">
                    <i class="fas fa-dice-d6"></i> 骰出驚喜
                </button>
            </div>
        </div>

        <!-- Filter buttons -->
        <div class="filter-bar">
            <button class="filter-btn active" data-filter="all">All Games</button>
            <button class="filter-btn" data-filter="small">Small (2‑3 players)</button>
            <button class="filter-btn" data-filter="medium">Medium (4‑6 players)</button>
            <button class="filter-btn" data-filter="large">Large (6‑8 players)</button>
        </div>

        <div class="games-grid" id="gamesGrid">
            @forelse($boardGames as $game)
                @php
                    // Determine size category based on max_players
                    $maxPlayers = $game->max_players;
                    if ($maxPlayers <= 3) $sizeCat = 'small';
                    elseif ($maxPlayers <= 6) $sizeCat = 'medium';
                    else $sizeCat = 'large';
                @endphp
                <div class="game-card" data-game-id="{{ $game->id }}" data-game-name="{{ $game->name }}" data-size="{{ $sizeCat }}">
                    <div class="relative overflow-hidden">
                        @if($game->image)
                            <img src="{{ asset('storage/' . $game->image) }}" class="game-img" alt="{{ $game->name }}">
                        @else
                            <div class="game-img flex items-center justify-center bg-gray-800">
                                <i class="fas fa-chess-board text-4xl text-gray-500"></i>
                            </div>
                        @endif
                        <div class="absolute bottom-2 right-2 bg-black/70 text-white text-[9px] px-2 py-1 rounded uppercase tracking-wider">
                            {{ ucfirst($game->category) }}
                        </div>
                    </div>
                    <div class="card-content">
                        <h3 class="game-title">{{ $game->name }}</h3>
                        <div class="game-stats">
                            <span><i class="fas fa-users"></i> {{ $game->min_players }}-{{ $game->max_players }}</span>
                            @if($game->play_time_minutes)
                                <span><i class="fas fa-hourglass-half"></i> {{ $game->play_time_minutes }} min</span>
                            @endif
                        </div>
                        <p class="game-description">{{ Str::limit($game->description, 100) }}</p>
                        <div class="availability {{ $game->is_available ? 'available' : 'unavailable' }}">
                            {{ $game->is_available ? '✓ Available now' : '✗ Currently borrowed' }}
                        </div>
                        <a href="{{ route('board-games.show', $game) }}" class="play-btn">
                            <i class="fas fa-dice-d6"></i> Details
                        </a>
                    </div>
                </div>
            @empty
                <div class="text-center text-gray-400 col-span-full py-8">No board games available yet. Check back soon!</div>
            @endforelse
        </div>
    </main>

    <footer class="footer">
        © 2026 Meeple Corner Café — Roll responsibly. Sip slowly. Play often.
    </footer>

    <script>
        // GSAP fade-in animations
        gsap.from(".library-header", { opacity: 0, y: 30, duration: 0.8, ease: "power2.out" });

        // tsParticles (board game theme)
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

        // Confetti helper
        function celebrate(particleCount = 100) {
            canvasConfetti({ particleCount, spread: 70, origin: { y: 0.6 }, colors: ['#d4a574', '#e8c9a9', '#ffffff'] });
        }

        // Filter functionality
        const filterBtns = document.querySelectorAll('.filter-btn');
        const gameCards = document.querySelectorAll('.game-card');

        filterBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                // Update active class
                filterBtns.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                const filterValue = btn.getAttribute('data-filter');

                // Show/hide cards based on data-size attribute
                gameCards.forEach(card => {
                    if (filterValue === 'all') {
                        card.style.display = '';
                    } else {
                        const cardSize = card.getAttribute('data-size');
                        card.style.display = cardSize === filterValue ? '' : 'none';
                    }
                });
            });
        });

        // Random game picker (only visible games)
        const randomBtn = document.getElementById('randomGameBtn');
        function getVisibleGames() {
            return Array.from(gameCards).filter(card => card.style.display !== 'none');
        }

        randomBtn.addEventListener('click', () => {
            const visibleGames = getVisibleGames();
            if (visibleGames.length === 0) return;
            const randomIndex = Math.floor(Math.random() * visibleGames.length);
            const targetGame = visibleGames[randomIndex];
            const gameName = targetGame.getAttribute('data-game-name') || 'this game';
            targetGame.scrollIntoView({ behavior: 'smooth', block: 'center' });
            targetGame.style.transition = 'all 0.2s';
            targetGame.style.boxShadow = '0 0 0 3px #d4a574, 0 10px 20px rgba(0,0,0,0.2)';
            setTimeout(() => { targetGame.style.boxShadow = ''; }, 1000);
            celebrate(120);
            setTimeout(() => {
                alert(`🎲 Dice says: "${gameName}"! Ask our staff to bring it to your table.`);
            }, 200);
        });

        // Details button already links to game page, no extra alert needed
        // Card click confetti (but not when clicking the details button)
        document.querySelectorAll('.game-card').forEach(card => {
            card.addEventListener('click', (e) => {
                if (e.target.closest('.play-btn')) return;
                celebrate(40);
            });
        });
    </script>
</body>
</html>