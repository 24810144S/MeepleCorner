<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Security Questions | Meeple Corner Café</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- GSAP -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <!-- tsParticles -->
    <script src="https://cdn.jsdelivr.net/npm/tsparticles@2.12.0/tsparticles.bundle.min.js"></script>
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* 保持原有的所有 CSS 樣式（不變） */
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
        * { margin: 0; padding: 0; box-sizing: border-box; }
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
        #tsparticles { position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: 0; pointer-events: none; }
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
        .main-wrapper {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            position: relative;
            z-index: 2;
        }
        .form-card {
            max-width: 900px;
            width: 100%;
            background: rgba(255,255,255,0.03);
            backdrop-filter: blur(12px);
            border-radius: 32px;
            overflow: hidden;
            border: 1px solid rgba(212,165,116,0.2);
            display: flex;
            flex-direction: row;
            box-shadow: 0 25px 45px -12px rgba(0,0,0,0.5);
        }
        .brand-side {
            flex: 1;
            background: linear-gradient(135deg, rgba(44,24,16,0.6) 0%, rgba(26,15,7,0.8) 100%);
            padding: 2rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .brand-side h1 {
            font-family: var(--font-heading);
            font-size: 2.2rem;
            color: var(--color-white);
            margin-bottom: 0.5rem;
        }
        .brand-divider {
            width: 50px;
            height: 2px;
            background: var(--color-accent);
            margin: 1rem 0 2rem;
        }
        .form-side {
            flex: 2;
            padding: 2rem;
        }
        .form-side h2 {
            font-family: var(--font-heading);
            font-size: 1.8rem;
            color: var(--color-white);
            margin-bottom: 0.25rem;
        }
        .form-group { margin-bottom: 1.2rem; }
        .form-label {
            display: block;
            font-size: 0.65rem;
            text-transform: uppercase;
            letter-spacing: 0.2em;
            color: var(--color-accent);
            margin-bottom: 0.3rem;
            font-weight: 600;
        }
        .form-input, .form-select {
            width: 100%;
            background: rgba(0,0,0,0.3);
            border: 1px solid rgba(212,165,116,0.3);
            border-radius: 40px;
            padding: 0.7rem 1rem;
            color: white;
            font-size: 0.85rem;
            transition: var(--transition);
        }
        .form-input:focus, .form-select:focus {
            outline: none;
            border-color: var(--color-accent);
            background: rgba(0,0,0,0.5);
        }
        .btn-submit {
            width: 100%;
            background: var(--color-accent);
            color: var(--color-primary);
            border: none;
            border-radius: 40px;
            padding: 0.8rem;
            font-size: 0.7rem;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.2em;
            cursor: pointer;
            transition: var(--transition);
            margin-top: 0.5rem;
        }
        .btn-submit:hover {
            background: var(--color-accent-light);
            transform: translateY(-2px);
        }
        .login-link { text-align: center; margin-top: 1.5rem; font-size: 0.7rem; color: var(--color-text-muted); }
        .login-link a { color: var(--color-accent); text-decoration: none; font-weight: bold; }
        .alert-error {
            background: rgba(220,38,38,0.2);
            border-left: 4px solid #ef4444;
            padding: 0.75rem 1rem;
            border-radius: 16px;
            margin-bottom: 1.5rem;
            color: #fca5a5;
        }
        .home-btn {
            display: inline-block;
            background: var(--color-accent);
            color: var(--color-primary);
            padding: 0.8rem 1.5rem;
            border-radius: 40px;
            text-decoration: none;
            font-weight: bold;
            margin-top: 1rem;
        }
        /* Exceeded attempts message styles */
        .exceeded-container {
            background: rgba(0,0,0,0.3);
            border-radius: 28px;
            padding: 2.5rem 2rem;
            border: 1px solid rgba(212,165,116,0.3);
            backdrop-filter: blur(4px);
            margin: 1rem 0;
        }
        .exceeded-icon {
            width: 80px;
            height: 80px;
            background: rgba(220,38,38,0.15);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            border: 2px solid #ef4444;
        }
        .exceeded-icon i {
            font-size: 2.5rem;
            color: #ef4444;
        }
        .exceeded-title {
            font-family: var(--font-heading);
            font-size: 1.8rem;
            color: var(--color-white);
            margin-bottom: 0.75rem;
        }
        .exceeded-message {
            color: var(--color-text-muted);
            font-size: 0.9rem;
            line-height: 1.5;
            margin-bottom: 2rem;
        }
        .exceeded-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            background: var(--color-accent);
            color: var(--color-primary);
            padding: 0.75rem 2rem;
            border-radius: 40px;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.1em;
            text-decoration: none;
            transition: var(--transition);
        }
        .exceeded-btn:hover {
            background: var(--color-accent-light);
            transform: translateY(-2px);
        }
        @media (max-width: 768px) {
            .form-card { flex-direction: column; }
            .brand-side { text-align: center; }
            .brand-divider { margin-left: auto; margin-right: auto; }
            .main-wrapper { padding: 1rem; }
        }
    </style>
