<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>
            {{ $title ? ($title . ' | ' . config('app.name', 'Zentara')) : config('app.name', 'Zentara') }}
        </title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Playfair+Display:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles

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

            @keyframes rotate-bezel { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
            @keyframes tick { 0%, 50% { transform: rotate(0deg); } 51%, 100% { transform: rotate(6deg); } }
            @keyframes float { 0%, 100% { transform: translateY(0px) rotate(0deg); } 50% { transform: translateY(-20px) rotate(2deg); } }
            @keyframes pulse-gold { 0%, 100% { box-shadow: 0 0 25px rgba(212, 175, 55, 0.5); } 50% { box-shadow: 0 0 50px rgba(212, 175, 55, 0.9); } }
            @keyframes fadeInUp { from { opacity: 0; transform: translateY(40px); } to { opacity: 1; transform: translateY(0); } }

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

            /* Note: Inputs use component-level classes for dark styling */
        </style>
    </head>
    <body class="font-inter antialiased text-white">
        <div class="min-h-screen bg-white">
            @if(auth()->check() && auth()->user()->role === 'admin')
                <a href="{{ route('admin.dashboard') }}" class="fixed top-4 right-4 z-50 inline-flex items-center gap-2 px-4 py-2 rounded-full bg-yellow-500 text-gray-900 shadow-lg hover:bg-yellow-400 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M13 5v6m8 8h-6a2 2 0 01-2-2v-4H9v4a2 2 0 01-2 2H1"/></svg>
                    Admin Dashboard
                </a>
            @endif
            <x-user-nav />
            <livewire:products.quick-view />
            <livewire:cart.mini />

            <div
                x-data="{ show:false, message:'', timeout: null }"
                x-init="window.addEventListener('toast', e => { clearTimeout(timeout); message = e.detail?.message || 'Saved.'; show = true; timeout = setTimeout(() => show = false, 2000); });"
                x-show="show"
                x-transition
                class="fixed bottom-6 right-6 z-[97] bg-gray-900 text-white px-4 py-3 rounded-lg shadow-lg">
                <span x-text="message"></span>
            </div>

            @if (isset($header))
                <header class="glass-effect">
                    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <main>
                {{ $slot }}
            </main>
        </div>

        @stack('modals')

        @livewireScripts
    </body>
    
</html>
