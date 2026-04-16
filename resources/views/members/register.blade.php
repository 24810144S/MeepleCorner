<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | Meeple Corner Café</title>
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
            max-width: 1000px;
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
        .checkbox-group {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            margin-top: 0.5rem;
        }
        .checkbox-label {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
            font-size: 0.8rem;
            color: var(--color-text-muted);
        }
        .checkbox-label input {
            accent-color: var(--color-accent);
            width: 1rem;
            height: 1rem;
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
            margin-top: 1rem;
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
        .login-link a:hover {
            text-decoration: underline;
        }
        .error-text {
            color: #f87171;
            font-size: 0.7rem;
            margin-top: 0.25rem;
            display: none;
        }
        .border-red-500 {
            border-color: #f87171 !important;
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
                    <h1>Meeple Corner<br>Café</h1>
                    <div class="brand-divider"></div>
                    <p class="text-sm font-light leading-loose opacity-80 uppercase tracking-widest">Coffee • Strategy • Community</p>
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
                <h2>Create Account</h2>
                <p class="form-subtitle">Enter your details to join our tabletop family</p>

                @if ($errors->any())
                    <div class="bg-red-500/20 border-l-4 border-red-500 p-3 rounded mb-4">
                        @foreach ($errors->all() as $error)
                            <p class="text-sm text-red-300">{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="/register" id="registerForm">
                    @csrf
                    <div class="form-group">
                        <label class="form-label">Nickname</label>
                        <input type="text" name="address" value="{{ old('address') }}" class="form-input" required>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="form-group">
                            <label class="form-label">First Name</label>
                            <input type="text" name="first_name" value="{{ old('first_name') }}" class="form-input" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Last Name</label>
                            <input type="text" name="last_name" value="{{ old('last_name') }}" class="form-input" required>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="form-group">
                            <label class="form-label">Phone</label>
                            <input type="tel" name="phone" value="{{ old('phone') }}" class="form-input" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Email Address</label>
                            <input type="email" name="email" value="{{ old('email') }}" class="form-input" required>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="form-group">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" id="password" class="form-input" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Confirm Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-input" required>
                            <div id="password-error" class="error-text">Passwords do not match.</div>
                        </div>
                    </div>

                    <!-- Security Questions -->
                    <div class="border-t border-gold/20 pt-4 mt-2">
                        <h3 class="serif text-xl text-white mb-3">Identity Recovery</h3>

                        <div class="form-group">
                            <label class="form-label">Question 1: Select a question</label>
                            <select name="security_q1_id" class="form-select">
                                <option value="What was the name of your first pet?">What was the name of your first pet?</option>
                                <option value="In what city were you born?">In what city were you born?</option>
                                <option value="What was your childhood nickname?">What was your childhood nickname?</option>
                            </select>
                            <input type="text" name="security_a1" placeholder="Your Answer" class="form-input mt-2" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Question 2: What is your favorite board game genre?</label>
                            <select name="favorite_genre" class="form-select" required>
                                <option value="" disabled selected>– Select a genre –</option>
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
                        </div>

                        <div class="form-group">
                            <label class="form-label">Question 3: What is your favorite season of the year?</label>
                            <div class="checkbox-group">
                                <label class="checkbox-label"><input type="radio" name="security_a3" value="winter"> Winter</label>
                                <label class="checkbox-label"><input type="radio" name="security_a3" value="spring"> Spring</label>
                                <label class="checkbox-label"><input type="radio" name="security_a3" value="summer"> Summer</label>
                                <label class="checkbox-label"><input type="radio" name="security_a3" value="fall"> Fall</label>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn-submit">Confirm Registration</button>
                </form>

                <div class="login-link">
                    Already have an account? <a href="/login">Login</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
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

            // Password validation
            const password = document.getElementById('password');
            const confirm = document.getElementById('password_confirmation');
            const errorSpan = document.getElementById('password-error');

            if (errorSpan) {
                errorSpan.style.display = 'none';
            }

            function validatePasswords() {
                if (!password || !confirm) return;
                if (password.value !== confirm.value) {
                    if (errorSpan) errorSpan.style.display = 'block';
                    confirm.style.borderColor = '#f87171';
                } else {
                    if (errorSpan) errorSpan.style.display = 'none';
                    confirm.style.borderColor = '';
                }
            }

            password.addEventListener('input', validatePasswords);
            confirm.addEventListener('input', validatePasswords);

            const form = document.getElementById('registerForm');
            if (form) {
                form.addEventListener('submit', function(e) {
                    if (password.value !== confirm.value) {
                        e.preventDefault();
                        if (errorSpan) errorSpan.style.display = 'block';
                        confirm.style.borderColor = '#f87171';
                        alert('Passwords do not match. Please correct them.');
                    }
                });
            }
        });
    </script>
</body>
</html>