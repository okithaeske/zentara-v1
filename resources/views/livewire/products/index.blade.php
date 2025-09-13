<div>
    <div class="mb-12">
        <div class="max-w-2xl mx-auto">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <input type="search" wire:model.debounce.400ms="q" placeholder="Search for luxury products..." class="w-full pl-12 pr-4 py-4 text-lg bg-white border-2 border-gray-200 rounded-full shadow-sm focus:border-yellow-500 focus:ring-2 focus:ring-yellow-500/20 focus:outline-none transition-all duration-300" />
            </div>
        </div>
    </div>

    @if ($products->count() === 0)
        <div class="text-center py-24">
            <div class="max-w-md mx-auto">
                <div class="w-24 h-24 mx-auto mb-6 bg-gray-200 rounded-full flex items-center justify-center">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2M4 13h2m13-8l-4 4-4-4m2-3v6"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-semibold text-gray-900 mb-3">No Products Found</h3>
                <p class="text-gray-600 leading-relaxed">We couldn't find any products matching your criteria. Try adjusting your search or browse our full collection.</p>
            </div>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-16">
            @foreach ($products as $product)
                <a href="{{ route('products.show', $product) }}" class="group relative bg-white rounded-xl shadow-sm hover:shadow-2xl border border-gray-100 overflow-hidden transition-all duration-500 hover:-translate-y-1">
                    <div class="relative aspect-square bg-gradient-to-br from-gray-50 to-gray-100 overflow-hidden">
                        @if ($product->image_path)
                            <img src="{{ Storage::url($product->image_path) }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" />
                        @else
                            <div class="w-full h-full flex flex-col items-center justify-center text-gray-400">
                                <svg class="w-12 h-12 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <span class="text-xs">No image</span>
                            </div>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/0 to-black/0 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    </div>
                    <div class="p-4">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="font-semibold text-gray-900 truncate">{{ $product->name }}</h3>
                            <span class="text-gray-900 font-semibold">${{ number_format($product->price, 2) }}</span>
                        </div>
                        <div class="text-sm text-gray-500">SKU: {{ $product->sku }}</div>
                    </div>
                </a>
            @endforeach
        </div>
        <div>
            {{ $products->links() }}
        </div>
    @endif
</div>

