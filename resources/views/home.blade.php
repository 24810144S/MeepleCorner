<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meeple Corner Café | Boutique Board Game Experience</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- GSAP -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>
    <!-- Canvas Confetti -->
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1"></script>
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* ... (all your CSS remains exactly the same, no changes needed) ... */
        /* Copy all the CSS from your original file here */
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
            --text-xs: 0.875rem;
            --text-sm: 1rem;
            --text-md: 1.25rem;
            --text-lg: 3rem;
            --text-xl: 4.8rem;
            --text-stats: 3.5rem;
            --transition: all 0.4s cubic-bezier(0.2, 0.9, 0.4, 1.1);
        }

        body {
            font-family: var(--font-body);
            line-height: 1.6;
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

        h1, h2, h3, .logo, .stat_number {
            font-family: var(--font-heading);
            font-weight: 500;
            letter-spacing: -0.02em;
        }

        .header {
            min-height: 100vh;
            display: flex;
            background: linear-gradient(125deg, var(--color-primary) 55%, var(--color-secondary));
            position: relative;
            overflow: hidden;
        }

        .header::before {
            content: "";
            position: absolute;
            width: 150%;
            height: 150%;
            top: -25%;
            left: -25%;
            background: radial-gradient(circle at 30% 40%, rgba(212,165,116,0.12) 0%, transparent 70%);
            pointer-events: none;
        }

        .header_content {
            flex: 1;
            padding: var(--spacing-lg) var(--spacing-xl);
            display: flex;
            flex-direction: column;
            justify-content: center;
            gap: var(--spacing-md);
            z-index: 2;
            backdrop-filter: blur(2px);
        }

        .header_image {
            flex: 1;
            background-image: url("{{ asset('/IND/images/coffee.png') }}");
            background-size: cover;
            background-position: center 30%;
            position: relative;
            z-index: 1;
        }

        .header_image::after {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(100deg, var(--color-primary) 0%, transparent 80%);
            opacity: 0.55;
        }

        .logo {
            font-size: 1.8rem;
            font-weight: 600;
            color: var(--color-accent);
            text-decoration: none;
            transition: var(--transition);
        }

        .logo:hover { color: var(--color-accent-light); letter-spacing: 1px; }

        .hashtag {
            color: var(--color-accent-light);
            font-size: 0.8rem;
            letter-spacing: 5px;
            text-transform: uppercase;
            opacity: 0.8;
        }

        .header_title {
            font-size: var(--text-xl);
            color: var(--color-white);
            line-height: 1.1;
            max-width: 85%;
        }

        .header_title span {
            color: var(--color-accent);
            display: block;
            margin-top: 0.5rem;
        }

        .header_subtitle {
            font-size: var(--text-sm);
            max-width: 80%;
            color: var(--color-text);
        }

        .cta-button {
            display: inline-block;
            padding: 1rem 2.2rem;
            background: var(--color-accent);
            color: var(--color-primary);
            text-decoration: none;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 2px;
            border-radius: 40px;
            transition: var(--transition);
            width: fit-content;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .cta-button:hover {
            background: var(--color-accent-light);
            transform: translateY(-4px);
            box-shadow: 0 15px 25px -8px rgba(0,0,0,0.3);
        }

        .game-picker {
            padding: 4rem 2rem;
            background: linear-gradient(135deg, rgba(44,24,16,0.8) 0%, rgba(26,15,7,0.9) 100%);
            text-align: center;
            border-bottom: 1px solid rgba(212,165,116,0.2);
        }

        .game-picker_inner {
            max-width: 800px;
            margin: 0 auto;
        }

        .game-picker_title {
            font-family: var(--font-heading);
            font-size: 2rem;
            color: var(--color-white);
            margin-bottom: 1rem;
        }

        .game-picker_title span {
            color: var(--color-accent);
        }

        .dice-button {
            background: rgba(212,165,116,0.15);
            border: 2px solid var(--color-accent);
            color: var(--color-accent);
            font-size: 2rem;
            padding: 1rem 2rem;
            border-radius: 80px;
            cursor: pointer;
            transition: var(--transition);
            margin: 1.5rem 0;
            display: inline-flex;
            align-items: center;
            gap: 1rem;
            font-weight: 600;
        }

        .dice-button:hover {
            background: var(--color-accent);
            color: var(--color-primary);
            transform: scale(1.05);
        }

        .rolling {
            animation: rollDice 0.5s cubic-bezier(0.34, 1.2, 0.64, 1);
        }

        @keyframes rollDice {
            0% { transform: rotate(0deg) scale(1); }
            50% { transform: rotate(180deg) scale(1.2); }
            100% { transform: rotate(360deg) scale(1); }
        }

        .suggest-card {
            background: rgba(255,255,255,0.05);
            backdrop-filter: blur(12px);
            border-radius: 32px;
            padding: 2rem;
            margin-top: 2rem;
            border-left: 6px solid var(--color-accent);
            animation: slideFade 0.5s ease-out;
        }

        @keyframes slideFade {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .suggest-card h4 {
            font-size: 1.8rem;
            font-family: var(--font-heading);
            color: var(--color-accent);
        }

        .about {
            padding: var(--spacing-xl) var(--spacing-lg);
            background-color: var(--color-secondary);
            position: relative;
        }

        .about_inner {
            max-width: 1300px;
            margin: 0 auto;
            text-align: center;
        }

        .about_title {
            font-size: var(--text-lg);
            color: var(--color-white);
            margin-bottom: var(--spacing-md);
        }

        .about_title span { color: var(--color-accent); }

        .about_description {
            font-size: var(--text-md);
            max-width: 800px;
            margin: 0 auto var(--spacing-xl);
            line-height: 1.8;
            color: var(--color-text-muted);
        }

        .stats_container {
            display: flex;
            justify-content: center;
            gap: var(--spacing-lg);
            flex-wrap: wrap;
        }

        .stat {
            background: rgba(255,255,255,0.04);
            backdrop-filter: blur(8px);
            border-radius: 24px;
            padding: var(--spacing-md) var(--spacing-lg);
            min-width: 200px;
            border: 1px solid rgba(212,165,116,0.2);
            transition: var(--transition);
        }

        .stat:hover {
            transform: translateY(-8px);
            border-color: var(--color-accent);
            background: rgba(212,165,116,0.08);
        }

        .stat_number {
            font-size: var(--text-stats);
            color: var(--color-accent);
            font-weight: 600;
            line-height: 1;
        }

        .stat_label {
            font-size: var(--text-xs);
            text-transform: uppercase;
            letter-spacing: 2px;
            color: var(--color-text-muted);
        }

        .collections {
            padding: var(--spacing-xl) var(--spacing-lg);
            background-color: var(--color-primary);
        }

        .collections_inner {
            max-width: 1300px;
            margin: 0 auto;
        }

        .collections_header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: var(--spacing-md);
            margin-bottom: var(--spacing-xl);
        }

        .collections_title {
            font-size: var(--text-lg);
            color: var(--color-white);
        }

        .collections_title span { color: var(--color-accent); }

        .collection_filters {
            display: flex;
            gap: var(--spacing-sm);
            flex-wrap: wrap;
        }

        .collection_filter {
            color: var(--color-text-muted);
            text-decoration: none;
            padding: 0.5rem 1.2rem;
            border-radius: 40px;
            font-weight: 500;
            transition: var(--transition);
            background: rgba(255,255,255,0.03);
        }

        .collection_filter:hover, .collection_filter.active {
            background: var(--color-accent);
            color: var(--color-primary);
        }

        .product_grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: var(--spacing-lg);
        }

        .product_card {
            background: rgba(255,255,255,0.03);
            backdrop-filter: blur(4px);
            border-radius: 28px;
            overflow: hidden;
            transition: var(--transition);
            border: 1px solid rgba(212,165,116,0.1);
            cursor: pointer;
        }

        .product_card:hover {
            transform: translateY(-12px);
            border-color: var(--color-accent);
            box-shadow: 0 25px 40px -15px rgba(0,0,0,0.5);
        }

        .product_image {
            height: 260px;
            background-size: cover;
            background-position: center;
            transition: transform 0.6s ease;
        }

        .product_card:hover .product_image {
            transform: scale(1.05);
        }

        .product_content {
            padding: var(--spacing-md);
        }

        .product_title {
            font-size: 1.6rem;
            margin-bottom: 0.5rem;
            color: var(--color-white);
        }

        .product_players {
            display: inline-block;
            font-size: 0.7rem;
            background: rgba(212,165,116,0.2);
            padding: 0.2rem 0.8rem;
            border-radius: 30px;
            color: var(--color-accent);
            margin-bottom: 1rem;
        }

        .product_description {
            font-size: 0.9rem;
            color: var(--color-text-muted);
            margin-bottom: 1rem;
        }

        .product_time {
            font-size: 0.8rem;
            color: var(--color-accent-light);
            margin-bottom: 1.2rem;
            font-weight: 500;
        }

        .product_link {
            color: var(--color-accent);
            text-decoration: none;
            font-weight: 600;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: var(--transition);
        }

        .product_link:hover { letter-spacing: 2px; }

        .stories {
            padding: var(--spacing-xl) var(--spacing-lg);
            background: linear-gradient(135deg, var(--color-secondary) 0%, var(--color-primary) 100%);
            position: relative;
        }

        .stories_container {
            max-width: 1300px;
            margin: 0 auto;
        }

        .stories_header {
            text-align: center;
            margin-bottom: var(--spacing-xl);
        }

        .stories_label {
            font-size: 0.8rem;
            letter-spacing: 6px;
            color: var(--color-accent);
            text-transform: uppercase;
            margin-bottom: var(--spacing-sm);
            display: inline-block;
        }

        .stories_title {
            font-size: var(--text-lg);
            color: var(--color-white);
        }

        .stories_title span { color: var(--color-accent); }

        .stories_subtitle {
            font-size: var(--text-md);
            color: var(--color-text-muted);
            max-width: 600px;
            margin: 1rem auto 0;
        }

        .stories_grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: var(--spacing-lg);
        }

        .story_card {
            background: rgba(0,0,0,0.3);
            backdrop-filter: blur(12px);
            border-radius: 32px;
            padding: var(--spacing-lg);
            border: 1px solid rgba(212,165,116,0.2);
            transition: var(--transition);
        }

        .story_card:hover {
            transform: translateY(-8px);
            border-color: var(--color-accent);
            background: rgba(212,165,116,0.05);
        }

        .story_icon {
            font-size: 3rem;
            margin-bottom: var(--spacing-md);
        }

        .story_title {
            font-size: 1.8rem;
            color: var(--color-white);
            margin-bottom: var(--spacing-sm);
        }

        .story_description {
            color: var(--color-text-muted);
            margin-bottom: var(--spacing-md);
            line-height: 1.7;
        }

        .story_link {
            color: var(--color-accent);
            text-decoration: none;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: var(--transition);
        }

        .story_link:hover { gap: 1rem; color: var(--color-accent-light); }

        .footer {
            background-color: #0c0704;
            padding: var(--spacing-xl) var(--spacing-lg) var(--spacing-md);
            border-top: 1px solid rgba(212,165,116,0.2);
        }

        .footer_inner {
            max-width: 1300px;
            margin: 0 auto;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            gap: var(--spacing-lg);
        }

        .footer_brand {
            flex: 1.5;
        }

        .footer_logo {
            font-family: var(--font-heading);
            font-size: 1.8rem;
            color: var(--color-accent);
            text-decoration: none;
            display: inline-block;
            margin-bottom: var(--spacing-sm);
        }

        .footer_tagline {
            color: var(--color-text-muted);
            max-width: 280px;
        }

        .footer_links {
            flex: 1;
            display: flex;
            gap: var(--spacing-lg);
            justify-content: flex-end;
            flex-wrap: wrap;
        }

        .footer_column h4 {
            color: var(--color-white);
            margin-bottom: var(--spacing-sm);
            font-size: 1rem;
        }

        .footer_column a {
            color: var(--color-text-muted);
            text-decoration: none;
            display: block;
            margin-bottom: 0.6rem;
            transition: var(--transition);
        }

        .footer_column a:hover { color: var(--color-accent); transform: translateX(4px); }

        .newsletter input {
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(212,165,116,0.3);
            padding: 0.8rem 1rem;
            border-radius: 60px;
            color: white;
            width: 220px;
        }

        .newsletter button {
            background: var(--color-accent);
            border: none;
            padding: 0.8rem 1.5rem;
            border-radius: 60px;
            font-weight: bold;
            cursor: pointer;
            transition: var(--transition);
        }

        .newsletter button:hover { background: var(--color-accent-light); transform: scale(0.98);}

        .copyright {
            text-align: center;
            padding-top: var(--spacing-lg);
            margin-top: var(--spacing-lg);
            border-top: 1px solid rgba(255,255,255,0.05);
            color: var(--color-text-muted);
            font-size: 0.8rem;
        }

        @media (max-width: 900px) {
            :root {
                --spacing-xl: 4rem;
                --text-xl: 3rem;
                --text-lg: 2.2rem;
            }
            .header {
                flex-direction: column;
            }
            .header_image {
                min-height: 350px;
            }
            .stories_grid {
                grid-template-columns: 1fr;
            }
            .footer_inner {
                flex-direction: column;
            }
            .footer_links {
                justify-content: flex-start;
            }
        }
    </style>
