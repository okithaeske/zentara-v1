<x-user-layout title="Products">     
    <!-- Hero Section with Gradient Background -->
    <div class="relative bg-gradient-to-br from-slate-900 via-gray-900 to-black">
        <div class="absolute inset-0 bg-black/20"></div>
        <div class="relative py-20 px-4">
            <div class="max-w-7xl mx-auto text-center">
                <h1 class="text-5xl md:text-6xl font-light text-white mb-4 tracking-wider">
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
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Search and Filter Bar -->
            <div class="mb-12">
                <form method="GET" action="{{ route('products.index') }}" class="max-w-2xl mx-auto">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input type="search" 
                               name="q" 
                               value="{{ request('q') }}" 
                               placeholder="Search for luxury products..."
                               class="w-full pl-12 pr-20 py-4 text-lg bg-white border-2 border-gray-200 rounded-full shadow-sm focus:border-yellow-500 focus:ring-2 focus:ring-yellow-500/20 focus:outline-none transition-all duration-300" />
                        <button class="absolute right-2 top-2 px-6 py-2 bg-gradient-to-r from-gray-900 to-black text-white rounded-full hover:from-black hover:to-gray-900 transition-all duration-300 shadow-lg">
                            Search
                        </button>
                    </div>
                </form>
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
                <!-- Products Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-16">
                    @foreach ($products as $product)
                        <div class="group relative bg-white rounded-xl shadow-sm hover:shadow-2xl border border-gray-100 overflow-hidden transition-all duration-500 hover:-translate-y-1">
                            
                            <!-- Product Image -->
                            <div class="relative aspect-square bg-gradient-to-br from-gray-50 to-gray-100 overflow-hidden">
                                @if ($product->image_path)
                                    <img src="{{ Storage::url($product->image_path) }}" 
                                         alt="{{ $product->name }}" 
                                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" />
                                @else
                                    <div class="w-full h-full flex flex-col items-center justify-center text-gray-400">
                                        <svg class="w-12 h-12 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <span class="text-xs font-medium">No image</span>
                                    </div>
                                @endif
                                
                                <!-- Overlay with Quick View -->
                                <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                                    <a href="{{ route('products.show', $product->id) }}" 
                                       class="px-4 py-2 bg-white text-gray-900 rounded-full text-sm font-medium hover:bg-gray-100 transition-colors duration-200 transform scale-95 group-hover:scale-100">
                                        Quick View
                                    </a>
                                </div>
                            </div>
                            
                            <!-- Product Details -->
                            <div class="p-4 space-y-3">
                                <div class="space-y-1">
                                    <a href="{{ route('products.show', $product->id) }}" class="block group/link">
                                        <h3 class="text-lg font-semibold text-gray-900 group-hover/link:text-yellow-600 transition-colors duration-200 leading-tight line-clamp-2">
                                            {{ $product->name }}
                                        </h3>
                                    </a>
                                    <p class="text-xs text-gray-500 uppercase tracking-wide font-medium">
                                        SKU: {{ $product->sku }}
                                    </p>
                                </div>
                                
                                <!-- Price -->
                                <div class="flex items-center justify-between pt-1">
                                    <span class="text-xl font-bold text-gray-900">
                                        ${{ number_format($product->price, 2) }}
                                    </span>
                                    @if($product->original_price && $product->original_price > $product->price)
                                        <span class="text-sm text-gray-400 line-through">
                                            ${{ number_format($product->original_price, 2) }}
                                        </span>
                                    @endif
                                </div>
                                
                                <!-- Add to Cart Button -->
                                <form method="POST" action="{{ route('cart.add', $product->id) }}" class="pt-1">
                                    @csrf
                                    <input type="hidden" name="qty" value="1">
                                    <button class="w-full px-4 py-2.5 bg-gradient-to-r from-gray-900 to-black text-white text-sm rounded-lg font-medium hover:from-black hover:to-gray-900 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 focus:outline-none focus:ring-4 focus:ring-gray-900/20">
                                        <span class="flex items-center justify-center space-x-1.5">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M17 13v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6"></path>
                                            </svg>
                                            <span>Add to Cart</span>
                                        </span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <!-- Enhanced Pagination -->
                <div class="flex justify-center">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-2">
                        {{ $products->links() }}
                    </div>
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
                <input type="email" placeholder="Enter your email" class="flex-1 px-6 py-4 rounded-xl border-0 focus:outline-none focus:ring-4 focus:ring-yellow-500/20" />
                <button class="px-8 py-4 bg-gradient-to-r from-yellow-500 to-yellow-600 text-white rounded-xl font-medium hover:from-yellow-600 hover:to-yellow-700 transition-all duration-300 shadow-lg">
                    Subscribe
                </button>
            </div>
        </div>
    </section>
</x-user-layout>