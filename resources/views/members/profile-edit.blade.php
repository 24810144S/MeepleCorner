<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile | Meeple Corner Café</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- GSAP & ScrollTrigger -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>
    <!-- tsParticles -->
    <script src="https://cdn.jsdelivr.net/npm/tsparticles@2.12.0/tsparticles.bundle.min.js"></script>
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

        /* ===== MAIN CONTAINER ===== */
        .main-container {
            flex: 1;
            max-width: 800px;
            margin: 0 auto;
            padding: 2rem;
            width: 100%;
            position: relative;
            z-index: 2;
        }

        /* ===== FORM CARD ===== */
        .form-card {
            background: rgba(255,255,255,0.03);
            backdrop-filter: blur(8px);
            border-radius: 32px;
            overflow: hidden;
            border: 1px solid rgba(212,165,116,0.2);
        }
        .card-header {
            padding: 1.8rem 2rem;
            border-bottom: 1px solid rgba(212,165,116,0.15);
            background: rgba(0,0,0,0.2);
        }
        .card-header h2 {
            font-family: var(--font-heading);
            font-size: 1.8rem;
            color: var(--color-white);
            margin-bottom: 0.25rem;
        }
        .card-header p {
            font-size: 0.8rem;
            color: var(--color-text-muted);
        }
        .card-body {
            padding: 2rem;
        }

        /* ===== TABS ===== */
        .tab-container {
            display: flex;
            gap: 1rem;
            border-bottom: 1px solid rgba(212,165,116,0.3);
            margin-bottom: 2rem;
        }
        .tab-btn {
            background: none;
            border: none;
            padding: 0.75rem 1.5rem;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: var(--color-text-muted);
            cursor: pointer;
            transition: var(--transition);
            position: relative;
        }
        .tab-btn.active {
            color: var(--color-accent);
        }
        .tab-btn.active::after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 0;
            width: 100%;
            height: 2px;
            background: var(--color-accent);
        }
        .tab-btn:hover {
            color: var(--color-accent);
        }

        /* ===== FORM ELEMENTS ===== */
        .form-group {
            margin-bottom: 1.5rem;
        }
        .form-label {
            display: block;
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 0.2em;
            color: var(--color-accent);
            margin-bottom: 0.5rem;
            font-weight: 600;
        }
        .form-input {
            width: 100%;
            background: rgba(0,0,0,0.3);
            border: 1px solid rgba(212,165,116,0.3);
            border-radius: 40px;
            padding: 0.8rem 1.2rem;
            color: white;
            font-size: 0.9rem;
            transition: var(--transition);
        }
        .form-input:focus {
            outline: none;
            border-color: var(--color-accent);
            background: rgba(0,0,0,0.5);
        }
        .btn-submit {
            background: var(--color-accent);
            color: var(--color-primary);
            border: none;
            border-radius: 40px;
            padding: 0.8rem 2rem;
            font-size: 0.7rem;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            cursor: pointer;
            transition: var(--transition);
        }
        .btn-submit:hover {
            background: var(--color-accent-light);
            transform: translateY(-2px);
        }
        .btn-cancel {
            background: transparent;
            border: 1px solid rgba(212,165,116,0.5);
            color: var(--color-accent);
            padding: 0.8rem 2rem;
            border-radius: 40px;
            font-size: 0.7rem;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
            display: inline-block;
        }
        .btn-cancel:hover {
            background: rgba(212,165,116,0.1);
        }
        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
            margin-top: 2rem;
        }

        /* ===== ALERTS ===== */
        .alert-success {
            background: rgba(74, 222, 128, 0.15);
            border-left: 4px solid #4ade80;
            padding: 1rem;
            border-radius: 16px;
            margin-bottom: 1.5rem;
            color: #86efac;
            font-size: 0.85rem;
        }
        .alert-error {
            background: rgba(220, 38, 38, 0.2);
            border-left: 4px solid #ef4444;
            padding: 1rem;
            border-radius: 16px;
            margin-bottom: 1.5rem;
            color: #fca5a5;
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
            .main-container {
                padding: 1rem;
            }
            .card-header, .card-body {
                padding: 1.2rem;
            }
            .form-actions {
                flex-direction: column;
            }
            .btn-cancel, .btn-submit {
                width: 100%;
                text-align: center;
            }
            .tab-btn {
                padding: 0.5rem 1rem;
                font-size: 0.7rem;
            }
        }
    </style>
