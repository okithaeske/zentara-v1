<x-guest-layout>
    <div class="min-h-screen bg-luxury-gradient flex items-center py-12 sm:py-16">
        <div class="content-wrapper grid grid-cols-1 gap-8 lg:grid-cols-2 lg:gap-12">
            <div class="hidden lg:flex flex-col justify-between glass-effect rounded-[32px] p-12 border border-white/10">
                <div class="space-y-6">
                    <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/10 text-xs font-semibold uppercase tracking-[0.35em] text-white/80">
                        <i class="fa-solid fa-user-plus text-yellow-400"></i>
                        Join Zentara
                    </span>
                    <h1 class="text-3xl sm:text-4xl xl:text-5xl font-display leading-tight text-luxury-gold">
                        Craft your signature investment profile
                    </h1>
                    <p class="text-base leading-relaxed text-white/70 max-w-xl text-balance">
                        Create a Zentara account to unlock bespoke market briefings, early access to private listings, and white-glove advisory tailored to your goals.
                    </p>
                </div>
                <ul class="mt-12 space-y-8 text-white/70">
                    <li class="flex gap-4">
                        <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-white/10 text-yellow-400">
                            <i class="fa-solid fa-crown"></i>
                        </span>
                        <div class="space-y-1">
                            <h3 class="text-lg font-semibold text-white">Exclusive network</h3>
                            <p class="text-sm leading-relaxed text-white/60">Connect with industry leaders and curated private investment circles.</p>
                        </div>
                    </li>
                    <li class="flex gap-4">
                        <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-white/10 text-yellow-400">
                            <i class="fa-solid fa-vault"></i>
                        </span>
                        <div class="space-y-1">
                            <h3 class="text-lg font-semibold text-white">Vault-grade data</h3>
                            <p class="text-sm leading-relaxed text-white/60">Secure insights, on-demand reports, and AI-guided portfolio optimisation.</p>
                        </div>
                    </li>
                    <li class="flex gap-4">
                        <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-white/10 text-yellow-400">
                            <i class="fa-solid fa-handshake"></i>
                        </span>
                        <div class="space-y-1">
                            <h3 class="text-lg font-semibold text-white">Concierge onboarding</h3>
                            <p class="text-sm leading-relaxed text-white/60">Dedicated specialists ensure a seamless start from day one.</p>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="w-full">
                <div class="bg-white/95 backdrop-blur-sm text-gray-900 rounded-[32px] shadow-2xl p-6 sm:p-10 space-y-8">
                    <div class="space-y-2 text-balance">
                        <h2 class="text-2xl sm:text-3xl font-semibold tracking-tight text-gray-900">Create your Zentara account</h2>
                        <p class="text-sm text-gray-500 leading-relaxed">Share a few details to build your personalised investment environment.</p>
                    </div>

                    <x-validation-errors class="rounded-2xl border border-red-100 bg-red-50/80 px-5 py-4 text-sm text-red-600" />

                    <form method="POST" action="{{ route('register') }}" class="space-y-6">
                        @csrf

                        <div class="space-y-2">
                            <label for="name" class="text-sm font-medium text-gray-700">Full name</label>
                            <div class="relative">
                                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                                    <i class="fa-solid fa-user"></i>
                                </span>
                                <x-input id="name"
                                         class="block w-full rounded-2xl border-gray-200 bg-white py-3 pl-12 pr-4 text-base text-gray-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                         type="text"
                                         name="name"
                                         :value="old('name')"
                                         required
                                         autofocus
                                         autocomplete="name"
                                         placeholder="Your full name" />
                            </div>
                        </div>

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
                                         autocomplete="username"
                                         placeholder="you@zentara.com" />
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label for="role" class="text-sm font-medium text-gray-700">Role</label>
                            <div class="relative">
                                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                                    <i class="fa-solid fa-briefcase"></i>
                                </span>
                                <select id="role" name="role" required
                                        class="block w-full appearance-none rounded-2xl border border-gray-200 bg-white py-3 pl-12 pr-12 text-base text-gray-900 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200">
                                    <option value="user" {{ old('role') === 'user' ? 'selected' : '' }}>User</option>
                                    <option value="seller" {{ old('role') === 'seller' ? 'selected' : '' }}>Seller</option>
                                </select>
                                <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-4 text-gray-400">
                                    <i class="fa-solid fa-chevron-down"></i>
                                </span>
                            </div>
                            @error('role')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-2">
                            <label for="password" class="text-sm font-medium text-gray-700">Password</label>
                            <div class="relative">
                                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                                    <i class="fa-solid fa-lock"></i>
                                </span>
                                <x-input id="password"
                                         class="block w-full rounded-2xl border-gray-200 bg-white py-3 pl-12 pr-4 text-base text-gray-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                         type="password"
                                         name="password"
                                         required
                                         autocomplete="new-password"
                                         placeholder="Create a strong password" />
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label for="password_confirmation" class="text-sm font-medium text-gray-700">Confirm password</label>
                            <div class="relative">
                                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                                    <i class="fa-solid fa-shield-check"></i>
                                </span>
                                <x-input id="password_confirmation"
                                         class="block w-full rounded-2xl border-gray-200 bg-white py-3 pl-12 pr-4 text-base text-gray-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                         type="password"
                                         name="password_confirmation"
                                         required
                                         autocomplete="new-password"
                                         placeholder="Re-enter your password" />
                            </div>
                        </div>

                        @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                            <div class="rounded-2xl border border-gray-200 bg-gray-50/90 px-5 py-4 text-sm text-gray-600 space-y-3">
                                <label for="terms" class="flex items-start gap-3">
                                    <x-checkbox id="terms" name="terms" required class="mt-0.5 rounded-md text-indigo-600 focus:ring-indigo-500" />
                                    <span class="text-sm leading-relaxed text-balance">
                                        {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                            'terms_of_service' => '<a target="_blank" href="' . route('terms.show') . '" class="font-medium text-indigo-600 hover:text-indigo-500">' . __('Terms of Service') . '</a>',
                                            'privacy_policy' => '<a target="_blank" href="' . route('policy.show') . '" class="font-medium text-indigo-600 hover:text-indigo-500">' . __('Privacy Policy') . '</a>',
                                        ]) !!}
                                    </span>
                                </label>
                            </div>
                        @endif

                        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                            <a class="text-sm font-medium text-indigo-600 hover:text-indigo-500" href="{{ route('login') }}">
                                {{ __('Already registered?') }}
                            </a>

                            <button type="submit" class="btn-gradient w-full sm:w-auto justify-center">
                                <i class="fa-solid fa-user-check"></i>
                                {{ __('Register') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