</head>
<body>

<!-- HEADER -->
<header class="header">
    <div class="header_content">
        <a href="#" class="logo">Meeple Corner Café</a>
        <p class="hashtag">#rollandrelax</p>
        <h1 class="header_title">
            Strategy & 
            <span>Serenity</span>
            Over Coffee
        </h1>
        <p class="header_subtitle">
            A boutique board game café where every visit is a new adventure. Sip, strategize, and socialize.
        </p>
        <a href="create" class="cta-button">Explore Our Games</a>
    </div>
    <div class="header_image"></div>
</header>

<!-- RANDOM GAME PICKER -->
<section class="game-picker">
    <div class="game-picker_inner">
        <h2 class="game-picker_title">🎲 <span>Roll the Dice</span> 🎲</h2>
        <p class="header_subtitle" style="margin:0 auto 1rem;">Can't decide what to play? Let fate choose for you!</p>
        <button id="randomGameBtn" class="dice-button">
            <span class="dice-icon">🎲</span> Pick a Game for Me
        </button>
        <div id="gameSuggestion" class="suggest-card" style="display: none;">
            <p style="font-size:0.8rem; letter-spacing:2px; color:var(--color-accent);">TODAY'S ADVENTURE</p>
            <h4 id="suggestedGameName"></h4>
            <p id="suggestedGameDesc" style="margin-top:0.5rem;"></p>
        </div>
    </div>
