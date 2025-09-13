<div class="space-y-4">
    <div class="flex items-center justify-between gap-3">
        <div>
            <h2 class="text-xl font-semibold text-yellow-200">Users</h2>
            <p class="text-sm text-gray-300">Manage users, roles, and bans</p>
        </div>
        <div class="flex items-center gap-2">
            <input type="search" wire:model.debounce.400ms="q" placeholder="Search users..." class="px-3 py-2 rounded bg-white/5 text-gray-100 placeholder-gray-400 border border-white/10" />
        </div>
    </div>

    <div class="glass rounded-xl border border-yellow-500/10 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="text-left text-gray-400">
                    <tr>
                        <th class="px-4 py-3">ID</th>
                        <th class="px-4 py-3">Name</th>
                        <th class="px-4 py-3">Email</th>
                        <th class="px-4 py-3">Role</th>
                        <th class="px-4 py-3">Banned</th>
                        <th class="px-4 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse ($users as $user)
                        <tr>
                            <td class="px-4 py-3 text-gray-300">{{ $user->id }}</td>
                            <td class="px-4 py-3 text-gray-100">{{ $user->name }}</td>
                            <td class="px-4 py-3 text-gray-300">{{ $user->email }}</td>
                            <td class="px-4 py-3 text-gray-300">{{ ucfirst($user->role) }}</td>
                            <td class="px-4 py-3">
                                <span class="px-2 py-1 text-xs rounded {{ $user->banned ? 'bg-red-500/20 text-red-300' : 'bg-white/10 text-gray-300' }}">{{ $user->banned ? 'Yes' : 'No' }}</span>
                            </td>
                            <td class="px-4 py-3 text-right space-x-2">
                                @if(auth()->id() !== $user->id)
                                    <button wire:click="toggleBan({{ $user->id }})" class="px-2 py-1 text-xs rounded {{ $user->banned ? 'bg-white/10 text-gray-200' : 'bg-yellow-500 text-gray-900' }}">{{ $user->banned ? 'Unban' : 'Ban' }}</button>
                                    <button wire:click="delete({{ $user->id }})" onclick="return confirm('Delete this user? This cannot be undone.')" class="px-2 py-1 text-xs rounded bg-red-600 text-white">Delete</button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-6 text-center text-gray-400">No users found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4">
            {{ $users->links() }}
        </div>
    </div>
</div>

