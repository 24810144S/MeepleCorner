<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,600;0,700;1,400&family=Jost:wght@300;400;500;600&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { 
            background-color: #FDFCF6; /* Luxury Cream */
            font-family: 'Jost', sans-serif;
            color: #1A1A1A;
        }
        .serif { font-family: 'Cormorant Garamond', serif; }
        .accent-gold { background-color: #C5A059; }
        .text-gold { color: #C5A059; }
        .border-gold { border-color: #C5A059; }
        
        /* Smooth fade-in for the "Tricia" feel */
        .fade-in {
            animation: fadeIn 1.5s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .btn-luxury {
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            letter-spacing: 0.2em;
            text-transform: uppercase;
            font-size: 11px;
            font-weight: 600;
        }
        .btn-luxury:hover {
            background-color: #1A1A1A;
            color: white;
            transform: translateY(-2px);
        }
    </style>
</head>
<body class="min-h-screen flex flex-col">

    <nav class="flex justify-between items-center px-10 py-8">
        <div class="serif text-2xl font-bold tracking-tighter">
            M<span class="text-gold">.</span>C
        </div>
        <div class="space-x-8 text-[11px] uppercase tracking-[0.2em] font-medium text-gray-500">
            <a href="#" class="hover:text-gold transition">The Café</a>
            <a href="#" class="hover:text-gold transition">Board Games</a>
            <a href="#" class="hover:text-gold transition">Events</a>
            <a href="/login" class="text-gold font-bold">Login</a>
        </div>
    </nav>

    <main class="flex-1 flex flex-col md:flex-row items-center px-10 md:px-20 fade-in">
        
        <div class="md:w-1/2 space-y-8 py-12">
            <div class="space-y-4">
                <span class="text-gold text-xs uppercase tracking-[0.3em] font-bold">Est. 2026</span>
                <h1 class="serif text-6xl md:text-8xl leading-[0.9] text-gray-900">
                    Strategy <br> 
                    <span class="italic font-light">&</span> Serenity.
                </h1>
            </div>
            
            <p class="max-w-md text-gray-500 leading-relaxed text-sm">
                Experience the art of tabletop gaming in an atmosphere designed for the modern adventurer. High-grade beans, rare vintages, and the world's finest strategy games await your arrival.
            </p>

            <div class="flex flex-col sm:flex-row gap-4 pt-4">
                <a href="/register" class="btn-luxury accent-gold text-white px-10 py-5 text-center shadow-xl">
                    Join the Elite
                </a>
                <a href="/login" class="btn-luxury border border-gray-200 px-10 py-5 text-center hover:border-gold">
                    Book a Table
                </a>
            </div>
        </div>

        <div class="md:w-1/2 relative p-10">
            <div class="relative z-10 w-full aspect-[4/5] bg-gray-100 overflow-hidden border-[15px] border-white shadow-2xl">
                <img src="https://images.unsplash.com/photo-1511512578047-dfb367046420?auto=format&fit=crop&q=80&w=1000" 
                     alt="Luxury Gaming" 
                     class="w-full h-full object-cover grayscale-[20%] hover:scale-105 transition duration-700">
            </div>
            
            <div class="absolute -bottom-4 -left-4 md:left-0 z-20 bg-white p-8 shadow-xl max-w-xs border-t-4 border-gold">
                <span class="text-[10px] uppercase tracking-widest text-gold font-bold">Featured Adventure</span>
                <h3 class="serif text-xl mt-2 text-gray-800 italic">Catan: Starfarers</h3>
                <p class="text-[11px] text-gray-400 mt-2 leading-relaxed">Navigate the cosmos while sipping our signature cold brew. Available for reserve play all month.</p>
            </div>

            <div class="absolute -top-10 -right-10 w-40 h-40 border border-gold rounded-full opacity-20"></div>
        </div>
        <div class="space-x-8 text-[11px] uppercase tracking-[0.2em] font-medium text-gray-500">
            <a href="/" class="hover:text-gold transition">Home</a>
            <a href="/reservation" class="hover:text-gold transition">Reservations</a>
            <a href="/reservation-history" class="hover:text-gold transition">History</a>
            <a href="/profile" class="hover:text-gold transition">Profile</a>
            <a href="/board-games" class="hover:text-gold transition">Games</a>
            <a href="/menu" class="hover:text-gold transition">Menu</a>
            <a href="/login" class="text-gold font-bold">Login</a>
        </div>
    </main>

    <footer class="p-10 flex flex-col md:flex-row justify-between items-center border-t border-gray-100 mt-20">
        <div class="text-[10px] uppercase tracking-widest text-gray-400 mb-4 md:mb-0">
            © 2026 Meeple Corner Café — Boutique Gaming Experience
        </div>
        <div class="flex space-x-6 text-gray-400">
            <a href="#" class="hover:text-gold transition"><i class="fab fa-instagram"></i></a>
            <a href="#" class="hover:text-gold transition"><i class="fab fa-facebook-f text-xs"></i></a>
            <a href="#" class="hover:text-gold transition"><i class="fab fa-pinterest-p"></i></a>
        </div>
    </footer>

</body>
</html>