</section>

<!-- ABOUT -->
<section class="about">
    <div class="about_inner">
        <h2 class="about_title">Our <span>Tabletop Haven</span></h2>
        <p class="about_description">
            Founded in 2026, Meeple Corner Café blends the warmth of specialty coffee with the joy of modern board gaming. 
            With over 300 hand-picked games, expert game masters, and a cozy atmosphere, we've become the ultimate destination 
            for gamers and casual visitors alike.
        </p>
        <div class="stats_container">
            <div class="stat"><div class="stat_number">300+</div><div class="stat_label">Board Games</div></div>
            <div class="stat"><div class="stat_number">15</div><div class="stat_label">Coffee Blends</div></div>
            <div class="stat"><div class="stat_number">5k+</div><div class="stat_label">Happy Gamers</div></div>
        </div>
    </div>
</section>

<!-- GAME COLLECTIONS - DYNAMIC FROM DATABASE -->
<section class="collections">
    <div class="collections_inner">
        <div class="collections_header">
            <h2 class="collections_title">Featured <span>Board Games</span></h2>
            <div class="collection_filters">
                <a href="#" class="collection_filter active" data-category="all">All Games</a>
                <a href="#" class="collection_filter" data-category="strategy">Strategy</a>
                <a href="#" class="collection_filter" data-category="party">Party</a>
                <a href="#" class="collection_filter" data-category="cooperative">Cooperative</a>
            </div>
        </div>
        <div class="product_grid">
            @forelse($boardGames as $game)
                <div class="product_card" data-game-id="{{ $game->id }}" data-category="{{ $game->category }}">
                    <div class="product_image" style="background-image: url('{{ $game->image ? asset('storage/' . $game->image) : 'https://images.unsplash.com/photo-1611996575749-79a3a239f9f5?auto=format&fit=crop&w=600' }}');"></div>
                    <div class="product_content">
                        <h3 class="product_title">{{ $game->name }}</h3>
                        <span class="product_players">{{ $game->min_players }}-{{ $game->max_players }} players</span>
                        <p class="product_description">{{ Str::limit($game->description, 80) }}</p>
                        <p class="product_time">⏱️ {{ $game->play_time_minutes }} min</p>
                        <a href="{{ route('board-games.show', $game) }}" class="product_link">Learn More →</a>
                    </div>
                </div>
            @empty
                <p class="col-span-full text-center text-gray-400">No board games available yet. Check back soon!</p>
            @endforelse
        </div>
    </div>
