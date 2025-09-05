@extends('layouts.seller')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-yellow-200">Users</h1>
            <p class="text-sm text-gray-300">Manage users, roles, and bans</p>
        </div>
        <form method="GET" class="flex items-center gap-2">
            <input type="search" name="q" value="{{ request('q') }}" placeholder="Search users..." class="px-3 py-2 rounded bg-white/5 text-gray-100 placeholder-gray-400 border border-white/10" />
            <button class="px-3 py-2 rounded bg-white/10 text-sm text-gray-100">Search</button>
        </form>
    </div>

    @if (session('status'))
        <div class="p-3 rounded bg-green-50 text-green-800">{{ session('status') }}</div>
    @endif

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
                    @foreach ($users as $user)
                        <tr>
                            <td class="px-4 py-3 text-gray-300">{{ $user->id }}</td>
                            <td class="px-4 py-3 text-gray-100">{{ $user->name }}</td>
                            <td class="px-4 py-3 text-gray-300">{{ $user->email }}</td>
                            <td class="px-4 py-3 text-gray-300">{{ ucfirst($user->role) }}</td>
                            <td class="px-4 py-3">
                                <span class="px-2 py-1 text-xs rounded {{ $user->banned ? 'bg-red-500/20 text-red-300' : 'bg-white/10 text-gray-300' }}">{{ $user->banned ? 'Yes' : 'No' }}</span>
                            </td>
                            <td class="px-4 py-3 text-right">
                                @if(auth()->id() !== $user->id)
                                    <form method="POST" action="{{ route('admin.users.toggle-ban', $user) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button class="px-2 py-1 text-xs rounded {{ $user->banned ? 'bg-white/10 text-gray-200' : 'bg-yellow-500 text-gray-900' }}">{{ $user->banned ? 'Unban' : 'Ban' }}</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="p-4">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection

