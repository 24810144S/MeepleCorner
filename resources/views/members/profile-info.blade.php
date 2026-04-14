<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Info | Meeple Corner Café</title>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600;700&family=Jost:wght@300;400;500;600&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { background-color: #FDFCF6; font-family: 'Jost', sans-serif; color: #1A1A1A; }
        .serif { font-family: 'Cormorant Garamond', serif; }
        .accent-gold { background-color: #C5A059; }
        .text-gold { color: #C5A059; }
        
        /* Sidebar styles */
        .sidebar { 
            width: 260px; 
            background-color: #1a1a1a; 
            color: white; 
            position: fixed; 
            top: 0;
            left: 0;
            bottom: 0;
            z-index: 20; 
            overflow-y: auto; 
        }
        
        .main-wrapper {
            margin-left: 260px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        
        .sidebar-item { 
            transition: all 0.3s ease; 
            text-transform: uppercase; 
            font-size: 11px; 
            color: #9ca3af; 
            cursor: pointer; 
            width: 100%; 
        }
        .sidebar-item:hover, .sidebar-item.active { color: #C5A059; }
        .sidebar-item.active { border-right: 3px solid #C5A059; background: linear-gradient(to right, #1a1a1a, #262626); }
        
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
            display: flex;
            align-items: center;
        }
        .sub-sidebar-item:hover { color: #C5A059; border-left-color: #C5A059; background: linear-gradient(to right, #1a1a1a, #222222); }
        .sub-sidebar-item.active { color: #C5A059; border-left-color: #C5A059; background: linear-gradient(to right, #1a1a1a, #262626); }
    </style>
</head>
<body>

    @include('layouts.sidebar')

    <div class="main-wrapper">
        <main class="flex-1 flex flex-col">
            <header class="h-20 bg-white border-b border-gray-100 flex items-center justify-between px-10">
                <div><h2 class="serif text-2xl text-gray-800 italic"><i class="fas fa-id-card mr-2 text-gold"></i> My Information</h2></div>
                <div class="flex items-center space-x-6">
                    <span class="text-[11px] uppercase tracking-widest text-gray-400">@if(session()->has('member_name')) Greetings, {{ session('member_name') }} @else Greetings, Guest @endif</span>
                    <a href="/profile/info" class="w-10 h-10 bg-gold rounded-full flex items-center justify-center text-white font-bold hover:opacity-80 transition-opacity">
                        {{ strtoupper(substr($member->first_name, 0, 1)) }}
                    </a>
                </div>
            </header>

            <div class="p-10 max-w-4xl w-full mx-auto">
                @if(session('success'))
                    <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 text-sm">{{ session('success') }}</div>
                @endif

                <div class="bg-white border border-gray-100 shadow-sm overflow-hidden">
                    <div class="p-8 border-b border-gray-100 bg-gray-50">
                        <h3 class="serif text-2xl text-gray-800">Profile Information</h3>
                        <p class="text-sm text-gray-500">Your personal information (read-only)</p>
                        <p class="text-xs text-gold mt-1">✏️ To edit, go to Edit My Account</p>
                    </div>

                    <div class="p-8 space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <label class="block text-[10px] font-bold uppercase tracking-wider text-gray-400">First Name</label>
                                <p class="text-lg font-medium text-gray-800 mt-1">{{ $member->first_name }}</p>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <label class="block text-[10px] font-bold uppercase tracking-wider text-gray-400">Last Name</label>
                                <p class="text-lg font-medium text-gray-800 mt-1">{{ $member->last_name }}</p>
                            </div>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-lg">
                            <label class="block text-[10px] font-bold uppercase tracking-wider text-gray-400">Address</label>
                            <p class="text-gray-800 mt-1">{{ $member->address }}</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <label class="block text-[10px] font-bold uppercase tracking-wider text-gray-400">Phone Number</label>
                                <p class="text-gray-800 mt-1">{{ $member->phone }}</p>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <label class="block text-[10px] font-bold uppercase tracking-wider text-gray-400">Email Address</label>
                                <p class="text-gray-800 mt-1">{{ $member->email }}</p>
                            </div>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-lg">
                            <label class="block text-[10px] font-bold uppercase tracking-wider text-gray-400">Member Since</label>
                            <p class="text-gray-800 mt-1">{{ $member->created_at->format('F j, Y') }}</p>
                        </div>

                        <div class="flex justify-end pt-4">
                            <a href="/profile/edit" class="px-8 py-3 accent-gold text-white text-xs uppercase tracking-wider hover:bg-black transition inline-flex items-center gap-2">
                                <i class="fas fa-edit"></i> Edit Profile
                            </a>
                        </div>
                    </div>
                </div>

                <div class="mt-6 bg-gradient-to-r from-amber-50 to-yellow-50 border border-amber-200 p-6 flex justify-between items-center rounded-lg">
                    <div><i class="fas fa-crown text-amber-600 text-2xl"></i><p class="text-xs text-gray-600 mt-1">Loyalty Points</p></div>
                    <div class="text-right"><p class="text-3xl font-bold text-amber-600">1,250</p><p class="text-[10px] text-gray-500">points earned</p></div>
                </div>
            </div>

            <footer class="mt-auto p-10 text-center text-[10px] uppercase tracking-[0.3em] text-gray-400 border-t border-gray-50">
                © 2026 Meeple Corner Café — Established for the Strategic Mind
            </footer>
        </main>
    </div>

    <script>
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