</head>
<body>
    <div id="tsparticles"></div>
    <div class="floating-bg">🎲 🃏 🧩 🎯 🎲</div>
    @include('layouts.navbar')
    <div class="main-wrapper">
        <div class="form-card">
            <div class="brand-side">
                <h1>Security Verification</h1>
                <div class="brand-divider"></div>
                <p>Answer both questions correctly to reset your password.</p>
            </div>
            <div class="form-side">
                @if($exhausted ?? false)
                    <div class="exceeded-container text-center">
                        <div class="exceeded-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h3 class="exceeded-title">Access Locked</h3>
                        <p class="exceeded-message">
                            You have exceeded the maximum number of attempts.<br>
                            For security reasons, please return to the homepage and start over.
                        </p>
                        <a href="/" class="exceeded-btn">
                            <i class="fas fa-home mr-2"></i> Return to Homepage
                        </a>
                    </div>
                @else
                    <h2>Verify Identity</h2>
                    <p class="form-subtitle">
                        @if(($attempts ?? 0) == 0) First attempt @else Second attempt (different questions) @endif
                    </p>

                    @if ($errors->any())
                        <div class="alert-error">
                            @foreach ($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.security-verify-answers') }}">
                        @csrf
                        <div class="form-group">
                            <label class="form-label">{{ $question1 }}</label>
                            @if($question1 == 'What is your favorite board game genre?')
                                <select name="answer1" class="form-select" required>
                                    <option value="">Select a genre</option>
                                    <option value="strategy">Strategy</option>
                                    <option value="party">Party</option>
                                    <option value="cooperative">Cooperative</option>
                                    <option value="deck-building">Deck‑building</option>
                                    <option value="roll_and_write">Roll and Write</option>
                                    <option value="worker_placement">Worker Placement</option>
                                    <option value="social_deduction">Social Deduction</option>
                                    <option value="card_games">Card Games</option>
                                    <option value="family">Family</option>
                                    <option value="abstract">Abstract</option>
                                    <option value="wargame">Wargame</option>
                                    <option value="other">Other</option>
                                </select>
                            @else
                                <input type="text" name="answer1" class="form-input" required>
                            @endif
                        </div>
                        <div class="form-group">
                            <label class="form-label">{{ $question2 }}</label>
                            @if($question2 == 'What is your favorite season of the year?')
                                <select name="answer2" class="form-select" required>
                                    <option value="">Select a season</option>
                                    <option value="winter">Winter</option>
                                    <option value="spring">Spring</option>
                                    <option value="summer">Summer</option>
                                    <option value="fall">Fall</option>
                                </select>
                            @else
                                <input type="text" name="answer2" class="form-input" required>
                            @endif
                        </div>
                        <button type="submit" class="btn-submit">Verify Answers</button>
                    </form>
                @endif
                <div class="login-link"><a href="/forgot-password">Start over</a></div>
            </div>
        </div>
    </div>
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
        gsap.from(".form-card", { opacity: 0, y: 30, duration: 0.8, ease: "power2.out" });
        gsap.from(".brand-side", { opacity: 0, x: -20, duration: 0.6, delay: 0.2 });
        gsap.from(".form-side", { opacity: 0, x: 20, duration: 0.6, delay: 0.3 });
    </script>
</body>
</html>