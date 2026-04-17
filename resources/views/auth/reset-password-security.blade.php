<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Set New Password | Meeple Corner Café</title>
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

        /* main wrapper */
        .main-wrapper {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            position: relative;
            z-index: 2;
        }

        /* form card */
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

        /* left side brand */
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
        .brand-features {
            margin-top: auto;
        }
        .feature-item {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }
        .feature-item i {
            color: var(--color-accent);
            font-size: 1.2rem;
            margin-top: 0.2rem;
        }
        .feature-item p {
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: var(--color-text-muted);
        }

        /* right side form */
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
        .form-subtitle {
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 0.2em;
            color: var(--color-text-muted);
            margin-bottom: 1.5rem;
        }

        /* form elements */
        .form-group {
            margin-bottom: 1.2rem;
        }
        .form-label {
            display: block;
            font-size: 0.65rem;
            text-transform: uppercase;
            letter-spacing: 0.2em;
            color: var(--color-accent);
            margin-bottom: 0.3rem;
            font-weight: 600;
        }
        .form-input {
            width: 100%;
            background: rgba(0,0,0,0.3);
            border: 1px solid rgba(212,165,116,0.3);
            border-radius: 40px;
            padding: 0.7rem 1rem;
            color: white;
            font-size: 0.85rem;
            transition: var(--transition);
        }
        .form-input:focus {
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
        .login-link {
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.7rem;
            color: var(--color-text-muted);
        }
        .login-link a {
            color: var(--color-accent);
            text-decoration: none;
            font-weight: bold;
        }
        .alert-error {
            background: rgba(220,38,38,0.2);
            border-left: 4px solid #ef4444;
            padding: 0.75rem 1rem;
            border-radius: 16px;
            margin-bottom: 1.5rem;
            color: #fca5a5;
        }

        @media (max-width: 768px) {
            .form-card {
                flex-direction: column;
            }
            .brand-side {
                text-align: center;
            }
            .brand-divider {
                margin-left: auto;
                margin-right: auto;
            }
            .feature-item {
                justify-content: center;
            }
            .main-wrapper {
                padding: 1rem;
            }
        }
    </style>
</head>
<body>

    <!-- tsParticles + floating emoji -->
    <div id="tsparticles"></div>
    <div class="floating-bg">🎲 🃏 🧩 🎯 🎲</div>

    @include('layouts.navbar')

    <div class="main-wrapper">
        <div class="form-card">
            <!-- Left brand side -->
            <div class="brand-side">
                <div>
                    <h1>Set New<br>Password</h1>
                    <div class="brand-divider"></div>
                    <p class="text-sm font-light leading-loose opacity-80 uppercase tracking-widest">Create a strong password</p>
                </div>
                <div class="brand-features">
                    <div class="feature-item">
                        <i class="fas fa-shield-halved"></i>
                        <p>Secured with three-tier protection</p>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-envelope-open-text"></i>
                        <p>Exclusive invitations to game nights</p>
                    </div>
                </div>
            </div>

            <!-- Right form side -->
            <div class="form-side">
                <h2>Reset Password</h2>
                <p class="form-subtitle">Enter your new password below</p>

                @if ($errors->any())
                    <div class="alert-error">
                        @foreach ($errors->all() as $error)
                            <p><i class="fas fa-exclamation-circle mr-2"></i> {{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('password.security-update') }}">
                    @csrf
                    <div class="form-group">
                        <label class="form-label">New Password</label>
                        <input type="password" name="password" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Confirm New Password</label>
                        <input type="password" name="password_confirmation" class="form-input" required>
                    </div>
                    <button type="submit" class="btn-submit">Update Password</button>
                </form>

                <div class="login-link">
                    <a href="/login">Back to Login</a>
                </div>
            </div>
        </div>
    </div>

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

        // GSAP animations
        gsap.from(".form-card", { opacity: 0, y: 30, duration: 0.8, ease: "power2.out" });
        gsap.from(".brand-side", { opacity: 0, x: -20, duration: 0.6, delay: 0.2 });
        gsap.from(".form-side", { opacity: 0, x: 20, duration: 0.6, delay: 0.3 });
    </script>
</body>
</html>