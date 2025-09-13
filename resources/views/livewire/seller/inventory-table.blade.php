<div class="glass rounded-xl border border-yellow-500/10 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="text-left text-gray-400">
                <tr>
                    <th class="px-4 py-3">Product</th>
                    <th class="px-4 py-3">SKU</th>
                    <th class="px-4 py-3">Stock</th>
                    <th class="px-4 py-3">Price</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @forelse ($products as $product)
                    <tr>
                        <td class="px-4 py-3 text-gray-100">{{ $product->name }}</td>
                        <td class="px-4 py-3 text-gray-300">{{ $product->sku }}</td>
                        <td class="px-4 py-3 text-gray-300">
                            <span class="px-2 py-1 rounded text-xs @if($product->stock <= $lowStockThreshold) bg-red-500/20 text-red-300 @else bg-white/10 text-gray-300 @endif">
                                {{ $product->stock }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-gray-300">${{ number_format($product->price, 2) }}</td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-1 text-xs rounded bg-white/10 text-gray-300">{{ ucfirst($product->status) }}</span>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <a href="{{ route('seller.products.edit', $product) }}" class="px-2 py-1 text-xs rounded bg-yellow-500 text-gray-900">Edit</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-6 text-center text-gray-400">No products found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-4">
        {{ $products->links() }}
    </div>
</div>

