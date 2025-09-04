<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Zentara - Swiss Luxury Timepieces</title>
    @vite(['resources/css/app.css'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Playfair+Display:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        @import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css');
        
        .font-display { font-family: 'Playfair Display', serif; }
        .font-inter { font-family: 'Inter', sans-serif; }
        
        .bg-luxury-gradient {
            background: linear-gradient(135deg, #0a0a0a 0%, #1a1a2e 30%, #16213e 70%, #0f3460 100%);
        }
        
        .text-luxury-gold {
            background: linear-gradient(45deg, #d4af37, #ffd700, #ffed4e);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .bg-luxury-gold {
            background: linear-gradient(45deg, #d4af37, #ffd700, #ffed4e);
        }
        
        .glass-effect {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .watch-glow {
            box-shadow: 
                0 0 80px rgba(212, 175, 55, 0.3),
                0 0 120px rgba(212, 175, 55, 0.15),
                inset 0 0 60px rgba(255, 255, 255, 0.1);
        }
        
        .mechanical-glow {
            box-shadow: 
                0 0 40px rgba(212, 175, 55, 0.4),
                0 0 80px rgba(212, 175, 55, 0.2);
        }
        
        @keyframes rotate-bezel {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        @keyframes tick {
            0%, 50% { transform: rotate(0deg); }
            51%, 100% { transform: rotate(6deg); }
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(2deg); }
        }
        
        @keyframes pulse-gold {
            0%, 100% { box-shadow: 0 0 25px rgba(212, 175, 55, 0.5); }
            50% { box-shadow: 0 0 50px rgba(212, 175, 55, 0.9); }
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(40px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .animate-float { animation: float 10s ease-in-out infinite; }
        .animate-pulse-gold { animation: pulse-gold 4s ease-in-out infinite; }
        .animate-fadeInUp { animation: fadeInUp 1.2s ease-out; }
        .animate-rotate-bezel { animation: rotate-bezel 120s linear infinite; }
        .animate-tick { animation: tick 1s ease-in-out infinite; }
        
        .hero-pattern {
            background-image: 
                radial-gradient(circle at 20% 30%, rgba(212, 175, 55, 0.15) 0%, transparent 50%),
                radial-gradient(circle at 80% 70%, rgba(212, 175, 55, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 40% 90%, rgba(22, 33, 62, 0.3) 0%, transparent 50%);
        }
        
        .feature-hover:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 25px 60px rgba(212, 175, 55, 0.3);
        }
        
        .tourbillon {
            width: 40px;
            height: 40px;
            border: 2px solid #ffd700;
            border-radius: 50%;
            position: relative;
            animation: rotate-bezel 8s linear infinite;
        }
        
        .tourbillon::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 20px;
            height: 2px;
            background: #ffd700;
        }
        
        .watch-hands {
            position: absolute;
            top: 50%;
            left: 50%;
            transform-origin: bottom center;
        }
        
        .hour-hand {
            width: 3px;
            height: 40px;
            background: #ffd700;
            transform: translate(-50%, -100%) rotate(30deg);
        }
        
        .minute-hand {
            width: 2px;
            height: 55px;
            background: #fff;
            transform: translate(-50%, -100%) rotate(180deg);
            animation: tick 60s steps(60) infinite;
        }
        
        .second-hand {
            width: 1px;
            height: 60px;
            background: #ff4444;
            transform: translate(-50%, -100%) rotate(90deg);
            animation: tick 1s steps(60) infinite;
        }
    </style>
</head>
<body class="font-inter bg-luxury-gradient text-white overflow-x-hidden">
    <div class="min-h-screen relative hero-pattern">
        <!-- Navigation -->
        <nav class="absolute top-0 left-0 right-0 z-50 glass-effect">
            <div class="max-w-7xl mx-auto px-6 py-4">
                <div class="flex items-center justify-between">
                    <div class="font-display text-3xl font-bold text-luxury-gold">Zentara</div>
                    <div class="hidden md:flex items-center space-x-8">
                        <a href="#" class="text-white/80 hover:text-luxury-gold transition-colors duration-300">Collections</a>
                        <a href="#" class="text-white/80 hover:text-luxury-gold transition-colors duration-300">Complications</a>
                        <a href="#" class="text-white/80 hover:text-luxury-gold transition-colors duration-300">Heritage</a>
                        <a href="#" class="text-white/80 hover:text-luxury-gold transition-colors duration-300">Atelier</a>
                    </div>
                    <div class="flex items-center space-x-4">
                        @if (Route::has('login'))
                            @auth
                                @php $role = auth()->user()->role ?? 'user'; @endphp
                                <a href="{{ $role === 'admin'
                                    ? (Route::has('admin.dashboard') ? route('admin.dashboard') : route('dashboard'))
                                    : ($role === 'seller'
                                        ? (Route::has('seller.dashboard') ? route('seller.dashboard') : route('dashboard'))
                                        : route('dashboard')) }}"
                                    class="px-6 py-2 border border-yellow-500 text-yellow-500 rounded-full hover:bg-yellow-500 hover:text-black transition-all duration-300">
                                    {{ ucfirst($role) }} Dashboard
                                </a>
                                <form method="POST" action="{{ route('logout') }}" class="inline">
                                    @csrf
                                    <button type="submit" class="px-6 py-2 bg-luxury-gold text-black rounded-full font-semibold hover:shadow-lg hover:shadow-yellow-500/50 transition-all duration-300">
                                        Log out
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('login') }}" class="px-6 py-2 border border-yellow-500 text-yellow-500 rounded-full hover:bg-yellow-500 hover:text-black transition-all duration-300">
                                    Sign In
                                </a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="px-6 py-2 bg-luxury-gold text-black rounded-full font-semibold hover:shadow-lg hover:shadow-yellow-500/50 transition-all duration-300">
                                        Register
                                    </a>
                                @endif
                            @endauth
                        @endif
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content Grid -->
        <div class="pt-20 pb-10 px-6">
            <div class="max-w-7xl mx-auto">
                <div class="grid lg:grid-cols-12 gap-8 min-h-screen items-center">
                    
                    <!-- Left Side - Content -->
                    <div class="lg:col-span-5 space-y-8 animate-fadeInUp">
                        <!-- Hero Text -->
                        <div class="space-y-6">
                            <div class="space-y-2">
                                <div class="text-luxury-gold text-sm font-medium tracking-widest uppercase">Swiss Haute Horlogerie</div>
                                <h1 class="font-display text-6xl lg:text-7xl font-bold leading-tight">
                                    Mechanical<br>
                                    <span class="text-luxury-gold">Mastery</span>
                                </h1>
                            </div>
                            <p class="text-xl text-white/70 leading-relaxed max-w-md">
                                Hand-crafted timepieces where centuries-old Swiss traditions meet contemporary innovation. Each movement tells a story of precision.
                            </p>
                        </div>
                        
                        <!-- Key Stats -->
                        <div class="grid grid-cols-3 gap-6 py-6">
                            <div>
                                <div class="text-3xl font-bold text-luxury-gold">42H</div>
                                <div class="text-sm text-white/60">Power Reserve</div>
                            </div>
                            <div>
                                <div class="text-3xl font-bold text-luxury-gold">300M</div>
                                <div class="text-sm text-white/60">Water Resist</div>
                            </div>
                            <div>
                                <div class="text-3xl font-bold text-luxury-gold">±2s</div>
                                <div class="text-sm text-white/60">Daily Precision</div>
                            </div>
                        </div>

                        <!-- CTA Buttons -->
                        <div class="flex flex-col sm:flex-row gap-4">
                            <a href="#" class="px-8 py-4 bg-luxury-gold text-black rounded-full font-semibold text-lg hover:shadow-2xl hover:shadow-yellow-500/50 transition-all duration-500 transform hover:-translate-y-2 text-center">
                                Explore Masterpieces
                            </a>
                            <a href="#" class="px-8 py-4 glass-effect text-white rounded-full font-semibold text-lg hover:bg-white/10 transition-all duration-500 transform hover:-translate-y-2 text-center">
                                <i class="fas fa-cog mr-2"></i>Manufacture Tour
                            </a>
                        </div>
                    </div>
                    
                    <!-- Center - Luxury Watch Display -->
                    <div class="lg:col-span-4 flex items-center justify-center relative">
                        <div class="relative w-full max-w-md">
                            <!-- Main Watch with Enhanced Luxury Design -->
                            <div class="relative w-80 h-80 mx-auto animate-float">
                                <!-- Watch Case -->
                                <div class="absolute inset-0 rounded-full watch-glow border-4 border-yellow-500/60" style="background: radial-gradient(circle at 30% 30%, #2a2a2a, #1a1a1a, #0f0f0f);">
                                    
                                    <!-- Rotating Bezel -->
                                    <div class="absolute inset-2 rounded-full border-2 border-yellow-500 animate-rotate-bezel" style="background: conic-gradient(from 0deg, #333, #555, #333, #555);">
                                        <!-- Bezel Markers -->
                                        <div class="absolute w-1 h-4 bg-yellow-500 top-0 left-1/2 transform -translate-x-1/2"></div>
                                        <div class="absolute w-1 h-4 bg-yellow-500 top-1/2 right-0 transform -translate-y-1/2 rotate-90"></div>
                                        <div class="absolute w-1 h-4 bg-yellow-500 bottom-0 left-1/2 transform -translate-x-1/2 rotate-180"></div>
                                        <div class="absolute w-1 h-4 bg-yellow-500 top-1/2 left-0 transform -translate-y-1/2 rotate-270"></div>
                                    </div>
                                    
                                    <!-- Watch Dial -->
                                    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-56 h-56 rounded-full flex flex-col items-center justify-center" style="background: radial-gradient(circle, #1a1a1a, #0a0a0a); border: 2px solid #333;">
                                        
                                        <!-- Hour Markers -->
                                        <div class="absolute inset-0">
                                            <!-- 12 o'clock marker -->
                                            <div class="absolute w-2 h-8 bg-yellow-500 top-2 left-1/2 transform -translate-x-1/2"></div>
                                            <!-- 3 o'clock marker -->
                                            <div class="absolute w-8 h-2 bg-yellow-500 top-1/2 right-2 transform -translate-y-1/2"></div>
                                            <!-- 6 o'clock marker -->
                                            <div class="absolute w-2 h-8 bg-yellow-500 bottom-2 left-1/2 transform -translate-x-1/2"></div>
                                            <!-- 9 o'clock marker -->
                                            <div class="absolute w-8 h-2 bg-yellow-500 top-1/2 left-2 transform -translate-y-1/2"></div>
                                            
                                            <!-- Minute markers -->
                                            <div class="absolute inset-4">
                                                <div class="absolute w-0.5 h-4 bg-white/60 top-0 left-1/2 transform -translate-x-1/2 rotate-30"></div>
                                                <div class="absolute w-0.5 h-4 bg-white/60 top-0 left-1/2 transform -translate-x-1/2 rotate-60"></div>
                                                <div class="absolute w-0.5 h-4 bg-white/60 top-0 left-1/2 transform -translate-x-1/2 rotate-120"></div>
                                                <div class="absolute w-0.5 h-4 bg-white/60 top-0 left-1/2 transform -translate-x-1/2 rotate-150"></div>
                                                <div class="absolute w-0.5 h-4 bg-white/60 top-0 left-1/2 transform -translate-x-1/2 rotate-210"></div>
                                                <div class="absolute w-0.5 h-4 bg-white/60 top-0 left-1/2 transform -translate-x-1/2 rotate-240"></div>
                                                <div class="absolute w-0.5 h-4 bg-white/60 top-0 left-1/2 transform -translate-x-1/2 rotate-300"></div>
                                                <div class="absolute w-0.5 h-4 bg-white/60 top-0 left-1/2 transform -translate-x-1/2 rotate-330"></div>
                                            </div>
                                        </div>
                                        
                                        <!-- Watch Hands -->
                                        <div class="absolute inset-0 flex items-center justify-center">
                                            <!-- Hour Hand -->
                                            <div class="watch-hands hour-hand"></div>
                                            <!-- Minute Hand -->
                                            <div class="watch-hands minute-hand"></div>
                                            <!-- Second Hand -->
                                            <div class="watch-hands second-hand"></div>
                                            <!-- Center Dot -->
                                            <div class="absolute w-3 h-3 bg-yellow-500 rounded-full z-10"></div>
                                        </div>
                                        
                                        <!-- Tourbillon Window -->
                                        <div class="absolute bottom-16 left-1/2 transform -translate-x-1/2">
                                            <div class="tourbillon mechanical-glow"></div>
                                        </div>
                                        
                                        <!-- Brand Logo -->
                                        <div class="absolute top-12 left-1/2 transform -translate-x-1/2">
                                            <div class="text-yellow-500 text-xs font-bold tracking-widest">ZENTARA</div>
                                            <div class="text-white/40 text-[8px] text-center">GENÈVE</div>
                                        </div>
                                        
                                        <!-- Date Window -->
                                        <div class="absolute right-12 top-1/2 transform -translate-y-1/2">
                                            <div class="w-8 h-6 bg-white rounded-sm flex items-center justify-center text-black text-xs font-bold">
                                                24
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Crown and Pushers -->
                                    <div class="absolute right-0 top-1/2 transform translate-x-2 -translate-y-6 w-4 h-8 bg-yellow-500 rounded-r-lg shadow-lg"></div>
                                    <div class="absolute right-0 top-1/2 transform translate-x-2 translate-y-2 w-3 h-5 bg-yellow-500 rounded-r-md shadow-lg"></div>
                                    <div class="absolute right-0 top-1/2 transform translate-x-2 -translate-y-16 w-2 h-4 bg-yellow-500 rounded-r-sm shadow-lg"></div>
                                </div>
                                
                                <!-- Luxury Watch Bands -->
                                <div class="absolute top-1/2 left-0 transform -translate-x-8 -translate-y-1/2 w-16 h-64 rounded-l-full shadow-2xl" style="background: linear-gradient(to bottom, #4a4a4a 0%, #2a2a2a 50%, #1a1a1a 100%); border-left: 2px solid #333;"></div>
                                <div class="absolute top-1/2 right-0 transform translate-x-8 -translate-y-1/2 w-16 h-64 rounded-r-full shadow-2xl" style="background: linear-gradient(to bottom, #4a4a4a 0%, #2a2a2a 50%, #1a1a1a 100%); border-right: 2px solid #333;"></div>
                            </div>
                            
                            <!-- Floating Complication Icons -->
                            <div class="absolute top-8 right-8 w-14 h-14 glass-effect rounded-full flex items-center justify-center text-yellow-500 animate-pulse-gold">
                                <i class="fas fa-cogs text-lg"></i>
                            </div>
                            <div class="absolute bottom-16 right-4 w-14 h-14 glass-effect rounded-full flex items-center justify-center text-yellow-500 animate-pulse-gold" style="animation-delay: 1.5s">
                                <i class="fas fa-moon text-lg"></i>
                            </div>
                            <div class="absolute top-1/2 left-4 w-14 h-14 glass-effect rounded-full flex items-center justify-center text-yellow-500 animate-pulse-gold" style="animation-delay: 3s">
                                <i class="fas fa-compass text-lg"></i>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Right Side - Complications & Features -->
                    <div class="lg:col-span-3 space-y-4">
                        <!-- Complication Cards -->
                        <div class="glass-effect rounded-2xl p-6 feature-hover transition-all duration-500">
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 bg-luxury-gold rounded-xl flex items-center justify-center">
                                    <i class="fas fa-eye text-black"></i>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-luxury-gold">Open Tourbillon</h3>
                                    <p class="text-sm text-white/60">Visible escapement</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="glass-effect rounded-2xl p-6 feature-hover transition-all duration-500">
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 bg-luxury-gold rounded-xl flex items-center justify-center">
                                    <i class="fas fa-calendar-alt text-black"></i>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-luxury-gold">Perpetual Calendar</h3>
                                    <p class="text-sm text-white/60">Until year 2100</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="glass-effect rounded-2xl p-6 feature-hover transition-all duration-500">
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 bg-luxury-gold rounded-xl flex items-center justify-center">
                                    <i class="fas fa-mountain text-black"></i>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-luxury-gold">Swiss Movement</h3>
                                    <p class="text-sm text-white/60">In-house calibre</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="glass-effect rounded-2xl p-6 feature-hover transition-all duration-500">
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 bg-luxury-gold rounded-xl flex items-center justify-center">
                                    <i class="fas fa-gem text-black"></i>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-luxury-gold">Hand Finished</h3>
                                    <p class="text-sm text-white/60">Master craftsmen</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Pricing -->
                        <div class="glass-effect rounded-2xl p-6 mt-8 border-2 border-yellow-500/30">
                            <div class="text-center space-y-2">
                                <div class="text-sm text-white/60">Grand Complication</div>
                                <div class="text-3xl font-bold text-luxury-gold">$45,900</div>
                                <div class="text-xs text-white/50">Limited to 99 pieces</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Bottom Section - Prestige & Heritage -->
                <div class="grid md:grid-cols-3 gap-8 mt-16 pt-8 border-t border-white/10">
                    <!-- Certification -->
                    <div class="text-center space-y-2">
                        <div class="text-luxury-gold text-2xl">
                            <i class="fas fa-medal"></i>
                        </div>
                        <div class="font-semibold">COSC Certified</div>
                        <div class="text-sm text-white/60">Chronometer</div>
                    </div>
                    
                    <!-- Warranty -->
                    <div class="text-center space-y-2">
                        <div class="text-luxury-gold text-2xl">
                            <i class="fas fa-infinity"></i>
                        </div>
                        <div class="font-semibold">Lifetime Service</div>
                        <div class="text-sm text-white/60">Manufacture Support</div>
                    </div>
                    
                    <!-- Heritage -->
                    <div class="text-center space-y-2">
                        <div class="text-luxury-gold text-2xl">
                            <i class="fas fa-crown"></i>
                        </div>
                        <div class="font-semibold">Since 1875</div>
                        <div class="text-sm text-white/60">Swiss Heritage</div>
                    </div>
                </div>
                
                <!-- Final Footer -->
                <div class="text-center mt-12 pt-8 border-t border-white/10">
                    <div class="flex justify-center space-x-6 mb-6">
                        <a href="#" class="w-10 h-10 glass-effect rounded-full flex items-center justify-center text-yellow-500 hover:bg-yellow-500 hover:text-black transition-all duration-300">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="w-10 h-10 glass-effect rounded-full flex items-center justify-center text-yellow-500 hover:bg-yellow-500 hover:text-black transition-all duration-300">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="w-10 h-10 glass-effect rounded-full flex items-center justify-center text-yellow-500 hover:bg-yellow-500 hover:text-black transition-all duration-300">
                            <i class="fab fa-youtube"></i>
                        </a>
                    </div>
                    <p class="text-sm text-white/40">&copy; 2024 Zentara. Swiss Manufacture. All rights reserved.</p>
                    <p class="text-xs text-white/30 mt-2">Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
