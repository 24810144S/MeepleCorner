<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile | Meeple Corner Café</title>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600;700&family=Jost:wght@300;400;500;600&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { background-color: #FDFCF6; font-family: 'Jost', sans-serif; color: #1A1A1A; }
        .serif { font-family: 'Cormorant Garamond', serif; }
        .accent-gold { background-color: #C5A059; }
        .text-gold { color: #C5A059; }
        input { border: 1px solid #e5e7eb; background-color: #fcfcfc; border-radius: 0; }
        input:focus { border-color: #C5A059; outline: none; box-shadow: 0 0 0 2px rgba(197,160,89,0.1); }
        .tab-active { border-bottom: 2px solid #C5A059; color: #C5A059; }
        
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
                <div><h2 class="serif text-2xl text-gray-800 italic"><i class="fas fa-edit mr-2 text-gold"></i> Edit My Account</h2></div>
                <div class="flex items-center space-x-6">
                    <span class="text-[11px] uppercase tracking-widest text-gray-400">Welcome, {{ $member->first_name }}</span>
                    <div class="w-10 h-10 bg-gold rounded-full flex items-center justify-center text-white font-bold">{{ strtoupper(substr($member->first_name, 0, 1)) }}</div>
                </div>
            </header>

            <div class="p-10 max-w-4xl w-full mx-auto">
                @if(session('success'))
                    <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 text-sm">{{ session('success') }}</div>
                @endif

                @if($errors->any())
                    <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-600 text-sm">
                        @foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach
                    </div>
                @endif

                <!-- Tab Navigation -->
                <div class="flex border-b border-gray-200 mb-8">
                    <button id="tabEditBtn" class="py-3 px-6 text-sm font-medium uppercase tracking-wider transition-all tab-active">
                        <i class="fas fa-user-edit mr-2"></i> Edit Account
                    </button>
                    <button id="tabPasswordBtn" class="py-3 px-6 text-sm font-medium uppercase tracking-wider text-gray-500 hover:text-gold transition-all">
                        <i class="fas fa-lock mr-2"></i> Change Password
                    </button>
                </div>

                <!-- Tab 1: Edit Account Form -->
                <div id="editAccountTab" class="bg-white border border-gray-100 shadow-sm overflow-hidden">
                    <div class="p-8 border-b border-gray-100 bg-gray-50">
                        <h3 class="serif text-2xl text-gray-800">Edit Personal Information</h3>
                        <p class="text-sm text-gray-500">Update your account details</p>
                    </div>

                    <form method="POST" action="{{ route('profile.edit') }}" class="p-8 space-y-6">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-[11px] font-bold uppercase tracking-wider text-gray-500 mb-1">First Name</label>
                                <input type="text" name="first_name" value="{{ old('first_name', $member->first_name) }}" required class="w-full px-4 py-3">
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold uppercase tracking-wider text-gray-500 mb-1">Last Name</label>
                                <input type="text" name="last_name" value="{{ old('last_name', $member->last_name) }}" required class="w-full px-4 py-3">
                            </div>
                        </div>

                        <div>
                            <label class="block text-[11px] font-bold uppercase tracking-wider text-gray-500 mb-1">Address</label>
                            <input type="text" name="address" value="{{ old('address', $member->address) }}" required class="w-full px-4 py-3">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-[11px] font-bold uppercase tracking-wider text-gray-500 mb-1">Phone Number</label>
                                <input type="tel" name="phone" value="{{ old('phone', $member->phone) }}" required class="w-full px-4 py-3">
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold uppercase tracking-wider text-gray-500 mb-1">Email Address</label>
                                <input type="email" name="email" value="{{ old('email', $member->email) }}" required class="w-full px-4 py-3">
                            </div>
                        </div>

                        <div class="flex justify-end gap-4 pt-4">
                            <a href="/profile/info" class="px-8 py-3 border border-gray-300 text-gray-600 text-xs uppercase tracking-wider hover:bg-gray-50 transition">Cancel</a>
                            <button type="submit" class="px-8 py-3 accent-gold text-white text-xs uppercase tracking-wider hover:bg-black transition">
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Tab 2: Change Password Form -->
                <div id="changePasswordTab" class="bg-white border border-gray-100 shadow-sm overflow-hidden hidden">
                    <div class="p-8 border-b border-gray-100 bg-gray-50">
                        <h3 class="serif text-2xl text-gray-800">Change Password</h3>
                        <p class="text-sm text-gray-500">Update your password to keep your account secure</p>
                    </div>

                    <form method="POST" action="{{ route('profile.password') }}" class="p-8 space-y-6">
                        @csrf
                        
                        <div>
                            <label class="block text-[11px] font-bold uppercase tracking-wider text-gray-500 mb-1">Current Password</label>
                            <input type="password" name="current_password" required class="w-full px-4 py-3">
                        </div>

                        <div>
                            <label class="block text-[11px] font-bold uppercase tracking-wider text-gray-500 mb-1">New Password</label>
                            <input type="password" name="password" required class="w-full px-4 py-3">
                            <p class="text-[10px] text-gray-400 mt-1">Minimum 6 characters</p>
                        </div>

                        <div>
                            <label class="block text-[11px] font-bold uppercase tracking-wider text-gray-500 mb-1">Confirm New Password</label>
                            <input type="password" name="password_confirmation" required class="w-full px-4 py-3">
                        </div>

                        <div class="flex justify-end gap-4 pt-4">
                            <a href="/profile/info" class="px-8 py-3 border border-gray-300 text-gray-600 text-xs uppercase tracking-wider hover:bg-gray-50 transition">Cancel</a>
                            <button type="submit" class="px-8 py-3 accent-gold text-white text-xs uppercase tracking-wider hover:bg-black transition">
                                Update Password
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Security Tips -->
                <div class="mt-6 bg-blue-50 border border-blue-200 p-6 rounded-lg">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-shield-alt text-blue-500 text-2xl"></i>
                        <div>
                            <h4 class="font-bold text-gray-800 text-sm">Security Tips</h4>
                            <p class="text-xs text-gray-500">Use a strong password with letters, numbers, and symbols. Never share your password with anyone.</p>
                        </div>
                    </div>
                </div>
            </div>

            <footer class="mt-auto p-10 text-center text-[10px] uppercase tracking-[0.3em] text-gray-400 border-t border-gray-50">
                © 2026 Meeple Corner Café — Established for the Strategic Mind
            </footer>
        </main>
    </div>

    <script>
        // Tab switching functionality
        const tabEditBtn = document.getElementById('tabEditBtn');
        const tabPasswordBtn = document.getElementById('tabPasswordBtn');
        const editAccountTab = document.getElementById('editAccountTab');
        const changePasswordTab = document.getElementById('changePasswordTab');

        tabEditBtn.addEventListener('click', () => {
            tabEditBtn.classList.add('tab-active');
            tabEditBtn.classList.remove('text-gray-500');
            tabPasswordBtn.classList.remove('tab-active');
            tabPasswordBtn.classList.add('text-gray-500');
            editAccountTab.classList.remove('hidden');
            changePasswordTab.classList.add('hidden');
        });

        tabPasswordBtn.addEventListener('click', () => {
            tabPasswordBtn.classList.add('tab-active');
            tabPasswordBtn.classList.remove('text-gray-500');
            tabEditBtn.classList.remove('tab-active');
            tabEditBtn.classList.add('text-gray-500');
            changePasswordTab.classList.remove('hidden');
            editAccountTab.classList.add('hidden');
        });

        // Dropdown toggle
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