</section>

<!-- EVENTS / WORKSHOPS -->
<section class="stories">
    <div class="stories_container">
        <div class="stories_header">
            <div class="stories_label">UPCOMING EVENTS</div>
            <h2 class="stories_title">Join the <span>Fun</span></h2>
            <p class="stories_subtitle">Weekly tournaments, learn-to-play sessions, and themed nights</p>
        </div>
        <div class="stories_grid">
            <div class="story_card">
                <div class="story_icon">🏆</div>
                <h3 class="story_title">Catan Championship</h3>
                <p class="story_description">Every Saturday at 7PM. Compete for glory and store credit. Beginners welcome!</p>
                <a href="#" class="story_link">Register →</a>
            </div>
            <div class="story_card">
                <div class="story_icon">🎲</div>
                <h3 class="story_title">Learn to Play: D&D</h3>
                <p class="story_description">Introductory sessions every Wednesday. Create your character and start your adventure.</p>
                <a href="#" class="story_link">Join the Party →</a>
            </div>
        </div>
    </div>
</section>

<!-- FOOTER -->
<footer class="footer">
    <div class="footer_inner">
        <div class="footer_brand">
            <a href="#" class="footer_logo">Meeple Corner Café</a>
            <p class="footer_tagline">Where coffee meets cardboard. Roll dice, sip slowly, and make memories.</p>
        </div>
        <div class="footer_links">
            <div class="footer_column">
                <h4>Explore</h4>
                <a href="#">Game Library</a>
                <a href="#">Events</a>
                <a href="#">Café Menu</a>
            </div>
            <div class="footer_column">
                <h4>Support</h4>
                <a href="#">Contact</a>
                <a href="#">Reservations</a>
                <a href="#">Gift Cards</a>
            </div>
            <div class="footer_column newsletter">
                <h4>Stay updated</h4>
                <input type="email" placeholder="Your email" id="newsletterEmail">
                <button id="newsletterBtn">→</button>
            </div>
        </div>
    </div>
    <div class="copyright">
        © 2026 Meeple Corner Café — All rights reserved. Roll responsibly.
    </div>
