<nav x-data="{ open: false }" class="bg-black/95 backdrop-blur-sm border-b border-yellow-500/20 text-white shadow-lg relative z-[70]">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">
            <div class="flex items-center">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}" aria-label="Home" class="flex items-center gap-3 group">
                        <!-- Watch Icon -->
                        <div class="w-8 h-8 rounded-full bg-yellow-500 flex items-center justify-center shadow-md group-hover:shadow-lg transition-shadow duration-300">
                            <svg class="w-5 h-5 text-gray-900" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm0-14c-3.31 0-6 2.69-6 6s2.69 6 6 6 6-2.69 6-6-2.69-6-6-6zm3 8h-4V8h2v4h2v2z"/>
                            </svg>
                        </div>
                        <span class="text-yellow-500 text-base sm:text-xl font-bold group-hover:text-yellow-400 transition-colors duration-300">{{ config('app.name', 'Zentara') }}</span>
                    </a>
                </div>

                <!-- Public Site Links -->
                <div class="hidden space-x-8 sm:flex sm:ml-16">
                    <x-user-nav-link href="{{ route('home') }}" :active="request()->routeIs('home')" 
                        class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-300 hover:text-yellow-400 transition-colors duration-300">
                        {{ __('Home') }}
                    </x-user-nav-link>
                    <x-user-nav-link href="{{ route('about') }}" :active="request()->routeIs('about')"
                        class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-300 hover:text-yellow-400 transition-colors duration-300">
                        {{ __('About') }}
                    </x-user-nav-link>
                    <x-user-nav-link href="{{ route('contact') }}" :active="request()->routeIs('contact')"
                        class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-300 hover:text-yellow-400 transition-colors duration-300">
                        {{ __('Contact') }}
                    </x-user-nav-link>
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ml-6 space-x-4">
                <!-- Search Icon -->
                <button class="p-2 text-gray-300 hover:text-yellow-400 hover:bg-gray-800 rounded-lg transition-all duration-200" aria-label="Search">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </button>

                <!-- Cart Icon -->
                <button class="p-2 text-gray-300 hover:text-yellow-400 hover:bg-gray-800 rounded-lg transition-all duration-200 relative" aria-label="Shopping Cart">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13v6a2 2 0 002 2h6a2 2 0 002-2v-6m-8 0V9a2 2 0 012-2h4a2 2 0 012 2v4"/>
                    </svg>
                    <span class="absolute -top-1 -right-1 bg-yellow-500 text-gray-900 text-xs rounded-full h-4 w-4 flex items-center justify-center font-bold">3</span>
                </button>

                @auth
                    <!-- Teams Dropdown -->
                    @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                        <div class="ml-3 relative">
                            <x-dropdown align="right" width="60" contentClasses="p-0 bg-transparent">
                                <x-slot name="trigger">
                                    <span class="inline-flex rounded-md">
                                        <button type="button"
                                            class="inline-flex items-center px-4 py-2 border border-gray-600 text-sm leading-4 font-medium rounded-lg text-gray-300 bg-gray-800 hover:text-yellow-400 hover:border-yellow-500 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-yellow-500 transition-all duration-200">
                                            {{ Auth::user()->currentTeam->name }}

                                            <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                                            </svg>
                                        </button>
                                    </span>
                                </x-slot>

                                <x-slot name="content">
                                    <div class="w-60 bg-gray-800 border border-gray-600 rounded-lg shadow-xl">
                                        <div class="block px-4 py-2 text-xs text-gray-200 font-semibold">
                                            {{ __('Manage Team') }}
                                        </div>

                                        <x-user-dropdown-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}"
                                            class="text-gray-200 hover:text-yellow-400 hover:bg-gray-700">
                                            {{ __('Team Settings') }}
                                        </x-user-dropdown-link>

                                        @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                                            <x-user-dropdown-link href="{{ route('teams.create') }}"
                                                class="text-gray-200 hover:text-yellow-400 hover:bg-gray-700">
                                                {{ __('Create New Team') }}
                                            </x-user-dropdown-link>
                                        @endcan

                                        @if (Auth::user()->allTeams()->count() > 1)
                                            <div class="border-t border-gray-600"></div>
                                            <div class="block px-4 py-2 text-xs text-gray-200 font-semibold">
                                                {{ __('Switch Teams') }}
                                            </div>
                                            @foreach (Auth::user()->allTeams() as $team)
                                                <x-switchable-team :team="$team" />
                                            @endforeach
                                        @endif
                                    </div>
                                </x-slot>
                            </x-dropdown>
                        </div>
                    @endif

                    <!-- Settings Dropdown -->
                    <div class="ml-3 relative">
                        <x-dropdown align="right" width="48" contentClasses="p-0 bg-transparent">
                            <x-slot name="trigger">
                                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                    <button
                                        class="flex text-sm border-2 border-gray-200 rounded-full focus:outline-none focus:border-gray-200 hover:border-yellow-500 transition-colors duration-200 shadow-md"
                                        aria-label="Account menu">
                                        <img class="h-9 w-9 rounded-full object-cover"
                                            src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                                    </button>
                                @else
                                    <span class="inline-flex rounded-md">
                                        <button type="button"
                                            class="inline-flex items-center px-4 py-2 border border-gray-600 text-sm leading-4 font-medium rounded-lg text-gray-300 bg-gray-800 hover:text-yellow-400 hover:border-yellow-500 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-yellow-500 transition-all duration-200">
                                            {{ Auth::user()->name }}

                                            <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                                            </svg>
                                        </button>
                                    </span>
                                @endif
                            </x-slot>

                            <x-slot name="content">
                                <div class="bg-gray-800 border border-gray-600 rounded-lg shadow-xl">
                                    <!-- Account Management -->
                                    <div class="block px-4 py-2 text-xs text-gray-200 font-semibold">
                                        {{ __('Manage Account') }}
                                    </div>

                                    <x-user-dropdown-link href="{{ route('profile.show') }}"
                                        class="text-gray-200 hover:text-yellow-400 hover:bg-gray-700">
                                        {{ __('Profile') }}
                                    </x-user-dropdown-link>

                                    @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                                        <x-user-dropdown-link href="{{ route('api-tokens.index') }}"
                                            class="text-gray-200 hover:text-yellow-400 hover:bg-gray-700">
                                            {{ __('API Tokens') }}
                                        </x-user-dropdown-link>
                                    @endif

                                    <div class="border-t border-gray-600"></div>

                                    <!-- Authentication -->
                                    <form method="POST" action="{{ route('logout') }}" x-data>
                                        @csrf
                                        <x-user-dropdown-link href="{{ route('logout') }}" @click.prevent="$root.submit();"
                                            class="text-gray-400 hover:text-red-400 hover:bg-red-900">
                                            {{ __('Log Out') }}
                                        </x-user-dropdown-link>
                                    </form>
                                </div>
                            </x-slot>
                        </x-dropdown>
                    </div>
                @else
                    <!-- Guest Links -->
                    <div class="space-x-4">
                        <a href="{{ route('login') }}"
                            class="text-sm text-gray-300 hover:text-yellow-400 transition-colors duration-200">{{ __('Log in') }}</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                                class="px-4 py-2 text-sm font-medium bg-yellow-500 text-gray-900 rounded-lg hover:bg-yellow-500 transition-colors duration-200 shadow-md">{{ __('Register') }}</a>
                        @endif
                    </div>
                @endauth
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-lg text-gray-300 hover:text-yellow-400 hover:bg-gray-800 focus:outline-none focus:bg-gray-800 focus:text-gray-200 transition-all duration-200"
                    aria-label="Toggle navigation">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-black/95 backdrop-blur-sm border-t border-yellow-500/20">
        <div class="pt-2 pb-3 space-y-1">
            <x-user-responsive-nav-link href="{{ route('home') }}" :active="request()->routeIs('home')"
                class="block pl-6 pr-4 py-3 border-l-4 border-transparent text-base font-medium text-gray-300 hover:text-yellow-400 hover:border-yellow-500 hover:bg-gray-800 transition-all duration-200">
                {{ __('Home') }}
            </x-user-responsive-nav-link>
            <x-user-responsive-nav-link href="{{ route('about') }}" :active="request()->routeIs('about')"
                class="block pl-6 pr-4 py-3 border-l-4 border-transparent text-base font-medium text-gray-300 hover:text-yellow-400 hover:border-yellow-500 hover:bg-gray-800 transition-all duration-200">
                {{ __('About') }}
            </x-user-responsive-nav-link>
            <x-user-responsive-nav-link href="{{ route('contact') }}" :active="request()->routeIs('contact')"
                class="block pl-6 pr-4 py-3 border-l-4 border-transparent text-base font-medium text-gray-300 hover:text-yellow-400 hover:border-yellow-500 hover:bg-gray-800 transition-all duration-200">
                {{ __('Contact') }}
            </x-user-responsive-nav-link>
        </div>

        @auth
            <!-- Responsive Settings Options -->
            <div class="pt-4 pb-1 border-t border-yellow-500/20">
                <div class="flex items-center px-4">
                    @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                        <div class="shrink-0 mr-3">
                            <img class="h-10 w-10 rounded-full object-cover border-2 border-gray-200" src="{{ Auth::user()->profile_photo_url }}"
                                alt="{{ Auth::user()->name }}" />
                        </div>
                    @endif

                    <div>
                        <div class="font-medium text-base text-white">{{ Auth::user()->name }}</div>
                        <div class="font-medium text-sm text-gray-400">{{ Auth::user()->email }}</div>
                    </div>
                </div>

                <div class="mt-3 space-y-1">
                    <x-user-responsive-nav-link href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')"
                        class="block pl-6 pr-4 py-3 text-base font-medium text-gray-300 hover:text-yellow-400 hover:bg-gray-800 transition-all duration-200">
                        {{ __('Profile') }}
                    </x-user-responsive-nav-link>

                    @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                        <x-user-responsive-nav-link href="{{ route('api-tokens.index') }}"
                            :active="request()->routeIs('api-tokens.index')"
                            class="block pl-6 pr-4 py-3 text-base font-medium text-gray-300 hover:text-yellow-400 hover:bg-gray-800 transition-all duration-200">
                            {{ __('API Tokens') }}
                        </x-user-responsive-nav-link>
                    @endif

                    <form method="POST" action="{{ route('logout') }}" x-data>
                        @csrf
                        <x-user-responsive-nav-link href="{{ route('logout') }}" @click.prevent="$root.submit();"
                            class="block pl-6 pr-4 py-3 text-base font-medium text-gray-400 hover:text-red-400 hover:bg-red-900 transition-all duration-200">
                            {{ __('Log Out') }}
                        </x-user-responsive-nav-link>
                    </form>

                    @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                        <div class="border-t border-yellow-500/20"></div>
                        <div class="block px-4 py-2 text-xs text-gray-200 font-semibold">
                            {{ __('Manage Team') }}
                        </div>
                        <x-user-responsive-nav-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}"
                            :active="request()->routeIs('teams.show')"
                            class="block pl-6 pr-4 py-3 text-base font-medium text-gray-300 hover:text-yellow-400 hover:bg-gray-800 transition-all duration-200">
                            {{ __('Team Settings') }}
                        </x-user-responsive-nav-link>
                        @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                            <x-user-responsive-nav-link href="{{ route('teams.create') }}" :active="request()->routeIs('teams.create')"
                                class="block pl-6 pr-4 py-3 text-base font-medium text-gray-300 hover:text-yellow-400 hover:bg-gray-800 transition-all duration-200">
                                {{ __('Create New Team') }}
                            </x-user-responsive-nav-link>
                        @endcan
                        @if (Auth::user()->allTeams()->count() > 1)
                            <div class="border-t border-yellow-500/20"></div>
                            <div class="block px-4 py-2 text-xs text-gray-200 font-semibold">
                                {{ __('Switch Teams') }}
                            </div>
                            @foreach (Auth::user()->allTeams() as $team)
                                <x-switchable-team :team="$team" component="user-responsive-nav-link" />
                            @endforeach
                        @endif
                    @endif
                </div>
            </div>
        @else
            <div class="pt-2 pb-3 border-t border-yellow-500/20 space-y-1">
                <x-user-responsive-nav-link href="{{ route('login') }}" :active="request()->routeIs('login')"
                    class="block pl-6 pr-4 py-3 text-base font-medium text-gray-300 hover:text-yellow-400 hover:bg-gray-800 transition-all duration-200">
                    {{ __('Log in') }}
                </x-user-responsive-nav-link>
                @if (Route::has('register'))
                    <x-user-responsive-nav-link href="{{ route('register') }}" :active="request()->routeIs('register')"
                        class="block mx-4 my-2 px-4 py-3 text-base font-medium bg-yellow-500 text-gray-900 rounded-lg hover:bg-yellow-500 transition-colors duration-200 text-center">
                        {{ __('Register') }}
                    </x-user-responsive-nav-link>
                @endif
            </div>
        @endauth
    </div>
</nav>


