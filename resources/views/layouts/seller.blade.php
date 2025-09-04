<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>
            {{ isset($title) && $title ? ($title . ' | Seller | ' . config('app.name', 'Zentara')) : ('Seller | ' . config('app.name', 'Zentara')) }}
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
                    <a href="{{ route('seller.dashboard') }}" class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-yellow-500 flex items-center justify-center">
                            <svg class="w-5 h-5 text-gray-900" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 2a10 10 0 100 20 10 10 0 000-20Zm0 18a8 8 0 110-16 8 8 0 010 16Zm1-7h3v2h-5V7h2v6Z"/>
                            </svg>
                        </div>
                        <div>
                            <div class="text-luxury-gold font-semibold">Seller</div>
                            <div class="text-xs text-gray-400">{{ config('app.name', 'Zentara') }}</div>
                        </div>
                    </a>
                </div>

                <nav class="flex-1 overflow-y-auto py-4">
                    <ul class="px-3 space-y-1">
                        <li>
                            <a href="{{ route('seller.dashboard') }}" class="group flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium bg-white/5 text-yellow-200 border border-yellow-500/10">
                                <svg class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M13 5v6m8 8h-6a2 2 0 01-2-2v-4H9v4a2 2 0 01-2 2H1"/>
                                </svg>
                                Dashboard
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('seller.orders.index') }}" class="group flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-300 hover:text-yellow-200 hover:bg-white/5">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h18M3 17h18"/>
                                </svg>
                                Orders
                                <span class="ml-auto text-xs px-2 py-0.5 rounded bg-yellow-500/20 text-yellow-300">0</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('seller.products.index') }}" class="group flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-300 hover:text-yellow-200 hover:bg-white/5">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V7a2 2 0 00-2-2h-3l-1-2H10L9 5H6a2 2 0 00-2 2v6m16 0v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4m16 0H4"/>
                                </svg>
                                Products
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('seller.inventory.index') }}" class="group flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-300 hover:text-yellow-200 hover:bg-white/5">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13l-8 4-8-4m16 0l-8-4-8 4m16 0v6l-8 4-8-4v-6"/>
                                </svg>
                                Inventory
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('seller.payouts.index') }}" class="group flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-300 hover:text-yellow-200 hover:bg-white/5">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2-1.343-2-3-2z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12c0 4.418-4.03 8-9 8s-9-3.582-9-8 4.03-8 9-8 9 3.582 9 8z"/>
                                </svg>
                                Payouts
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('seller.products.create') }}" class="group flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-300 hover:text-yellow-200 hover:bg-white/5">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                                Add Product
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('seller.settings') }}" class="group flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-300 hover:text-yellow-200 hover:bg-white/5">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17a2 2 0 104 0 2 2 0 00-4 0zM7 7h10M7 11h10M7 15h6"/>
                                </svg>
                                Settings
                            </a>
                        </li>
                    </ul>
                </nav>

                <div class="mt-auto p-4 border-t border-yellow-500/10 text-xs text-gray-400">
                    <div>Account: <span class="text-gray-300">{{ Auth::user()->name ?? 'Seller' }}</span></div>
                    <form method="POST" action="{{ route('logout') }}" class="mt-2">
                        @csrf
                        <button class="w-full px-3 py-2 rounded-md bg-white/5 hover:bg-white/10 text-gray-200 text-sm">Log out</button>
                    </form>
                </div>
            </aside>

            <!-- Mobile top bar -->
            <header class="lg:hidden flex items-center justify-between px-4 h-16 bg-black/60 glass border-b border-yellow-500/20">
                <button @click="sidebarOpen = true" class="p-2 rounded-md bg-white/5 text-gray-200" aria-label="Open sidebar">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                <div class="text-sm"><span class="text-luxury-gold font-semibold">Seller</span> | {{ config('app.name', 'Zentara') }}</div>
            </header>

            <!-- Offcanvas sidebar for mobile -->
            <div x-show="sidebarOpen" x-transition.opacity class="fixed inset-0 z-50 lg:hidden" aria-hidden="true">
                <div @click="sidebarOpen = false" class="absolute inset-0 bg-black/50"></div>
                <div class="absolute inset-y-0 left-0 w-72 bg-black/90 glass border-r border-yellow-500/20 p-4">
                    <div class="flex items-center justify-between h-12">
                        <div class="text-luxury-gold font-semibold">Seller Menu</div>
                        <button @click="sidebarOpen = false" class="p-2 text-gray-300" aria-label="Close sidebar">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                    <nav class="mt-4 space-y-1">
                        <a href="{{ route('seller.dashboard') }}" class="block px-3 py-2 rounded-md bg-white/5 text-yellow-200">Dashboard</a>
                        <a href="{{ route('seller.orders.index') }}" class="block px-3 py-2 rounded-md text-gray-300 hover:bg-white/5">Orders</a>
                        <a href="{{ route('seller.products.index') }}" class="block px-3 py-2 rounded-md text-gray-300 hover:bg-white/5">Products</a>
                        <a href="{{ route('seller.inventory.index') }}" class="block px-3 py-2 rounded-md text-gray-300 hover:bg-white/5">Inventory</a>
                        <a href="{{ route('seller.payouts.index') }}" class="block px-3 py-2 rounded-md text-gray-300 hover:bg-white/5">Payouts</a>
                        <a href="{{ route('seller.settings') }}" class="block px-3 py-2 rounded-md text-gray-300 hover:bg-white/5">Settings</a>
                    </nav>
                </div>
            </div>

            <!-- Main content -->
            <main class="lg:pl-72">
                <div class="px-4 sm:px-6 lg:px-8 py-6">
                    @yield('content')
                </div>
            </main>
        </div>

        @livewireScripts
    </body>
</html>
