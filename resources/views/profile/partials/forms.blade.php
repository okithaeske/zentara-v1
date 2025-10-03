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
