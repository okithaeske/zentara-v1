<div class="glass rounded-xl border border-yellow-500/10 overflow-hidden">
    <div class="p-4 border-b border-white/5 flex items-center gap-3">
        <input wire:model.debounce.400ms="q" type="text" placeholder="Search products (name or SKU)..." class="w-full px-3 py-2 rounded bg-white/5 text-gray-100 placeholder-gray-400 border border-white/10" />
        <select wire:model="status" class="px-3 py-2 rounded bg-white/5 text-gray-100 border border-white/10">
            <option value="">All Statuses</option>
            <option value="draft">Draft</option>
            <option value="published">Published</option>
        </select>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="text-left text-gray-400">
                <tr>
                    <th class="px-4 py-3">Image</th>
                    <th class="px-4 py-3">Product</th>
                    <th class="px-4 py-3">SKU</th>
                    <th class="px-4 py-3">Price</th>
                    <th class="px-4 py-3">Stock</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @forelse($products as $product)
                    <tr>
                        <td class="px-4 py-3">
                            @if ($product->image_path)
                                <img src="{{ Storage::url($product->image_path) }}" alt="{{ $product->name }}" class="h-10 w-10 rounded object-cover border border-white/10" />
                            @else
                                <div class="h-10 w-10 rounded bg-white/5 border border-white/10"></div>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-gray-300">{{ $product->name }}</td>
                        <td class="px-4 py-3 text-gray-300">{{ $product->sku }}</td>
                        <td class="px-4 py-3 text-gray-300">${{ number_format($product->price, 2) }}</td>
                        <td class="px-4 py-3 text-gray-300">{{ $product->stock }}</td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-1 text-xs rounded bg-white/10 text-gray-300">{{ ucfirst($product->status) }}</span>
                        </td>
                        <td class="px-4 py-3 space-x-2">
                            <a href="{{ route('seller.products.edit', $product) }}" class="px-2 py-1 text-xs rounded bg-white/10">Edit</a>
                            <button wire:click="delete({{ $product->id }})" onclick="return confirm('Delete this product?')" class="px-2 py-1 text-xs rounded bg-white/10">Delete</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-6 text-center text-gray-400">No products yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-4 border-t border-white/5">
        {{ $products->links() }}
    </div>
</div>

