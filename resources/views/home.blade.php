<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meeple Corner Café | 桌遊・咖啡・歡聚</title>
    <!-- Google Fonts & Tailwind & Font Awesome -->
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,600;0,700;1,400&family=Jost:wght@300;400;500;600&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- 活潑特效 JS 函式庫 -->
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1"></script>
    <script src="https://cdn.jsdelivr.net/npm/tsparticles@2.12.0/tsparticles.bundle.min.js"></script>

    <style>
        /* 原有奢華基底 + 活潑桌遊風格 (完整保留之前的效果) */
        body { background-color: #FDFCF6; font-family: 'Jost', sans-serif; color: #1A1A1A; overflow-x: hidden; }
        .serif { font-family: 'Cormorant Garamond', serif; }
        .accent-gold { background-color: #C5A059; }
        .text-gold { color: #C5A059; }
        .border-gold { border-color: #C5A059; }
        
        .btn-luxury {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            letter-spacing: 0.2em;
            text-transform: uppercase;
            font-size: 11px;
            font-weight: 600;
            position: relative;
            z-index: 2;
        }
        .btn-luxury:hover {
            background-color: #1A1A1A;
            color: white;
            transform: translateY(-4px);
            box-shadow: 0 15px 25px -8px rgba(0,0,0,0.2);
        }

        /* 粒子背景層 */
        #tsparticles {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            pointer-events: none;
        }

        /* 主要內容相對粒子獨立 */
        .relative-content { position: relative; z-index: 2; }

        /* 卡片動畫 */
        .game-card {
            transition: all 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.1);
            cursor: pointer;
        }
        .game-card:hover {
            transform: translateY(-10px) rotate(0.5deg);
            box-shadow: 0 20px 30px -12px rgba(0,0,0,0.2);
        }

        /* 骰子動畫 */
        .dice-btn:active { transform: scale(0.95); }
        @keyframes rollDice {
            0% { transform: rotate(0deg) scale(1); }
            50% { transform: rotate(180deg) scale(1.2); }
            100% { transform: rotate(360deg) scale(1); }
        }
        .rolling { animation: rollDice 0.5s cubic-bezier(0.34, 1.2, 0.64, 1); }

        /* 推薦卡片滑入 */
        @keyframes slideFade {
            from { opacity: 0; transform: translateY(15px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .suggest-card { animation: slideFade 0.5s ease-out; }

        /* 導覽列小圖標 */
        .nav-link { position: relative; }
        .nav-link:hover::after {
            content: "🎲";
            position: absolute;
            bottom: -20px;
            left: 50%;
            transform: translateX(-50%);
            font-size: 12px;
            opacity: 0.8;
        }

        /* 漂浮背景 emoji */
        .floating-bg-emoji {
            position: fixed;
            bottom: 15px;
            right: 20px;
            font-size: 45px;
            opacity: 0.1;
            pointer-events: none;
            z-index: 0;
            animation: floatAround 18s infinite linear;
        }
        @keyframes floatAround {
            0% { transform: translateY(0px) rotate(0deg); opacity: 0.05; }
            50% { transform: translateY(-25px) rotate(8deg); opacity: 0.12; }
            100% { transform: translateY(0px) rotate(0deg); opacity: 0.05; }
        }
    </style>
</head>
<body class="min-h-screen flex flex-col">

    <!-- 粒子背景 & 漂浮裝飾 -->
    <div id="tsparticles"></div>
    <div class="floating-bg-emoji">🎲 🃏 🧩 🎯 🎴</div>

    <!-- 導覽列 -->
    <nav class="relative z-20 flex justify-between items-center px-6 md:px-10 py-6 bg-white/70 backdrop-blur-sm shadow-sm">
        <div class="serif text-2xl font-bold tracking-tighter">M<span class="text-gold">.</span>C</div>
        <div class="space-x-6 text-[11px] uppercase tracking-[0.2em] font-medium text-gray-500">
            <a href="#" class="nav-link hover:text-gold transition">The Café</a>
            <a href="#" class="nav-link hover:text-gold transition">Board Games</a>
            <a href="#" class="nav-link hover:text-gold transition">Events</a>
            <a href="/login" class="text-gold font-bold">Login</a>
        </div>
    </nav>

    <!-- 主要內容區 -->
    <main class="relative z-10 flex-1 flex flex-col md:flex-row items-center px-6 md:px-16 lg:px-24 py-10 gap-8">
        
        <!-- 左側文案區 -->
        <div class="md:w-1/2 space-y-6">
            <div class="space-y-3">
                <span class="text-gold text-xs uppercase tracking-[0.3em] font-bold">🎲 Est. 2026 🎲</span>
                <h1 class="serif text-5xl md:text-7xl lg:text-8xl leading-[0.95] text-gray-900">
                    Strategy <br> 
                    <span class="italic font-light">&</span> Serenity.
                </h1>
            </div>
            <p class="max-w-md text-gray-500 leading-relaxed text-sm">
                Roll the dice, sip our signature brew, and gather around the table. 
                A boutique board game café where every visit is a new adventure.
            </p>
            <div class="flex flex-wrap gap-4 pt-4 items-center">
                <a href="/register" id="registerBtn" class="btn-luxury accent-gold text-white px-8 py-4 shadow-xl text-center">🎲 Join the Elite</a>
                <a href="/login" id="bookBtn" class="btn-luxury border border-gray-300 px-8 py-4 text-center hover:border-gold">📅 Book a Table</a>
                <button id="randomGameBtn" class="bg-amber-100 hover:bg-amber-200 text-amber-800 px-5 py-4 rounded-full shadow-md transition flex items-center gap-2 text-sm font-semibold">
                    <span class="dice-icon text-xl">🎲</span> 骰出遊戲
                </button>
            </div>
            <!-- 隨機推薦顯示區 -->
            <div id="gameSuggestion" class="mt-6 hidden bg-white/80 backdrop-blur-sm rounded-2xl p-5 shadow-lg border-l-8 border-gold">
                <div class="flex items-center gap-3">
                    <span class="text-3xl">🎲</span>
                    <div>
                        <p class="text-[10px] uppercase tracking-widest text-gold font-bold">今天玩這款！</p>
                        <p id="suggestedGameName" class="serif text-xl font-bold text-gray-800"></p>
                        <p id="suggestedGameDesc" class="text-xs text-gray-500 mt-1"></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- 右側視覺區 (圖片與浮動卡) -->
        <div class="md:w-1/2 relative p-6 md:p-10">
            <div class="relative z-10 w-full aspect-[4/5] bg-gray-100 overflow-hidden border-[15px] border-white shadow-2xl rounded-2xl game-card">
                <img src="https://images.unsplash.com/photo-1511512578047-dfb367046420?auto=format&fit=crop&q=80&w=1000" 
                     alt="歡樂桌遊時刻" 
                     class="w-full h-full object-cover grayscale-[15%] hover:scale-105 transition duration-700">
            </div>
            <!-- 本月主打浮動標籤（靜態範例，您可改成資料庫最新推薦） -->
            <div class="absolute -bottom-4 -left-4 md:left-0 z-20 bg-white p-6 shadow-xl max-w-xs border-t-4 border-gold rounded-2xl">
                <span class="text-[10px] uppercase tracking-widest text-gold font-bold flex items-center gap-1">⭐ 本月主打</span>
                <h3 class="serif text-xl mt-2 text-gray-800 italic">Catan: Starfarers</h3>
                <p class="text-[11px] text-gray-400 mt-2 leading-relaxed">探索星系，同時品嚐我們的冷萃咖啡。立即預約桌位！</p>
                <button class="mt-3 text-gold text-xs font-bold hover:underline flex items-center gap-1" id="catanCelebrate">🎉 我也要玩 <i class="fas fa-arrow-right"></i></button>
            </div>
            <div class="absolute -top-8 -right-8 w-32 h-32 border border-gold rounded-full opacity-20"></div>
        </div>
    </main>

    <!-- 人氣遊戲區：從資料庫讀取 $popularBoardGames -->
    <section class="relative z-10 max-w-6xl mx-auto px-6 py-12 mt-8">
        <div class="text-center mb-8">
            <span class="text-gold text-[10px] tracking-[0.3em] uppercase">📌 人氣熱點</span>
            <h2 class="serif text-3xl italic">桌上狂歡 · 隨時開戰</h2>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-5">
            @forelse($popularBoardGames as $game)
                <div class="bg-white p-4 rounded-2xl shadow-md text-center game-card" data-game-id="{{ $game->id }}">
                    <!-- 遊戲圖示：若有上傳圖片則顯示縮圖，否則顯示預設圖標 -->
                    @if($game->image)
                        <img src="{{ Storage::url($game->image) }}" class="w-12 h-12 object-cover mx-auto rounded-full mb-2" alt="{{ $game->name }}">
                    @else
                        <i class="fas fa-dice-d6 text-3xl text-gold mb-2"></i>
                    @endif
                    <p class="font-bold text-sm">{{ $game->name }}</p>
                    <p class="text-[10px] text-gray-400">{{ $game->min_players }}-{{ $game->max_players }}人</p>
                    @if($game->play_time_minutes)
                        <p class="text-[9px] text-gray-300 mt-1">{{ $game->play_time_minutes }} 分鐘</p>
                    @endif
                </div>
            @empty
                <p class="col-span-full text-center text-gray-400">暫無可用的桌遊，快來新增吧！</p>
            @endforelse
        </div>
    </section>

    <footer class="relative z-10 p-8 flex flex-col md:flex-row justify-between items-center border-t border-gray-100 mt-12 bg-white/50">
        <div class="text-[10px] uppercase tracking-widest text-gray-400 mb-4 md:mb-0">
            © 2026 Meeple Corner Café — 骰子已擲，歡樂不散
        </div>
        <div class="flex space-x-6 text-gray-400">
            <a href="#" class="hover:text-gold transition text-lg"><i class="fab fa-instagram"></i></a>
            <a href="#" class="hover:text-gold transition"><i class="fab fa-facebook-f"></i></a>
            <a href="#" class="hover:text-gold transition"><i class="fab fa-pinterest-p"></i></a>
        </div>
    </footer>

    <script>
        // 從 Blade 注入所有可用的桌遊資料 (用於隨機推薦)
        const allBoardGames = @json($boardGames);
        console.log(allBoardGames);

        // 初始化 tsParticles (活潑粒子)
        tsParticles.load("tsparticles", {
            fpsLimit: 60,
            particles: {
                number: { value: 45, density: { enable: true, value_area: 800 } },
                color: { value: ["#C5A059", "#E76F51", "#2A9D8F", "#9B5DE5"] },
                shape: { type: ["circle", "square", "triangle"] },
                opacity: { value: 0.4, random: true },
                size: { value: 6, random: true },
                move: { enable: true, speed: 1.2, direction: "none", random: true, straight: false, outModes: "out" }
            },
            interactivity: {
                events: { onHover: { enable: true, mode: "repulse" }, onClick: { enable: true, mode: "push" } }
            }
        });

        // 隨機推薦遊戲功能 (使用資料庫 BoardGame)
        const randomBtn = document.getElementById('randomGameBtn');
        const suggestDiv = document.getElementById('gameSuggestion');
        const gameNameSpan = document.getElementById('suggestedGameName');
        const gameDescSpan = document.getElementById('suggestedGameDesc');

        function rollDiceAndSuggest() {
            // 骰子圖示轉動動畫
            const diceIcon = randomBtn.querySelector('.dice-icon');
            diceIcon.classList.add('rolling');
            setTimeout(() => diceIcon.classList.remove('rolling'), 500);

            if (!allBoardGames || allBoardGames.length === 0) {
                gameNameSpan.textContent = "暫無遊戲";
                gameDescSpan.textContent = "快去後台新增桌遊吧！";
                suggestDiv.classList.remove('hidden');
                return;
            }

            const randomIndex = Math.floor(Math.random() * allBoardGames.length);
            const game = allBoardGames[randomIndex];
            gameNameSpan.textContent = game.name;
            // 使用 description 欄位，若為空則顯示預設訊息
            gameDescSpan.textContent = game.description || "快來店裡體驗這款遊戲！";
            suggestDiv.classList.remove('hidden');
            suggestDiv.classList.add('suggest-card');

            // 噴射五彩紙屑
            canvasConfetti({ particleCount: 80, spread: 70, origin: { y: 0.6 }, colors: ['#C5A059', '#E76F51', '#2A9D8F'] });
        }

        randomBtn.addEventListener('click', rollDiceAndSuggest);

        // 註冊 & 訂位按鈕紙花 + 跳轉
        const registerBtn = document.getElementById('registerBtn');
        const bookBtn = document.getElementById('bookBtn');
        const catanCelebrateBtn = document.getElementById('catanCelebrate');

        function celebrateAndRedirect(url) {
            canvasConfetti({ particleCount: 120, spread: 100, origin: { y: 0.5 }, startVelocity: 15 });
            setTimeout(() => { window.location.href = url; }, 300);
        }

        registerBtn.addEventListener('click', (e) => {
            e.preventDefault();
            celebrateAndRedirect('/register');
        });

        bookBtn.addEventListener('click', (e) => {
            e.preventDefault();
            celebrateAndRedirect('/login');
        });

        catanCelebrateBtn.addEventListener('click', () => {
            canvasConfetti({ particleCount: 200, spread: 80, origin: { y: 0.7 } });
            alert("🎉 快來店裡預約《Catan: Starfarers》，享專屬優惠！");
        });

        // 為每個遊戲卡片加上點擊驚喜 (可選，並可跳轉至遊戲詳情)
        document.querySelectorAll('.game-card').forEach(card => {
            card.addEventListener('click', (e) => {
                canvasConfetti({ particleCount: 30, spread: 50, origin: { y: 0.8 } });
                const gameId = card.getAttribute('data-game-id');
                if (gameId) {
                    // 若您有遊戲詳情頁，可取消註解下一行
                    // window.location.href = `/board-games/${gameId}`;
                }
            });
        });
    </script>
</body>
</html>