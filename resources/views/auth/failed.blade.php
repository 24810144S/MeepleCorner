<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Failed | Meeple Corner Café</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- GSAP -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
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

        /* main container */
        .main-container {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            position: relative;
            z-index: 2;
        }

        /* error card */
        .error-card {
            max-width: 500px;
            width: 100%;
            background: rgba(255,255,255,0.03);
            backdrop-filter: blur(12px);
            border-radius: 32px;
            overflow: hidden;
            border: 1px solid rgba(212,165,116,0.2);
            text-align: center;
            padding: 2rem;
            box-shadow: 0 25px 45px -12px rgba(0,0,0,0.5);
        }
        .error-icon {
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
        .error-icon i {
            font-size: 2.5rem;
            color: #ef4444;
        }
        .error-title {
            font-family: var(--font-heading);
            font-size: 2rem;
            color: var(--color-white);
            margin-bottom: 0.5rem;
        }
        .error-message {
            color: var(--color-text-muted);
            font-size: 1rem;
            margin-bottom: 2rem;
            line-height: 1.6;
        }
        .error-suggestions {
            background: rgba(0,0,0,0.2);
            border-radius: 24px;
            padding: 1rem;
            margin-bottom: 2rem;
            text-align: left;
        }
        .error-suggestions p {
            font-size: 0.8rem;
            color: var(--color-accent-light);
            margin-bottom: 0.5rem;
        }
        .error-suggestions ul {
            list-style: none;
            padding-left: 0;
        }
        .error-suggestions li {
            font-size: 0.75rem;
            color: var(--color-text-muted);
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .error-suggestions li i {
            color: var(--color-accent);
            font-size: 0.7rem;
        }
        .btn-group {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }
        .btn-primary {
            background: var(--color-accent);
            color: var(--color-primary);
            border: none;
            border-radius: 40px;
            padding: 0.8rem 1.5rem;
            font-size: 0.7rem;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.2em;
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        .btn-primary:hover {
            background: var(--color-accent-light);
            transform: translateY(-2px);
        }
        .btn-secondary {
            background: transparent;
            border: 1px solid rgba(212,165,116,0.5);
            color: var(--color-accent);
            border-radius: 40px;
            padding: 0.8rem 1.5rem;
            font-size: 0.7rem;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.2em;
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        .btn-secondary:hover {
            background: rgba(212,165,116,0.1);
        }

        @media (max-width: 768px) {
            .main-container {
                padding: 1rem;
            }
            .error-card {
                padding: 1.5rem;
            }
            .btn-group {
                flex-direction: column;
            }
            .btn-primary, .btn-secondary {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>
<body>

    <!-- tsParticles + floating emoji -->
    <div id="tsparticles"></div>
    <div class="floating-bg">🎲 🃏 🧩 🎯 🎲</div>

    @include('layouts.navbar')

    <div class="main-container">
        <div class="error-card">
            <div class="error-icon">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <h1 class="error-title">Login Failed</h1>
            <p class="error-message">
                The email address or password you entered is incorrect.<br>
                Please try again or reset your password.
            </p>
            <div class="error-suggestions">
                <p><i class="fas fa-lightbulb mr-2 text-gold"></i> Quick tips:</p>
                <ul>
                    <li><i class="fas fa-check-circle"></i> Check your email spelling</li>
                    <li><i class="fas fa-key"></i> Caps Lock might be on</li>
                    <li><i class="fas fa-envelope"></i> Try using the email you registered with</li>
                </ul>
            </div>
            <div class="btn-group">
                <a href="/login" class="btn-primary">
                    <i class="fas fa-sign-in-alt"></i> Try Again
                </a>
                <a href="/forgot-password" class="btn-secondary">
                    <i class="fas fa-key"></i> Forgot Password?
                </a>
                <a href="/" class="btn-secondary">
                    <i class="fas fa-home"></i> Back to Home
                </a>
            </div>
        </div>
    </div>

    <footer class="footer">
        © 2026 Meeple Corner Café — Roll responsibly. Sip slowly. Play often.
    </footer>

    <script>
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

        // GSAP animation
        gsap.from(".error-card", { opacity: 0, y: 30, duration: 0.8, ease: "power2.out" });
        gsap.from(".error-icon", { scale: 0, duration: 0.5, delay: 0.2, ease: "back.out(0.5)" });
    </script>
</body>
</html>