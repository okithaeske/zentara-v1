<x-user-layout title="Profile">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div>
        <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            <!-- Profile hero -->
            <div class="bg-white border border-gray-200 rounded-xl p-6 sm:p-8 mb-8">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6">
                    <div class="flex items-center gap-4">
                        <div class="relative">
                            <div class="p-1 rounded-full bg-gradient-to-br from-yellow-400 via-yellow-500 to-amber-600">
                                <img src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" class="h-16 w-16 sm:h-20 sm:w-20 rounded-full object-cover bg-black" />
                            </div>
                        </div>
                        <div>
                            <div class="text-xl sm:text-2xl font-semibold text-gray-900">{{ Auth::user()->name }}</div>
                            <div class="text-sm text-gray-600">{{ Auth::user()->email }}</div>
                            <div class="text-xs text-gray-500 mt-1">Member since {{ optional(Auth::user()->created_at)->format('M Y') }}</div>
                        </div>
                    </div>

                    <!-- Quick actions -->
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 w-full sm:w-auto">
                        <a href="#profile" class="inline-flex items-center justify-center px-4 py-2 rounded-lg bg-gray-100 text-gray-700 hover:text-gray-900 hover:bg-gray-200 transition">
                            <i class="fa-regular fa-user mr-2"></i> Profile
                        </a>
                        <a href="#security" class="inline-flex items-center justify-center px-4 py-2 rounded-lg bg-gray-100 text-gray-700 hover:text-gray-900 hover:bg-gray-200 transition">
                            <i class="fa-solid fa-lock mr-2"></i> Security
                        </a>
                        <a href="#sessions" class="inline-flex items-center justify-center px-4 py-2 rounded-lg bg-gray-100 text-gray-700 hover:text-gray-900 hover:bg-gray-200 transition col-span-2 sm:col-span-1">
                            <i class="fa-solid fa-laptop mr-2"></i> Sessions
                        </a>
                    </div>
                </div>
            </div>

            <!-- Local section nav -->
            <div class="flex gap-3 flex-wrap mb-6">
                <a href="#profile" class="px-3 py-1.5 rounded-md bg-gray-100 text-gray-700 hover:text-gray-900 hover:bg-gray-200 transition text-sm">Profile</a>
                <a href="#security" class="px-3 py-1.5 rounded-md bg-gray-100 text-gray-700 hover:text-gray-900 hover:bg-gray-200 transition text-sm">Password</a>
                @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
                    <a href="#twofactor" class="px-3 py-1.5 rounded-md bg-gray-100 text-gray-700 hover:text-gray-900 hover:bg-gray-200 transition text-sm">Two-Factor</a>
                @endif
                <a href="#sessions" class="px-3 py-1.5 rounded-md bg-gray-100 text-gray-700 hover:text-gray-900 hover:bg-gray-200 transition text-sm">Sessions</a>
                @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
                    <a href="#danger" class="px-3 py-1.5 rounded-md bg-red-50 text-red-700 hover:text-red-800 hover:bg-red-100 transition text-sm">Danger Zone</a>
                @endif
            </div>

            <!-- Sections -->
            <div id="profile"></div>
            @if (Laravel\Fortify\Features::canUpdateProfileInformation())
                @livewire('profile.update-profile-information-form')

                <x-user-section-border />
            @endif

            <div id="security"></div>
            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
                <div class="mt-10 sm:mt-0">
                    @livewire('profile.update-password-form')
                </div>

                <x-user-section-border />
            @endif

            <div id="twofactor"></div>
            @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
                <div class="mt-10 sm:mt-0">
                    @livewire('profile.two-factor-authentication-form')
                </div>

                <x-user-section-border />
            @endif

            <div id="sessions"></div>
            <div class="mt-10 sm:mt-0">
                @livewire('profile.logout-other-browser-sessions-form')
            </div>

            @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
                <x-user-section-border />

                <div id="danger"></div>
                <div class="mt-10 sm:mt-0">
                    @livewire('profile.delete-user-form')
                </div>
            @endif
        </div>
    </div>
</x-user-layout>
