<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Zentara') }}</title>

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
                background: rgba(255, 255, 255, 0.06);
                backdrop-filter: blur(20px);
                border: 1px solid rgba(255, 255, 255, 0.12);
            }

            .hero-pattern {
                background-image:
                    radial-gradient(circle at 20% 30%, rgba(212, 175, 55, 0.15) 0%, transparent 50%),
                    radial-gradient(circle at 80% 70%, rgba(212, 175, 55, 0.1) 0%, transparent 50%),
                    radial-gradient(circle at 40% 90%, rgba(22, 33, 62, 0.3) 0%, transparent 50%);
            }

            /* Ensure form fields stay readable on dark background */
            input[type="text"],
            input[type="email"],
            input[type="password"],
            input[type="number"],
            input[type="search"],
            input[type="tel"],
            textarea,
            select {
                color: #111827; /* gray-900 */
                background-color: #ffffff;
            }

            input::placeholder,
            textarea::placeholder {
                color: #9CA3AF; /* gray-400 */
            }
        </style>
    </head>
    <body class="font-inter antialiased text-white">
        <div class="min-h-screen bg-luxury-gradient hero-pattern">
            @if(auth()->check() && auth()->user()->role === 'admin')
                <a href="{{ route('admin.dashboard') }}" class="fixed top-4 right-4 z-50 inline-flex items-center gap-2 px-4 py-2 rounded-full bg-yellow-500 text-gray-900 shadow-lg hover:bg-yellow-400 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M13 5v6m8 8h-6a2 2 0 01-2-2v-4H9v4a2 2 0 01-2 2H1"/></svg>
                    Admin Dashboard
                </a>
            @endif
            {{ $slot }}
        </div>

        @livewireScripts
    </body>
</html>
