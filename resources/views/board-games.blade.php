<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meeple Corner | Game Library</title>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600;700&family=Jost:wght@300;400;500;600&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- 活潑特效 JS 函式庫 -->
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1"></script>
    <script src="https://cdn.jsdelivr.net/npm/tsparticles@2.12.0/tsparticles.bundle.min.js"></script>
    <style>
        /* 原有樣式 */
        body { background-color: #FDFCF6; font-family: 'Jost', sans-serif; color: #1A1A1A; overflow-x: hidden; }
        .serif { font-family: 'Cormorant Garamond', serif; }
        .sidebar { width: 260px; background-color: #1a1a1a; color: white; position: relative; z-index: 20; }
        .sidebar-item { transition: all 0.3s ease; text-transform: uppercase; font-size: 11px; color: #9ca3af; }
        .sidebar-item:hover, .sidebar-item.active { color: #C5A059; }
        .sidebar-item.active { border-right: 3px solid #C5A059; background: linear-gradient(to right, #1a1a1a, #262626); }
        .accent-gold { background-color: #C5A059; }
        .text-gold { color: #C5A059; }

        /* ========== 活潑桌遊主題新增樣式 ========== */
        /* 粒子背景層 (置於最下層) */
        #tsparticles {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            pointer-events: none;
        }

        /* 主內容區相對於粒子獨立 */
        main, .sidebar, header, footer {
            position: relative;
            z-index: 2;
            background-color: transparent;
        }

        /* 卡片活潑動畫 + 3D 懸浮 */
        .game-card {
            transition: all 0.35s cubic-bezier(0.2, 0.9, 0.4, 1.1);
            transform: translateY(0);
        }
        .game-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 20px 25px -12px rgba(0,0,0,0.2);
        }
        .game-card:hover img {
            filter: grayscale(0%) !important;
            transform: scale(1.05);
        }
        .game-card .game-img {
            transition: all 0.5s ease;
        }

        /* 趣味按鈕 */
        .play-btn {
            transition: all 0.2s ease;
        }
        .play-btn:hover {
            transform: scale(1.1) rotate(5deg);
        }

        /* 隨機推薦按鈕動畫 */
        @keyframes pulse-gold {
            0% { box-shadow: 0 0 0 0 rgba(197, 160, 89, 0.4); }
            70% { box-shadow: 0 0 0 10px rgba(197, 160, 89, 0); }
            100% { box-shadow: 0 0 0 0 rgba(197, 160, 89, 0); }
        }
        .random-btn {
            animation: pulse-gold 1.5s infinite;
        }

        /* 漂浮背景 emoji */
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
        margin-left: 260px;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        }
        
        /* Sidebar base styles */
        .sidebar { width: 260px; background-color: #1a1a1a; color: white; position: relative; z-index: 20; height: 100vh; overflow-y: auto; }
        .sidebar-item { transition: all 0.3s ease; text-transform: uppercase; font-size: 11px; color: #9ca3af; cursor: pointer; width: 100%; }
        .sidebar-item:hover, .sidebar-item.active { color: #C5A059; }
        .sidebar-item.active { border-right: 3px solid #C5A059; background: linear-gradient(to right, #1a1a1a, #262626); }

        /* Dropdown styles */
        .dropdown-menu { max-height: 0; overflow: hidden; transition: max-height 0.3s ease; }
        .dropdown-menu.show { max-height: 400px; }
        .rotate-icon { transition: transform 0.3s ease; }
        .rotate-icon.rotated { transform: rotate(90deg); }
        .sub-sidebar-item {
            transition: all 0.3s ease;
            font-size: 10px;
            color: #7a7a7a;
            border-left: 3px solid transparent;
            padding: 10px 16px 10px 32px;
            border-radius: 4px;
            width: 100%;
        }
        .sub-sidebar-item:hover { color: #C5A059; border-left-color: #C5A059; background: linear-gradient(to right, #1a1a1a, #222222); }
        .sub-sidebar-item.active { color: #C5A059; border-left-color: #C5A059; background: linear-gradient(to right, #1a1a1a, #262626); }
        /* 自訂骰子游標 (趣味選項，可註解) */
        /* body { cursor: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="24" height="27" viewBox="0 0 24 27"><polygon points="12,2 22,7 22,17 12,22 2,17 2,7" fill="%23C5A059" stroke="%231A1A1A" stroke-width="1"/><circle cx="12" cy="12" r="1.5" fill="white"/></svg>'), auto; } */
    </style>
</head>
<body>
    @include('layouts.sidebar')
    <div class="main-wrapper">

        <!-- 粒子背景 (桌遊主題) -->
        <div id="tsparticles"></div>
        <div class="floating-bg">🎲 🃏 🧩 🎯 🎲</div>

        <aside class="sidebar flex flex-col shrink-0" style="background-color: #1a1a1a;">
            <div class="p-8">
                <div class="serif text-2xl font-bold tracking-tighter text-white">M<span class="text-gold">.</span>C</div>
                <p class="text-[10px] uppercase tracking-[0.3em] text-gray-500 mt-2">Boutique Admin</p>
            </div>
            <nav class="flex-1 px-4 space-y-2">
                <!-- Home -->
                <a href="/" class="sidebar-item flex items-center px-4 py-4 rounded-sm" style="justify-content: flex-start;">
                    <i class="fas fa-home w-5 text-xs mr-3"></i><span>Home</span>
                </a>
                
                <!-- Reservations -->
                <a href="/reservation" class="sidebar-item flex items-center px-4 py-4 rounded-sm" style="justify-content: flex-start;">
                    <i class="fas fa-calendar-alt w-5 text-xs mr-3"></i><span>Reservations</span>
                </a>
                
                <!-- My Account Dropdown -->
                <div class="dropdown-container">
                    <div class="sidebar-item dropdown-toggle flex items-center justify-between px-4 py-4 rounded-sm cursor-pointer">
                        <div class="flex items-center">
                            <i class="fas fa-user w-5 text-xs mr-3"></i><span>My Account</span>
                        </div>
                        <i class="fas fa-chevron-right rotate-icon text-[8px] transition-transform"></i>
                    </div>
                    <div class="dropdown-menu ml-6">
                        <a href="/profile/info" class="sub-sidebar-item flex items-center px-4 py-3 rounded-sm">
                            <i class="fas fa-id-card w-4 text-[10px] mr-3"></i> My Info
                        </a>
                        <a href="/profile/edit" class="sub-sidebar-item flex items-center px-4 py-3 rounded-sm">
                            <i class="fas fa-edit w-4 text-[10px] mr-3"></i> Edit My Account
                        </a>
                        <a href="/profile/history" class="sub-sidebar-item flex items-center px-4 py-3 rounded-sm">
                            <i class="fas fa-history w-4 text-[10px] mr-3"></i> Reservation History
                        </a>
                    </div>
                </div>
                
                <!-- Game Library (ACTIVE) -->
                <a href="{{ route('board-games') }}" class="sidebar-item active flex items-center px-4 py-4 rounded-sm" style="justify-content: flex-start;">
                    <i class="fas fa-chess-knight w-5 text-xs mr-3"></i><span>Game Library</span>
                </a>
                
                <!-- Menu -->
                <a href="{{ route('menu') }}" class="sidebar-item flex items-center px-4 py-4 rounded-sm" style="justify-content: flex-start;">
                    <i class="fas fa-coffee w-5 text-xs mr-3"></i><span>Menu</span>
                </a>
            </nav>
            <div class="p-8 border-t border-white/5">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-[10px] uppercase tracking-widest text-red-400 font-bold hover:text-red-300 flex items-center gap-2 w-full">
                        <i class="fas fa-sign-out-alt"></i> Sign Out
                    </button>
                </form>
            </div>
        </aside>

        <main class="flex-1 flex flex-col">
            <header class="h-20 bg-white/80 backdrop-blur-sm border-b border-gray-100 flex items-center justify-between px-10 shrink-0 sticky top-0 z-30">
                <div><h2 class="serif text-2xl text-gray-800 italic">🎲 Game Library</h2></div>
                <div class="flex items-center space-x-6">
                    <span class="text-[11px] uppercase tracking-widest text-gray-400">
                        @if(session()->has('member_name')) Greetings, {{ session('member_name') }} @else Greetings, Guest @endif
                    </span>
                    <div class="w-10 h-10 border border-gray-100 p-1 rounded-full overflow-hidden">
                        <div class="w-full h-full bg-gray-200 rounded-full"></div>
                    </div>
                </div>
            </header>

            <div class="p-10 max-w-7xl w-full mx-auto">
                <div class="bg-white/90 backdrop-blur-sm border border-gray-100 p-8 shadow-lg rounded-2xl">
                    <div class="mb-8 flex flex-wrap justify-between items-end border-b border-gray-100 pb-4">
                        <div>
                            <h3 class="serif text-3xl text-gray-800 italic">Board Game Collection</h3>
                            <p class="text-[11px] uppercase tracking-[0.2em] text-gray-400 mt-1">🎉 Borrow & play at your table — roll the dice!</p>
                        </div>
                        <div class="flex items-center gap-4 mt-2 sm:mt-0">
                            <span class="text-[10px] text-gold">{{ $boardGames->count() }} titles available</span>
                            <!-- 活潑按鈕：隨機推薦遊戲 -->
                            <button id="randomGameBtn" class="random-btn bg-gold/10 text-gold border border-gold/40 px-4 py-2 rounded-full text-xs font-bold hover:bg-gold hover:text-white transition flex items-center gap-2">
                                <i class="fas fa-dice-d6"></i> 骰出驚喜
                            </button>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="gamesGrid">
                        @forelse($boardGames as $index => $game)
                            <div class="game-card border border-gray-100 rounded-xl bg-white shadow-sm overflow-hidden" data-game-id="{{ $game->id }}" data-game-name="{{ $game->name }}">
                                <div class="aspect-[4/3] bg-gray-100 relative overflow-hidden">
                                    @if($game->image)
                                        <img src="{{ asset('storage/'.$game->image) }}" class="game-img w-full h-full object-cover grayscale-[20%] transition duration-500">
                                    @else
                                        <div class="w-full h-full flex flex-col items-center justify-center text-gray-300">
                                            <i class="fas fa-chess-board text-4xl mb-2"></i>
                                            <span class="text-[9px] uppercase">No cover</span>
                                        </div>
                                    @endif
                                    <div class="absolute bottom-0 right-0 bg-black/70 text-white text-[9px] px-3 py-1 uppercase tracking-wider">
                                        {{ $game->category }}
                                    </div>
                                </div>
                                <div class="p-4">
                                    <h4 class="serif text-lg font-bold text-gray-800">{{ $game->name }}</h4>
                                    <p class="text-xs text-gray-500 mt-1 leading-relaxed">{{ $game->description }}</p>
                                    <div class="flex flex-wrap gap-3 mt-3 text-[10px] text-gray-400 uppercase tracking-wider">
                                        <span><i class="fas fa-users"></i> {{ $game->min_players }}-{{ $game->max_players }}</span>
                                        @if($game->play_time_minutes)
                                            <span><i class="fas fa-hourglass-half"></i> {{ $game->play_time_minutes }} min</span>
                                        @endif
                                    </div>
                                    <div class="mt-3 pt-2 border-t border-gray-50 flex justify-between items-center">
                                        @if($game->is_available)
                                            <span class="text-[9px] text-green-600 font-bold uppercase tracking-wider">✓ Available now</span>
                                        @else
                                            <span class="text-[9px] text-red-500 uppercase tracking-wider">✗ Borrowed</span>
                                        @endif
                                        <!-- 活潑按鈕：我想玩 -->
                                        <button class="play-btn text-gold hover:text-amber-600 text-xs font-bold flex items-center gap-1">
                                            <i class="fas fa-dice-d6"></i> 我想玩！
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full text-center text-gray-400 py-8">No board games found. Add some in the database.</div>
                        @endforelse
                    </div>
                </div>
            </div>

            <footer class="mt-auto p-10 text-center text-[10px] uppercase tracking-[0.3em] text-gray-400 border-t border-gray-50 bg-white/50">
                © 2026 Meeple Corner Café — 骰子已擲，歡樂不散
            </footer>
        </main>
    </div>

    <script>
        // 1. 初始化 tsParticles (桌遊主題粒子)
        tsParticles.load("tsparticles", {
            fpsLimit: 60,
            particles: {
                number: { value: 40, density: { enable: true, value_area: 800 } },
                color: { value: ["#C5A059", "#E76F51", "#2A9D8F", "#9B5DE5", "#F4A261"] },
                shape: {
                    type: ["circle", "square", "triangle"],
                    options: {
                        image: [{
                            src: "https://cdn.jsdelivr.net/npm/emoji-datasource-apple/img/apple/64/1f3b2.png",
                            width: 20, height: 20
                        }]
                    }
                },
                opacity: { value: 0.3, random: true },
                size: { value: 5, random: true },
                move: { enable: true, speed: 1, direction: "none", random: true, straight: false, outModes: "out" }
            },
            interactivity: {
                events: { onHover: { enable: true, mode: "repulse" }, onClick: { enable: true, mode: "push" } }
            }
        });

        // 2. 隨機推薦遊戲功能
        const randomBtn = document.getElementById('randomGameBtn');
        const games = document.querySelectorAll('.game-card');
        
        function celebrate(particleCount = 100) {
            canvasConfetti({ particleCount: particleCount, spread: 70, origin: { y: 0.6 }, colors: ['#C5A059', '#E76F51', '#2A9D8F'] });
        }

        randomBtn.addEventListener('click', () => {
            if (games.length === 0) return;
            const randomIndex = Math.floor(Math.random() * games.length);
            const targetGame = games[randomIndex];
            const gameName = targetGame.getAttribute('data-game-name') || '這款遊戲';
            
            // 滾動到該遊戲
            targetGame.scrollIntoView({ behavior: 'smooth', block: 'center' });
            // 加上短暫光環效果
            targetGame.style.transition = 'all 0.2s';
            targetGame.style.boxShadow = '0 0 0 3px #C5A059, 0 10px 20px rgba(0,0,0,0.2)';
            setTimeout(() => { targetGame.style.boxShadow = ''; }, 1000);
            
            // 噴紙花 + 提示
            celebrate(120);
            setTimeout(() => {
                alert(`🎲 骰子為您選中：「${gameName}」！快來櫃檯預約桌位吧～`);
            }, 200);
        });

        // 3. 每張卡片的「我想玩！」按鈕觸發紙花＋趣味訊息
        document.querySelectorAll('.play-btn').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.stopPropagation();
                const card = btn.closest('.game-card');
                const gameName = card.getAttribute('data-game-name') || '這款遊戲';
                celebrate(80);
                alert(`🎉 太好了！您對「${gameName}」有興趣！請至櫃檯或線上預約，店員會為您準備。`);
            });
        });

        // 4. 卡片點擊額外驚喜 (可選)
        document.querySelectorAll('.game-card').forEach(card => {
            card.addEventListener('click', (e) => {
                if (e.target.closest('.play-btn')) return; // 避免重複
                celebrate(40);
            });
        });

        document.querySelectorAll('.dropdown-toggle').forEach(toggle => {
        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            const container = this.closest('.dropdown-container');
            const menu = container.querySelector('.dropdown-menu');
            const icon = this.querySelector('.rotate-icon');
            
            document.querySelectorAll('.dropdown-container').forEach(other => {
                if (other !== container) {
                    other.querySelector('.dropdown-menu')?.classList.remove('show');
                    other.querySelector('.rotate-icon')?.classList.remove('rotated');
                }
            });
            
            menu.classList.toggle('show');
            icon.classList.toggle('rotated');
        });
    });
    </script>
</body>
</html>