</footer>

<script>
    // ==================== GSAP Animations ====================
    gsap.registerPlugin(ScrollTrigger);

    document.addEventListener("DOMContentLoaded", function() {
        const pageIntro = gsap.timeline({ defaults: { ease: "power2.out" } });
        pageIntro
            .from("body", { opacity: 0, duration: 0.6 })
            .from(".header_content", { y: 30, opacity: 0, duration: 0.8, stagger: 0.2 })
            .from(".header_image", { scale: 1.1, opacity: 0, duration: 1.2 }, "-=1");

        gsap.from(".game-picker", {
            scrollTrigger: { trigger: ".game-picker", start: "top 85%" },
            y: 40, opacity: 0, duration: 0.8
        });
        gsap.from(".about_title, .about_description", {
            scrollTrigger: { trigger: ".about", start: "top 85%" },
            y: 40, opacity: 0, duration: 0.8, stagger: 0.15
        });
        gsap.from(".collections_title, .collection_filters", {
            scrollTrigger: { trigger: ".collections", start: "top 85%" },
            y: 30, opacity: 0, duration: 0.6, stagger: 0.2
        });
        gsap.from(".stories_label, .stories_title, .stories_subtitle", {
            scrollTrigger: { trigger: ".stories", start: "top 85%" },
            y: 40, opacity: 0, duration: 0.8, stagger: 0.15
        });
        gsap.from(".footer_brand, .footer_column", {
            scrollTrigger: { trigger: ".footer", start: "top 85%" },
            y: 30, opacity: 0, duration: 0.6, stagger: 0.1
        });
    });

    // ==================== BOARD GAMES DATA FROM LARAVEL ====================
    // Pass the games collection as JSON to JavaScript
    const allBoardGames = @json($boardGames);

    // Helper function to render filtered games (for filters)
    function renderFilteredGames(category) {
        const cards = document.querySelectorAll('.product_card');
        cards.forEach(card => {
            if (category === 'all' || card.getAttribute('data-category') === category) {
                card.style.display = '';
            } else {
                card.style.display = 'none';
            }
        });
    }

    // Filter functionality
    const filters = document.querySelectorAll('.collection_filter');
    filters.forEach(filter => {
        filter.addEventListener('click', (e) => {
            e.preventDefault();
            filters.forEach(f => f.classList.remove('active'));
            filter.classList.add('active');
            const category = filter.getAttribute('data-category');
            renderFilteredGames(category);
        });
    });

    // ==================== RANDOM GAME PICKER ====================
    const randomBtn = document.getElementById('randomGameBtn');
    const suggestDiv = document.getElementById('gameSuggestion');
    const gameNameSpan = document.getElementById('suggestedGameName');
    const gameDescSpan = document.getElementById('suggestedGameDesc');

    function rollDiceAndSuggest() {
        const diceIcon = randomBtn.querySelector('.dice-icon');
        diceIcon.classList.add('rolling');
        setTimeout(() => diceIcon.classList.remove('rolling'), 500);

        if (!allBoardGames || allBoardGames.length === 0) {
            gameNameSpan.textContent = "No games yet!";
            gameDescSpan.textContent = "Check back soon for our collection.";
            suggestDiv.style.display = 'block';
            return;
        }

        const randomIndex = Math.floor(Math.random() * allBoardGames.length);
        const game = allBoardGames[randomIndex];
        gameNameSpan.textContent = game.name;
        gameDescSpan.textContent = game.description || "A fantastic game awaits you at the café!";
        suggestDiv.style.display = 'block';

        canvasConfetti({ particleCount: 100, spread: 80, origin: { y: 0.6 }, colors: ['#d4a574', '#e8c9a9', '#ffffff'] });
    }

    randomBtn.addEventListener('click', rollDiceAndSuggest);

    // Newsletter confetti
    const newsletterBtn = document.getElementById('newsletterBtn');
    if (newsletterBtn) {
        newsletterBtn.addEventListener('click', () => {
            const emailInput = document.getElementById('newsletterEmail');
            if (emailInput.value.trim() !== '') {
                canvasConfetti({ particleCount: 80, spread: 70, origin: { y: 0.7 } });
                alert('Thanks for subscribing! 🎉');
                emailInput.value = '';
            } else {
                alert('Please enter an email address.');
            }
        });
    }

    // CTA button confetti
    const ctaButton = document.querySelector('.cta-button');
    if (ctaButton) {
        ctaButton.addEventListener('click', (e) => {
            e.preventDefault();
            canvasConfetti({ particleCount: 150, spread: 90, origin: { y: 0.5 } });
            setTimeout(() => { window.location.href = '/games'; }, 300);
        });
    }

    // Add confetti to each game card click
    document.querySelectorAll('.product_card').forEach(card => {
        card.addEventListener('click', (e) => {
            if (!e.target.closest('.product_link')) {
                canvasConfetti({ particleCount: 40, spread: 60, origin: { y: 0.7 } });
            }
        });
    });
</script>
</body>
</html>