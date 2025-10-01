<x-user-layout title="Products">
    <!-- Hero Section with Gradient Background -->
    <div class="relative bg-gradient-to-br from-slate-900 via-gray-900 to-black -mt-px">
        <div class="absolute inset-0 bg-black/20"></div>
        <div class="relative py-16 px-4 sm:py-20">
            <div class="content-wrapper text-center">
                <h1 class="text-3xl sm:text-5xl md:text-6xl font-light text-white mb-4 tracking-wider">
                    Our <span class="font-bold bg-gradient-to-r from-yellow-400 to-yellow-600 bg-clip-text text-transparent">Collection</span>
                </h1>
                <p class="text-xl text-gray-300 max-w-2xl mx-auto leading-relaxed">
                    Discover handcrafted excellence. Each piece tells a story of uncompromising quality and timeless design.
                </p>
            </div>
        </div>
    </div>

    <!-- Main Products Section -->
    <section class="py-16 bg-gray-50">
        <div class="content-wrapper space-y-12">
            <form method="GET" class="bg-white shadow-sm rounded-2xl p-6 md:p-8 border border-gray-100">
                <div class="grid gap-6 md:grid-cols-4">
                    <div>
                        <label for="min" class="block text-sm font-medium text-gray-700 mb-2">Price From (&pound;)</label>
                        <input
                            type="number"
                            id="min"
                            name="min"
                            min="0"
                            step="50"
                            value="{{ is_numeric($filters['min']) ? $filters['min'] : '' }}"
                            class="w-full px-3 py-3 bg-white border-2 border-gray-200 rounded-lg focus:border-yellow-500 focus:ring-yellow-500/20"
                        />
                    </div>
                    <div>
                        <label for="max" class="block text-sm font-medium text-gray-700 mb-2">Price To (&pound;)</label>
                        <input
                            type="number"
                            id="max"
                            name="max"
                            min="0"
                            step="50"
                            value="{{ is_numeric($filters['max']) ? $filters['max'] : '' }}"
                            class="w-full px-3 py-3 bg-white border-2 border-gray-200 rounded-lg focus:border-yellow-500 focus:ring-yellow-500/20"
                        />
                    </div>
                    <div>
                        <label for="sort" class="block text-sm font-medium text-gray-700 mb-2">Sort By</label>
                        <select
                            id="sort"
                            name="sort"
                            class="w-full px-3 py-3 bg-white border-2 border-gray-200 rounded-lg focus:border-yellow-500 focus:ring-yellow-500/20"
                        >
                            @foreach ($sortOptions as $value => $label)
                                <option value="{{ $value }}" @selected($filters['sort'] === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex flex-col justify-between gap-4">
                        <label class="inline-flex items-center gap-2 text-gray-700 mt-1">
                            <input
                                type="checkbox"
                                name="in_stock"
                                value="1"
                                @checked($filters['in_stock'])
                                class="rounded border-gray-300 text-yellow-500 focus:ring-yellow-500"
                            />
                            In stock only
                        </label>
                        <div class="flex gap-2 justify-end md:justify-start">
                            <button type="submit" class="inline-flex items-center justify-center px-4 py-2 rounded-lg bg-gray-900 text-white hover:bg-gray-800 transition-colors">
                                Apply
                            </button>
                            @if (! empty(request()->except('page')))
                                <a href="{{ route('products.index') }}" class="inline-flex items-center justify-center px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-100 transition-colors">
                                    Reset
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </form>

            @if ($products->count() === 0)
                <div class="text-center py-24">
                    <div class="max-w-md mx-auto">
                        <div class="w-24 h-24 mx-auto mb-6 bg-gray-200 rounded-full flex items-center justify-center">
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2M4 13h2m13-8l-4 4-4-4m2-3v6"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-semibold text-gray-900 mb-3">No Products Found</h3>
                        <p class="text-gray-600 leading-relaxed">We couldn't find any products matching your criteria. Try adjusting your filters or browse our full collection.</p>
                    </div>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                    @foreach ($products as $product)
                        <x-product-card :product="$product" />
                    @endforeach
                </div>
                <div class="mt-10">
                    {{ $products->links() }}
                </div>
            @endif
        </div>
    </section>

    <!-- Newsletter/CTA Section -->
    <section class="py-20 bg-gradient-to-r from-gray-900 to-black">
        <div class="max-w-4xl mx-auto text-center px-4">
            <h2 class="text-4xl font-light text-white mb-4">
                Stay in the <span class="font-bold bg-gradient-to-r from-yellow-400 to-yellow-600 bg-clip-text text-transparent">Loop</span>
            </h2>
            <p class="text-xl text-gray-300 mb-8 max-w-2xl mx-auto">
                Be the first to discover new arrivals, exclusive collections, and special offers from our luxury catalog.
            </p>
            <div class="max-w-md mx-auto flex gap-2">
                <input type="email" placeholder="Enter your email"
                    class="flex-1 px-6 py-4 rounded-xl border-0 focus:outline-none focus:ring-4 focus:ring-yellow-500/20" />
                <button
                    class="px-8 py-4 bg-gradient-to-r from-yellow-500 to-yellow-600 text-white rounded-xl font-medium hover:from-yellow-600 hover:to-yellow-700 transition-all duration-300 shadow-lg">
                    Subscribe
                </button>
            </div>
        </div>
    </section>
</x-user-layout>