</head>
<body>

    <!-- tsParticles container + floating emoji -->
    <div id="tsparticles"></div>
    <div class="floating-bg">🎲 🃏 🧩 🎯 🎲</div>

    @include('layouts.navbar')

    <main class="main-container">
        @if(session('success'))
            <div class="alert-success">
                <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert-error">
                @foreach($errors->all() as $error)
                    <p><i class="fas fa-exclamation-circle mr-2"></i> {{ $error }}</p>
                @endforeach
            </div>
        @endif

        <div class="form-card">
            <div class="card-header">
                <h2>Edit My Account</h2>
                <p>Update your personal information or change your password</p>
            </div>
            <div class="card-body">
                <!-- Tabs -->
                <div class="tab-container">
                    <button id="tabEditBtn" class="tab-btn active">Edit Account</button>
                    <button id="tabPasswordBtn" class="tab-btn">Change Password</button>
                </div>

                <!-- Tab 1: Edit Account Form -->
                <div id="editAccountTab">
                    <form method="POST" action="{{ route('profile.edit') }}">
                        @csrf
                        <div class="form-group">
                            <label class="form-label">First Name</label>
                            <input type="text" name="first_name" value="{{ old('first_name', $member->first_name) }}" class="form-input" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Last Name</label>
                            <input type="text" name="last_name" value="{{ old('last_name', $member->last_name) }}" class="form-input" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Nickname</label>
                            <input type="text" name="address" value="{{ old('address', $member->address) }}" class="form-input" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Phone Number</label>
                            <input type="tel" name="phone" value="{{ old('phone', $member->phone) }}" class="form-input" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Email Address</label>
                            <input type="email" name="email" value="{{ old('email', $member->email) }}" class="form-input" required>
                        </div>
                        <div class="form-actions">
                            <a href="/profile/info" class="btn-cancel">Cancel</a>
                            <button type="submit" class="btn-submit">Save Changes</button>
                        </div>
                    </form>
                </div>

                <!-- Tab 2: Change Password Form -->
                <div id="changePasswordTab" style="display: none;">
                    <form method="POST" action="{{ route('profile.password') }}">
                        @csrf
                        <div class="form-group">
                            <label class="form-label">Current Password</label>
                            <input type="password" name="current_password" class="form-input" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">New Password</label>
                            <input type="password" name="password" class="form-input" required>
                            <p class="text-[10px] text-gray-400 mt-1">Minimum 6 characters</p>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Confirm New Password</label>
                            <input type="password" name="password_confirmation" class="form-input" required>
                        </div>
                        <div class="form-actions">
                            <a href="/profile/info" class="btn-cancel">Cancel</a>
                            <button type="submit" class="btn-submit">Update Password</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Security Tips Card -->
        <div class="form-card mt-6">
            <div class="card-header">
                <h2 class="text-lg">Security Tips</h2>
            </div>
            <div class="card-body">
                <div class="flex items-center gap-3">
                    <i class="fas fa-shield-alt text-2xl text-gold"></i>
                    <div>
                        <p class="text-sm text-white font-medium">Protect Your Account</p>
                        <p class="text-xs text-text-muted">Use a strong password with letters, numbers, and symbols. Never share your password with anyone.</p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="footer">
        © 2026 Meeple Corner Café — Established for the Strategic Mind
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
        gsap.from(".form-card", { opacity: 0, y: 30, duration: 0.8, ease: "power2.out" });
        
        gsap.from(".form-group", { opacity: 0, x: -10, duration: 0.5, stagger: 0.05, delay: 0.5 });

        // 3. Tab switching
        const tabEditBtn = document.getElementById('tabEditBtn');
        const tabPasswordBtn = document.getElementById('tabPasswordBtn');
        const editAccountTab = document.getElementById('editAccountTab');
        const changePasswordTab = document.getElementById('changePasswordTab');

        function setActiveTab(active) {
            tabEditBtn.classList.remove('active');
            tabPasswordBtn.classList.remove('active');
            if (active === 'edit') {
                tabEditBtn.classList.add('active');
                editAccountTab.style.display = 'block';
                changePasswordTab.style.display = 'none';
            } else {
                tabPasswordBtn.classList.add('active');
                editAccountTab.style.display = 'none';
                changePasswordTab.style.display = 'block';
            }
        }

        tabEditBtn.addEventListener('click', () => setActiveTab('edit'));
        tabPasswordBtn.addEventListener('click', () => setActiveTab('password'));
    </script>
</body>
</html>