<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu | Meeple Corner Café</title>
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
        /* ===== DARK THEME STYLES ===== */
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
            max-width: 1000px;
            margin: 0 auto;
            padding: 2rem;
            width: 100%;
            position: relative;
            z-index: 2;
        }

        .menu-header {
            text-align: center;
            margin-bottom: 3rem;
        }
        .menu-header h1 {
            font-family: var(--font-heading);
            font-size: 2.8rem;
            color: var(--color-white);
            margin-bottom: 0.5rem;
        }
        .menu-header p {
            font-size: 0.8rem;
            color: var(--color-text-muted);
            letter-spacing: 0.2em;
        }

        /* Category title */
        .category-title {
            font-family: var(--font-heading);
            font-size: 1.8rem;
            color: var(--color-accent);
            border-bottom: 2px solid rgba(212,165,116,0.3);
            display: inline-block;
            margin: 1.5rem 0 1rem;
            padding-bottom: 0.3rem;
        }

        /* Menu items as vertical list */
        .menu-list {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }
        .menu-item {
            background: rgba(255,255,255,0.03);
            backdrop-filter: blur(4px);
            border-radius: 20px;
            transition: var(--transition);
            border: 1px solid rgba(212,165,116,0.1);
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 0.8rem 1.2rem;
        }
        .menu-item:hover {
            background: rgba(212,165,116,0.08);
            border-color: var(--color-accent);
            transform: translateX(8px);
        }
        .item-image {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            object-fit: cover;
            background: rgba(0,0,0,0.3);
            flex-shrink: 0;
        }
        .no-image {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            background: rgba(0,0,0,0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--color-text-muted);
            font-size: 1.5rem;
        }
        .item-info {
            flex: 1;
        }
        .item-name {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--color-white);
            margin-bottom: 0.2rem;
        }
        .item-price {
            font-size: 1rem;
            font-weight: bold;
            color: var(--color-accent);
            white-space: nowrap;
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
            .main-container {
                padding: 1rem;
            }
            .menu-item {
                flex-wrap: wrap;
                gap: 0.8rem;
            }
            .item-price {
                margin-left: auto;
            }
        }
    </style>
</head>
<body>

    @include('layouts.navbar')

    <div id="tsparticles"></div>
    <div class="floating-bg">☕ 🍰 🥪 🎲</div>

    <main class="main-container">
        <div class="menu-header">
            <h1>☕ Our Menu</h1>
            <p>Curated for the discerning palate</p>
        </div>

        @forelse($groupedMenu as $category => $items)
            <div class="menu-category">
                <h2 class="category-title">{{ ucfirst($category) }}</h2>
                <div class="menu-list">
                    @foreach($items as $menuItem)
                        <div class="menu-item">
                            <div class="item-image">
                                @if($menuItem->image)
                                    <img src="{{ asset($menuItem->image) }}" class="item-image" alt="{{ $menuItem->name }}">
                                @else
                                    <div class="no-image">
                                        <i class="fas fa-utensils"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="item-info">
                                <div class="item-name">{{ $menuItem->name }}</div>
                            </div>
                            <div class="item-price">${{ number_format($menuItem->price, 2) }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        @empty
            <div class="text-center text-gray-400 py-8">No menu items available yet.</div>
        @endforelse
    </main>

    <footer class="footer">
        © 2026 Meeple Corner Café — Roll responsibly. Sip slowly. Play often.
    </footer>

    <script>
        // GSAP animations
        gsap.from(".menu-header", { opacity: 0, y: 30, duration: 0.8, ease: "power2.out" });
        gsap.from(".menu-category", { opacity: 0, y: 20, duration: 0.6, stagger: 0.15, scrollTrigger: { trigger: ".menu-category", start: "top 85%" } });

        // tsParticles
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