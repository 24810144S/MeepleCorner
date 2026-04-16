<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Meeple Corner Café</title>
    <!-- Google Fonts (same as homepage) -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- GSAP (optional for fade‑in) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
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
            font-family: var(--font-body);
            background-color: var(--color-primary);
            color: var(--color-text);
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* subtle noise texture (same as homepage) */
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

        /* ===== NAVBAR (same as homepage) ===== */
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

        /* ===== MAIN CONTAINER (centered card) ===== */
        .login-wrapper {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: calc(100vh - 80px);
            padding: 2rem;
        }

        /* ===== LOGIN CARD (glassmorphism) ===== */
        .login-card {
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
        /* Left side – quote / branding */
        .login-brand {
            flex: 1;
            background: linear-gradient(135deg, rgba(44,24,16,0.6) 0%, rgba(26,15,7,0.8) 100%);
            padding: 2.5rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .login-brand h2 {
            font-family: var(--font-heading);
            font-size: 2.2rem;
            color: var(--color-white);
            margin-bottom: 0.5rem;
        }
        .brand-divider {
            width: 50px;
            height: 2px;
            background: var(--color-accent);
            margin: 1rem 0 1.5rem;
        }
        .brand-quote {
            margin-top: auto;
            padding-top: 2rem;
        }
        .quote-text {
            font-family: var(--font-heading);
            font-style: italic;
            font-size: 1.1rem;
            color: var(--color-accent-light);
            opacity: 0.9;
        }
        .quote-author {
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 0.2em;
            color: var(--color-accent);
            margin-top: 1rem;
        }
        /* Right side – form */
        .login-form {
            flex: 1;
            padding: 2.5rem;
        }
        .login-form h3 {
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
            margin-bottom: 2rem;
        }
        .input-group {
            margin-bottom: 1.5rem;
        }
        .input-group label {
            display: block;
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 0.2em;
            color: var(--color-accent);
            margin-bottom: 0.5rem;
            font-weight: 600;
        }
        .input-group input {
            width: 100%;
            background: rgba(0,0,0,0.3);
            border: 1px solid rgba(212,165,116,0.3);
            border-radius: 40px;
            padding: 0.8rem 1.2rem;
            color: white;
            font-size: 0.9rem;
            transition: var(--transition);
        }
        .input-group input:focus {
            outline: none;
            border-color: var(--color-accent);
            background: rgba(0,0,0,0.5);
        }
        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            font-size: 0.7rem;
        }
        .checkbox-label {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
            color: var(--color-text-muted);
        }
        .checkbox-label input {
            accent-color: var(--color-accent);
            width: 1rem;
            height: 1rem;
        }
        .forgot-link {
            color: var(--color-accent);
            text-decoration: none;
            transition: var(--transition);
        }
        .forgot-link:hover {
            color: var(--color-accent-light);
            text-decoration: underline;
        }
        .btn-login {
            width: 100%;
            background: var(--color-accent);
            color: var(--color-primary);
            border: none;
            border-radius: 40px;
            padding: 0.8rem;
            font-size: 0.75rem;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.2em;
            cursor: pointer;
            transition: var(--transition);
            margin-bottom: 1.5rem;
        }
        .btn-login:hover {
            background: var(--color-accent-light);
            transform: translateY(-2px);
        }
        .register-link {
            text-align: center;
            border-top: 1px solid rgba(212,165,116,0.2);
            padding-top: 1.5rem;
            margin-top: 0.5rem;
        }
        .register-link p {
            font-size: 0.7rem;
            color: var(--color-text-muted);
        }
        .register-link a {
            color: var(--color-accent);
            text-decoration: none;
            font-weight: bold;
            transition: var(--transition);
        }
        .register-link a:hover {
            color: var(--color-accent-light);
        }
        .social-icons {
            display: flex;
            justify-content: center;
            gap: 1.5rem;
            margin-top: 1.5rem;
        }
        .social-icons a {
            color: var(--color-text-muted);
            transition: var(--transition);
            font-size: 1rem;
        }
        .social-icons a:hover {
            color: var(--color-accent);
            transform: translateY(-2px);
        }
        /* error alert */
        .alert-error {
            background: rgba(220, 38, 38, 0.2);
            border-left: 4px solid #ef4444;
            padding: 0.75rem 1rem;
            border-radius: 16px;
            margin-bottom: 1.5rem;
            font-size: 0.8rem;
            color: #fca5a5;
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
            .login-card {
                flex-direction: column;
            }
            .login-brand {
                text-align: center;
            }
            .brand-divider {
                margin-left: auto;
                margin-right: auto;
            }
            .login-wrapper {
                padding: 1rem;
            }
        }
    </style>
</head>
<body>

    <!-- NAVBAR (exactly like homepage) -->
    <nav class="navbar">
        <a href="/" class="logo">Meeple Corner Café</a>
        <div class="nav-links">
            <a href="/" class="nav-link">Home</a>
            <a href="/board-games" class="nav-link">Board Games</a>
            <a href="/events" class="nav-link">Events</a>
            <a href="/reservation" class="nav-link">Reservations</a>
            <a href="/menu" class="nav-link">Menu</a>
        </div>
        <div class="flex items-center gap-4">
            <span class="user-greeting" style="font-size:0.7rem; color:var(--color-text-muted);">Welcome, Guest</span>
        </div>
    </nav>

    <div class="login-wrapper">
        <div class="login-card">
            <!-- Left side (brand / inspiration) -->
            <div class="login-brand">
                <div>
                    <h2>Welcome Back</h2>
                    <div class="brand-divider"></div>
                    <p style="font-size:0.8rem; color:var(--color-text-muted);">Your next adventure awaits.</p>
                </div>
                <div class="brand-quote">
                    <div class="quote-text">“The board is set. Your table awaits.”</div>
                    <div class="quote-author">— Meeple Corner</div>
                </div>
            </div>

            <!-- Right side (login form) -->
            <div class="login-form">
                <h3>Sign In</h3>
                <p class="form-subtitle">Enter your credentials</p>

                @if ($errors->any())
                    <div class="alert-error">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="/login">
                    @csrf
                    <!-- Get redirect from query string, default to reservation page -->
                    @php 
                        $redirect = request()->query('redirect', url()->previous() !== url()->current() ? url()->previous() : '/reservation');
                    @endphp
                    <input type="hidden" name="redirect" value="{{ request()->query('redirect', session('url.intended', '/reservation')) }}">
                    
                    <div class="input-group">
                        <label>Email Address</label>
                        <input type="email" name="email" value="{{ old('email') }}" required>
                    </div>

                    <div class="input-group">
                        <label>Password</label>
                        <input type="password" name="password" required>
                    </div>

                    <div class="form-options">
                        <label class="checkbox-label">
                            <input type="checkbox" name="remember"> Remember Me
                        </label>
                        <a href="/forgot-password" class="forgot-link">Forgot Password?</a>
                    </div>

                    <button type="submit" class="btn-login">Authenticate</button>
                </form>

                <div class="register-link">
                    <p>New to Meeple Corner?</p>
                    <a href="/register">Create An Account →</a>
                </div>

                <div class="social-icons">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-google"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
        </div>
    </div>

    <script>
        // GSAP fade-in animation for the login card
        gsap.from(".login-card", { opacity: 0, y: 30, duration: 0.8, ease: "power2.out" });
        gsap.from(".login-brand", { opacity: 0, x: -20, duration: 0.6, delay: 0.2 });
        gsap.from(".login-form", { opacity: 0, x: 20, duration: 0.6, delay: 0.3 });
    </script>
</body>
</html>