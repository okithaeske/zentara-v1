<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>
            {{ isset($title) && $title ? ($title . ' | Admin | ' . config('app.name', 'Zentara')) : ('Admin | ' . config('app.name', 'Zentara')) }}
        </title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        @livewireStyles

        <style>
            .bg-luxury-gradient { background: linear-gradient(135deg, #0a0a0a 0%, #1a1a2e 30%, #16213e 70%, #0f3460 100%); }
            .text-luxury-gold { background: linear-gradient(45deg, #d4af37, #ffd700, #ffed4e); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
            .glass { background: rgba(255,255,255,0.04); backdrop-filter: blur(16px); border: 1px solid rgba(255,255,255,0.08); }
        </style>
    </head>
    <body class="antialiased text-white">
        <div class="min-h-screen bg-luxury-gradient" x-data="{ sidebarOpen: false }">
            <!-- Sidebar -->
            <aside class="fixed inset-y-0 left-0 w-72 bg-black/70 glass border-r border-yellow-500/20 z-40 hidden lg:flex flex-col">
                <div class="h-20 flex items-center px-6 border-b border-yellow-500/10">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-yellow-500 flex items-center justify-center">
                            <svg class="w-5 h-5 text-gray-900" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 2a10 10 0 100 20 10 10 0 000-20Zm0 18a8 8 0 110-16 8 8 0 010 16Zm1-7h3v2h-5V7h2v6Z"/>
                            </svg>
                        </div>
                        <div>
                            <div class="text-luxury-gold font-semibold">Admin</div>
                            <div class="text-xs text-gray-400">{{ config('app.name', 'Zentara') }}</div>
                        </div>
                    </a>
                </div>

                <nav class="flex-1 overflow-y-auto py-4">
                    <ul class="px-3 space-y-1">
                        <li>
                            <a href="{{ route('admin.dashboard') }}" class="group flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium bg-white/5 text-yellow-200 border border-yellow-500/10">
                                <svg class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M13 5v6m8 8h-6a2 2 0 01-2-2v-4H9v4a2 2 0 01-2 2H1"/>
                                </svg>
                                Dashboard
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.users.index') }}" class="group flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-300 hover:text-yellow-200 hover:bg-white/5">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a4 4 0 00-4-4h-1M9 20H4v-2a4 4 0 014-4h1m4-4a4 4 0 11-8 0 4 4 0 018 0zm6 0a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                                Users
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.sellers.index') }}" class="group flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-300 hover:text-yellow-200 hover:bg-white/5">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V7a2 2 0 00-2-2h-3l-1-2H10L9 5H6a2 2 0 00-2 2v6m16 0v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4m16 0H4"/>
                                </svg>
                                Sellers
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('profile.show') }}" class="group flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-300 hover:text-yellow-200 hover:bg-white/5">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A9 9 0 1118.88 6.196 9 9 0 015.12 17.804z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                Profile
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('home') }}" class="group flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-300 hover:text-yellow-200 hover:bg-white/5">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h18M3 17h18"/>
                                </svg>
                                Site
                            </a>
                        </li>
                    </ul>
                </nav>
                <div class="p-4 border-t border-yellow-500/10">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="w-full px-3 py-2 rounded bg-white/10 text-sm">Logout</button>
                    </form>
                </div>
            </aside>

            <!-- Mobile top bar + drawer button -->
            <div class="lg:hidden p-4 bg-black/50 border-b border-yellow-500/20 flex items-center justify-between">
                <button @click="sidebarOpen = !sidebarOpen" class="px-3 py-2 rounded bg-white/10">Menu</button>
                <a href="{{ route('admin.dashboard') }}" class="text-luxury-gold font-semibold">Admin</a>
            </div>
            <!-- Mobile drawer -->
            <div x-show="sidebarOpen" @click.away="sidebarOpen = false" class="lg:hidden fixed inset-0 z-50">
                <div class="absolute inset-0 bg-black/60"></div>
                <div class="absolute inset-y-0 left-0 w-72 bg-black/80 glass p-4">
                    <div class="flex items-center justify-between">
                        <div class="text-luxury-gold font-semibold">Admin</div>
                        <button @click="sidebarOpen = false" class="px-2 py-1 rounded bg-white/10">Close</button>
                    </div>
                    <nav class="mt-4 space-y-1">
                        <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded-md bg-white/5 text-yellow-200">Dashboard</a>
                        <a href="{{ route('admin.users.index') }}" class="block px-3 py-2 rounded-md text-gray-300 hover:bg-white/5">Users</a>
                        <a href="{{ route('admin.sellers.index') }}" class="block px-3 py-2 rounded-md text-gray-300 hover:bg-white/5">Sellers</a>
                        <a href="{{ route('profile.show') }}" class="block px-3 py-2 rounded-md text-gray-300 hover:bg-white/5">Profile</a>
                        <a href="{{ route('home') }}" class="block px-3 py-2 rounded-md text-gray-300 hover:bg-white/5">Site</a>
                    </nav>
                </div>
            </div>

            <!-- Main content -->
            <main class="lg:pl-72">
                <div class="px-4 sm:px-6 lg:px-8 py-6">
                    @if (session('status'))
                        <div class="mb-4 px-4 py-2 rounded border border-green-600/30 bg-green-600/20 text-green-300 text-sm">{{ session('status') }}</div>
                    @endif
                    @if ($errors->any())
                        <div class="mb-4 px-4 py-2 rounded border border-red-600/30 bg-red-600/20 text-red-300 text-sm">{{ $errors->first() }}</div>
                    @endif
                    @yield('content')
                </div>
            </main>
        </div>

        @livewireScripts
    </body>
</html>
