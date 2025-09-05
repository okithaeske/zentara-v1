<x-user-layout title="Products">
    <section class="py-12 bg-white text-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4 mb-8">
                <div>
                    <h1 class="text-3xl font-bold">Our Collection</h1>
                    <p class="text-gray-600">Browse our latest published products.</p>
                </div>
                <form method="GET" action="{{ route('products.index') }}" class="w-full sm:w-auto">
                    <div class="flex gap-2">
                        <input type="search" name="q" value="{{ request('q') }}" placeholder="Search products..."
                            class="w-full sm:w-64 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:outline-none" />
                        <button class="px-4 py-2 bg-gray-900 text-white rounded-lg hover:bg-gray-800">Search</button>
                    </div>
                </form>
            </div>

            @if ($products->count() === 0)
                <div class="text-center py-16">
                    <p class="text-gray-600">No products found.</p>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($products as $product)
                        <a href="{{ route('products.show', $product->id) }}" class="group bg-white rounded-xl shadow hover:shadow-lg border border-gray-100 overflow-hidden transition">
                            <div class="aspect-square bg-gray-100 overflow-hidden">
                                @if ($product->image_path)
                                    <img src="{{ Storage::url($product->image_path) }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition" />
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-400">No image</div>
                                @endif
                            </div>
                            <div class="p-4">
                                <h3 class="text-lg font-semibold text-gray-900 truncate">{{ $product->name }}</h3>
                                <div class="mt-2 flex items-center justify-between">
                                    <span class="text-xl font-bold">${{ number_format($product->price, 2) }}</span>
                                    <span class="text-sm text-gray-500">SKU: {{ $product->sku }}</span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>

                <div class="mt-8">
                    {{ $products->links() }}
                </div>
            @endif
        </div>
    </section>
</x-user-layout>

