<x-guest-layout>
    <div class="min-h-screen flex items-center py-12 sm:py-16">
        <div class="content-wrapper grid grid-cols-1 gap-8 lg:grid-cols-2 lg:gap-12">
            <div class="hidden lg:flex flex-col justify-between glass-effect rounded-[32px] p-12 border border-white/10">
                <div class="space-y-6">
                    <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/10 text-xs font-semibold uppercase tracking-[0.35em] text-white/80">
                        <i class="fa-solid fa-sparkles text-yellow-400"></i>
                        Welcome Back
                    </span>
                    <h1 class="text-3xl sm:text-4xl xl:text-5xl font-display leading-tight text-luxury-gold">
                        Elevate your Zentara journey
                    </h1>
                    <p class="text-base leading-relaxed text-white/70 max-w-xl text-balance">
                        Sign in to access curated market intelligence, portfolio overviews, and real-time insights crafted for discerning investors.
                    </p>
                </div>
                <ul class="mt-12 space-y-8 text-white/70">
                    <li class="flex gap-4">
                        <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-white/10 text-yellow-400">
                            <i class="fa-solid fa-shield-halved"></i>
                        </span>
                        <div class="space-y-1">
                            <h3 class="text-lg font-semibold text-white">Enterprise-grade security</h3>
                            <p class="text-sm leading-relaxed text-white/60">Advanced threat detection and AES-256 encryption keep every session protected.</p>
                        </div>
                    </li>
                    <li class="flex gap-4">
                        <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-white/10 text-yellow-400">
                            <i class="fa-solid fa-chart-line"></i>
                        </span>
                        <div class="space-y-1">
                            <h3 class="text-lg font-semibold text-white">Actionable analytics</h3>
                            <p class="text-sm leading-relaxed text-white/60">Track performance with intelligent dashboards calibrated to your portfolio.</p>
                        </div>
                    </li>
                    <li class="flex gap-4">
                        <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-white/10 text-yellow-400">
                            <i class="fa-solid fa-headset"></i>
                        </span>
                        <div class="space-y-1">
                            <h3 class="text-lg font-semibold text-white">Concierge support</h3>
                            <p class="text-sm leading-relaxed text-white/60">Dedicated advisors ready to assist around the clock, wherever you are.</p>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="w-full">
                <div class="bg-white/95 backdrop-blur-sm text-gray-900 rounded-[32px] shadow-2xl p-6 sm:p-10 space-y-8">
                    <div class="space-y-2 text-balance">
                        <h2 class="text-2xl sm:text-3xl font-semibold tracking-tight text-gray-900">Sign in to Zentara</h2>
                        <p class="text-sm text-gray-500 leading-relaxed">Enter your credentials to continue with your personalised insights.</p>
                    </div>

                    <x-validation-errors class="rounded-2xl border border-red-100 bg-red-50/80 px-5 py-4 text-sm text-red-600" />

                    @session('status')
                        <div class="rounded-2xl border border-emerald-100 bg-emerald-50 px-5 py-4 text-sm font-medium text-emerald-700">
                            {{ $value }}
                        </div>
                    @endsession

                    <form method="POST" action="{{ route('login') }}" class="space-y-6">
                        @csrf

                        <div class="space-y-2">
                            <label for="email" class="text-sm font-medium text-gray-700">Email address</label>
                            <div class="relative">
                                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                                    <i class="fa-solid fa-envelope"></i>
                                </span>
                                <x-input id="email"
                                         class="block w-full rounded-2xl border-gray-200 bg-white py-3 pl-12 pr-4 text-base text-gray-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                         type="email"
                                         name="email"
                                         :value="old('email')"
                                         required
                                         autofocus
                                         autocomplete="username"
                                         placeholder="you@zentara.com" />
                            </div>
                        </div>

                        <div class="space-y-2">
                            <div class="flex flex-col gap-3 text-sm font-medium text-gray-700 sm:flex-row sm:items-center sm:justify-between">
                                <label for="password">Password</label>
                                @if (Route::has('password.request'))
                                    <a class="text-indigo-600 hover:text-indigo-500" href="{{ route('password.request') }}">
                                        {{ __('Forgot?') }}
                                    </a>
                                @endif
                            </div>
                            <div class="relative">
                                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                                    <i class="fa-solid fa-lock-keyhole"></i>
                                </span>
                                <x-input id="password"
                                         class="block w-full rounded-2xl border-gray-200 bg-white py-3 pl-12 pr-4 text-base text-gray-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                         type="password"
                                         name="password"
                                         required
                                         autocomplete="current-password"
                                         placeholder="Your secure password" />
                            </div>
                        </div>

                        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                            <label for="remember_me" class="flex items-center gap-3 text-sm text-gray-600">
                                <x-checkbox id="remember_me" name="remember" class="rounded-md text-indigo-600 focus:ring-indigo-500" />
                                <span>Remember this device</span>
                            </label>

                            @if (Route::has('register'))
                                <a class="text-sm font-medium text-indigo-600 hover:text-indigo-500" href="{{ route('register') }}">
                                    Create account
                                </a>
                            @endif
                        </div>

                        <button type="submit" class="btn-gradient w-full justify-center">
                            <i class="fa-solid fa-arrow-right-to-bracket"></i>
                            {{ __('Log in') }}
                        </button>
                    </form>

                    <p class="text-center text-xs text-gray-400 text-balance">
                        By continuing you agree to Zentara's
                        <a href="#" class="font-medium text-indigo-500 hover:text-indigo-400">Terms</a> and
                        <a href="#" class="font-medium text-indigo-500 hover:text-indigo-400">Privacy Policy</a>.
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
