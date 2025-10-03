@php($user = $user ?? auth()->user())
@php($roleLabel = $roleLabel ?? ucfirst($user->role ?? ''))

<div class="glass rounded-xl border border-yellow-500/10 p-6 sm:p-8 flex flex-col gap-6 sm:flex-row sm:items-center sm:justify-between">
    <div class="flex items-center gap-4">
        <div class="p-1 rounded-full bg-gradient-to-br from-yellow-400 via-yellow-500 to-amber-600">
            <img src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}" class="h-16 w-16 sm:h-20 sm:w-20 rounded-full object-cover bg-black" />
        </div>
        <div>
            <div class="text-xl sm:text-2xl font-semibold text-white">{{ $user->name }}</div>
            <div class="text-sm text-gray-300">{{ $user->email }}</div>
            <div class="text-xs text-gray-400 mt-1">Member since {{ optional($user->created_at)->format('M Y') }}</div>
        </div>
    </div>

    <div class="w-full sm:w-auto grid grid-cols-2 sm:grid-cols-3 gap-4 text-sm text-gray-200">
        <div>
            <div class="text-xs uppercase tracking-wide text-gray-400">Role</div>
            <div class="font-semibold text-yellow-200">{{ $roleLabel }}</div>
        </div>
        <div>
            <div class="text-xs uppercase tracking-wide text-gray-400">Email Verified</div>
            <div>{{ $user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && $user->hasVerifiedEmail() ? 'Yes' : 'Pending' }}</div>
        </div>
        <div class="col-span-2 sm:col-span-1">
            <div class="text-xs uppercase tracking-wide text-gray-400">Last Updated</div>
            <div>{{ optional($user->updated_at)->diffForHumans(null, true) ?? '—' }}</div>
        </div>
    </div>
</div>
