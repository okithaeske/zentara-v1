<div class="space-y-4">
    <div class="flex items-center justify-between gap-3">
        <div>
            <h2 class="text-xl font-semibold text-yellow-200">Sellers</h2>
            <p class="text-sm text-gray-300">Browse sellers and view their products</p>
        </div>
        <input type="search" wire:model.debounce.400ms="q" placeholder="Search sellers..." class="px-3 py-2 rounded bg-white/5 text-gray-100 placeholder-gray-400 border border-white/10" />
    </div>

    <div class="glass rounded-xl border border-yellow-500/10 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="text-left text-gray-400">
                    <tr>
                        <th class="px-4 py-3">Name</th>
                        <th class="px-4 py-3">Email</th>
                        <th class="px-4 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse ($sellers as $seller)
                        <tr>
                            <td class="px-4 py-3 text-gray-100">{{ $seller->name }}</td>
                            <td class="px-4 py-3 text-gray-300">{{ $seller->email }}</td>
                            <td class="px-4 py-3 text-right">
                                <a href="{{ route('admin.sellers.products', $seller) }}" class="px-2 py-1 text-xs rounded bg-white/10">View Products</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-4 py-6 text-center text-gray-400">No sellers found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4">
            {{ $sellers->links() }}
        </div>
    </div>
</div>

