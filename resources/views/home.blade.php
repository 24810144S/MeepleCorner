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

        /* ===== HEADER (30/70 split) ===== */
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
            flex: 3;
            padding: var(--spacing-lg) var(--spacing-xl);
            display: flex;
            flex-direction: column;
            justify-content: center;
            gap: var(--spacing-md);
            z-index: 2;
            backdrop-filter: blur(2px);
        }
        .header_image {
            flex: 7;
            background-image: url("{{ asset('img/home.jpeg') }}");
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

        /* ===== ABOUT ===== */
        .about {
            padding: var(--spacing-xl) var(--spacing-lg);
            background-color: var(--color-secondary);
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

        /* ===== GAME CATEGORY CAROUSEL (Full width, shorter) ===== */
        .collections {
            padding: var(--spacing-xl) 0;
            background-color: var(--color-primary);
            overflow-x: hidden;
        }
        .collections_inner {
            max-width: 1300px;
            margin: 0 auto;
            padding: 0 2rem;
        }
        .collections_header {
            text-align: center;
            margin-bottom: var(--spacing-xl);
        }
        .collections_title {
            font-size: var(--text-lg);
            color: var(--color-white);
        }
        .collections_title span {
            color: var(--color-accent);
        }

        .game-carousel {
            position: relative;
            margin-top: 2rem;
            width: 100vw;
            margin-left: calc(50% - 50vw);
        }
        .carousel-container {
            position: relative;
            overflow: hidden;
            border-radius: 0;
            box-shadow: 0 20px 35px -10px rgba(0,0,0,0.5);
        }
        .carousel-slides {
            display: flex;
            transition: transform 0.5s ease-in-out;
        }
        .carousel-slide {
            flex: 0 0 100%;
            position: relative;
            height: 700px; /* shorter height */
        }
        .slide-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-size: cover;
            background-position: center;
            transition: transform 0.3s ease;
        }
        .carousel-slide:hover .slide-bg {
            transform: scale(1.02);
        }
        .slide-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, rgba(26,15,7,0.85) 0%, rgba(26,15,7,0.6) 50%, transparent 100%);
            display: flex;
            align-items: center;
            padding: 2rem;
        }
        .slide-content {
            max-width: 50%;
            color: var(--color-white);
        }
        .slide-title {
            font-family: var(--font-heading);
            font-size: 2.5rem;
            margin-bottom: 0.75rem;
            text-shadow: 0 2px 5px rgba(0,0,0,0.3);
        }
        .slide-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            margin-bottom: 1rem;
            font-size: 0.8rem;
            color: var(--color-accent-light);
        }
        .category-badge {
            background: rgba(212,165,116,0.2);
            padding: 0.2rem 0.6rem;
            border-radius: 30px;
            font-size: 0.7rem;
        }
        .slide-description {
            font-size: 0.9rem;
            line-height: 1.5;
            margin-bottom: 1.5rem;
            color: var(--color-text);
        }
        .slide-link {
            display: inline-block;
            background: var(--color-accent);
            color: var(--color-primary);
            padding: 0.5rem 1.2rem;
            border-radius: 40px;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 0.7rem;
            letter-spacing: 0.1em;
            text-decoration: none;
            transition: var(--transition);
        }
        .slide-link:hover {
            background: var(--color-accent-light);
            transform: translateY(-2px);
        }

        .carousel-prev, .carousel-next {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(0,0,0,0.5);
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            color: white;
            cursor: pointer;
            transition: var(--transition);
            z-index: 10;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }
        .carousel-prev { left: 20px; }
        .carousel-next { right: 20px; }
        .carousel-prev:hover, .carousel-next:hover {
            background: var(--color-accent);
            color: var(--color-primary);
        }

        .carousel-dots {
            display: flex;
            justify-content: center;
            gap: 0.75rem;
            margin-top: 1rem;
        }
        .dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: rgba(255,255,255,0.4);
            cursor: pointer;
            transition: var(--transition);
        }
        .dot.active {
            background: var(--color-accent);
            width: 24px;
            border-radius: 10px;
        }

        /* ===== STORIES ===== */
        .stories {
            padding: var(--spacing-xl) var(--spacing-lg);
            background: linear-gradient(135deg, var(--color-secondary) 0%, var(--color-primary) 100%);
        }
        .stories_container { max-width: 1300px; margin: 0 auto; }
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

        /* ===== FOOTER ===== */
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
        .footer_brand { flex: 1.5; }
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
        .newsletter button:hover { background: var(--color-accent-light); transform: scale(0.98); }
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
            .carousel-slide {
                height: 300px;
            }
            .slide-content {
                max-width: 80%;
            }
            .slide-title {
                font-size: 1.8rem;
            }
            .carousel-prev, .carousel-next {
                width: 32px;
                height: 32px;
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
@include('layouts.navbar')

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
        <a href="/reservation" class="cta-button">Book Tables</a>
    </div>
    <div class="header_image"></div>
</header>

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

<!-- FEATURED GAME CATEGORIES CAROUSEL -->
<section class="collections">
    <div class="collections_inner">
        <div class="collections_header">
            <h2 class="collections_title">Game <span>Categories</span></h2>
        </div>

        <div class="game-carousel">
            <div class="carousel-container">
                <div class="carousel-slides" id="carouselSlides">
                    @php
                        // Extract unique categories from the collection
                        $categories = $boardGames->pluck('category')->unique()->values();

                        // Custom images per category (replace these URLs with your own images)
                        $categoryImages = [
                            'Strategy' => asset('img/game/strategic-planning.webp'),
                            'Card Game' => asset('img/game/cardgames.webp'),
                            'Abstract' => asset('img/game/Abstract.jpg'),
                            'Family' => asset('img/game/family.jpeg'),
                            'Party' => asset('img/game/party.jpg'),
                            'Social Deduction' => asset('img/game/social_deduction.webp'),
                            'RPG' => asset('img/game/rpg.jpg'),
                            ];

                        // Fallback helper (if category not in array, use first game's image)
                        $getImage = function($cat) use ($boardGames, $categoryImages) {
                            return $categoryImages[$cat] ?? (
                                $boardGames->firstWhere('category', $cat)?->image 
                                    ? asset($boardGames->firstWhere('category', $cat)->image) 
                                    : 'https://images.unsplash.com/photo-1611996575749-79a3a239f9f5?auto=format&fit=crop&w=1200'
                            );
                        };

                        // Category descriptions (customize as needed)
                        $categoryDescriptions = [
                            'Strategy' => 'Test your tactical thinking with deep, rewarding strategy games.',
                            'Card Game' => 'Fast-paced card games for all ages.',
                            'Abstract' => 'Elegant, minimalist games of pure skill.',
                            'Family' => 'Perfect for family game nights.',
                            'Party' => 'Gather your friends for hilarious and fast‑paced party games.',
                            'Social Deduction' => 'Uncover secrets, bluff, and deduce the truth.',
                            'RPG' => 'Immersive role‑playing adventures for large groups.',
                        ];
                    @endphp
                    @forelse($categories as $category)
                        @php
                            $image = $getImage($category);
                            $desc = $categoryDescriptions[$category] ?? 'Explore our collection of ' . $category . ' games.';
                        @endphp
                        <div class="carousel-slide" data-category="{{ $category }}">
                            <div class="slide-bg" style="background-image: url('{{ $image }}');"></div>
                            <div class="slide-overlay">
                                <div class="slide-content">
                                    <h3 class="slide-title">{{ $category }}</h3>
                                    <div class="slide-meta">
                                        <span class="category-badge">{{ $category }}</span>
                                    </div>
                                    <p class="slide-description">{{ $desc }}</p>
                                    <a href="{{ route('board-games.index', ['category' => $category]) }}" class="slide-link">Explore {{ $category }} →</a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="carousel-slide">
                            <div class="slide-bg" style="background-image: url('https://images.unsplash.com/photo-1611996575749-79a3a239f9f5?auto=format&fit=crop&w=1200');"></div>
                            <div class="slide-overlay">
                                <div class="slide-content">
                                    <h3 class="slide-title">Coming Soon</h3>
                                    <p class="slide-description">New categories are on their way. Check back later!</p>
                                </div>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
            <button class="carousel-prev" id="carouselPrev"><i class="fas fa-chevron-left"></i></button>
            <button class="carousel-next" id="carouselNext"><i class="fas fa-chevron-right"></i></button>
            <div class="carousel-dots" id="carouselDots"></div>
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

        gsap.from(".about_title, .about_description", {
            scrollTrigger: { trigger: ".about", start: "top 85%" },
            y: 40, opacity: 0, duration: 0.8, stagger: 0.15
        });
        gsap.from(".collections_header", {
            scrollTrigger: { trigger: ".collections", start: "top 85%" },
            y: 30, opacity: 0, duration: 0.6
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

    // ==================== CAROUSEL FUNCTIONALITY ====================
    const slides = document.querySelectorAll('.carousel-slide');
    const prevBtn = document.getElementById('carouselPrev');
    const nextBtn = document.getElementById('carouselNext');
    const dotsContainer = document.getElementById('carouselDots');
    let currentIndex = 0;
    const totalSlides = slides.length;

    if (totalSlides > 0) {
        function createDots() {
            dotsContainer.innerHTML = '';
            for (let i = 0; i < totalSlides; i++) {
                const dot = document.createElement('div');
                dot.classList.add('dot');
                if (i === currentIndex) dot.classList.add('active');
                dot.addEventListener('click', () => goToSlide(i));
                dotsContainer.appendChild(dot);
            }
        }

        function updateDots() {
            document.querySelectorAll('.dot').forEach((dot, idx) => {
                if (idx === currentIndex) dot.classList.add('active');
                else dot.classList.remove('active');
            });
        }

        function goToSlide(index) {
            if (index < 0) index = totalSlides - 1;
            if (index >= totalSlides) index = 0;
            currentIndex = index;
            const offset = -currentIndex * 100;
            document.querySelector('.carousel-slides').style.transform = `translateX(${offset}%)`;
            updateDots();
        }

        function nextSlide() { goToSlide(currentIndex + 1); }
        function prevSlide() { goToSlide(currentIndex - 1); }

        prevBtn.addEventListener('click', prevSlide);
        nextBtn.addEventListener('click', nextSlide);

        let autoplayInterval;
        function startAutoplay() { autoplayInterval = setInterval(nextSlide, 5000); }
        function stopAutoplay() { clearInterval(autoplayInterval); }
        startAutoplay();

        const carouselContainer = document.querySelector('.carousel-container');
        carouselContainer.addEventListener('mouseenter', stopAutoplay);
        carouselContainer.addEventListener('mouseleave', startAutoplay);

        createDots();
        goToSlide(0);
    }

    // ==================== NEWSLETTER CONFETTI ====================
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

    // ==================== CTA BUTTON CONFETTI ====================
    const ctaButton = document.querySelector('.cta-button');
    if (ctaButton) {
        ctaButton.addEventListener('click', function(e) {
            canvasConfetti({ particleCount: 150, spread: 90, origin: { y: 0.5 } });
        });
    }
</script>
</body>
</html>