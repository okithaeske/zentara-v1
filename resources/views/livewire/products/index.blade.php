<div>
    <div class="mb-6">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                <div class="md:col-span-2">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input type="search" wire:model.debounce.400ms="q" placeholder="Search for luxury products..." class="w-full pl-12 pr-4 py-3 bg-white border-2 border-gray-200 rounded-lg shadow-sm focus:border-yellow-500 focus:ring-2 focus:ring-yellow-500/20 focus:outline-none transition-all duration-300" />
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <input type="number" min="0" wire:model.lazy="min" placeholder="Min" class="w-full px-3 py-3 bg-white border-2 border-gray-200 rounded-lg">
                    <input type="number" min="0" wire:model.lazy="max" placeholder="Max" class="w-full px-3 py-3 bg-white border-2 border-gray-200 rounded-lg">
                </div>
                <div class="flex items-center gap-3 justify-between">
                    <label class="inline-flex items-center gap-2 text-gray-700">
                        <input type="checkbox" wire:model="inStock" class="rounded border-gray-300"> In stock
                    </label>
                    <select wire:model="sort" class="px-3 py-3 bg-white border-2 border-gray-200 rounded-lg">
                        <option value="newest">Newest</option>
                        <option value="price_asc">Price: Low to High</option>
                        <option value="price_desc">Price: High to Low</option>
                    </select>
                </div>
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
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8 mb-16">
            @foreach ($products as $product)
                <x-product-card :product="$product" />
            @endforeach
        </div>
        <div>
            {{ $products->links() }}
        </div>
    @endif
</div>
