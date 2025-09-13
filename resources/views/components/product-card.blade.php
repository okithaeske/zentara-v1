@props(['product'])

<div class="group bg-white rounded-2xl border border-gray-100 shadow-md hover:shadow-2xl transition-all duration-300 overflow-hidden flex flex-col h-full">
    <div class="relative">
        <a href="{{ route('products.show', $product) }}" class="block">
            <div class="aspect-square bg-gradient-to-br from-gray-100 to-gray-200 overflow-hidden">
                @if ($product->image_path)
                    <img src="{{ Storage::url($product->image_path) }}" alt="{{ $product->name }}" class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-500" />
                @else
                    <div class="w-full h-full flex flex-col items-center justify-center text-gray-400">
                        <svg class="w-12 h-12 mb-2" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm0-14c-3.31 0-6 2.69-6 6s2.69 6 6 6 6-2.69 6-6-2.69-6-6-6zm3 8h-4V8h2v4h2v2z" />
                        </svg>
                        <span class="text-xs">No image</span>
                    </div>
                @endif
            </div>
        </a>
        <a href="{{ route('products.show', $product) }}" class="absolute inset-0 flex items-center justify-center bg-black/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
            <span class="bg-yellow-500 text-black px-4 py-2 rounded-lg font-semibold transform translate-y-2 group-hover:translate-y-0 transition-transform duration-300">Quick View</span>
        </a>
    </div>
    <div class="p-5 sm:p-6 space-y-3 flex-1">
        <div class="space-y-1">
            <a href="{{ route('products.show', $product) }}" class="block">
                <h3 class="text-lg font-semibold text-gray-900 leading-tight line-clamp-2">{{ $product->name }}</h3>
            </a>
            <p class="text-xs text-gray-500">SKU: {{ $product->sku }}</p>
        </div>
        <div class="flex items-center justify-between gap-3">
            <span class="text-xl sm:text-2xl font-bold text-gray-900">${{ number_format($product->price, 2) }}</span>
        </div>
    </div>
    <div class="px-5 sm:px-6 pb-5 sm:pb-6 pt-0 mt-auto border-t border-gray-100">
        @php($isAdmin = auth()->check() && auth()->user()->role === 'admin')
        @unless($isAdmin)
            <form method="POST" action="{{ route('cart.add', $product->id) }}">
                @csrf
                <input type="hidden" name="qty" value="1">
                <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-2.5 rounded-lg bg-gray-900 text-white hover:bg-gray-800 transition-colors">
                    Add to Cart
                </button>
            </form>
        @else
            <button type="button" class="w-full inline-flex items-center justify-center px-4 py-2.5 rounded-lg bg-gray-700 text-gray-300 cursor-not-allowed" disabled>
                Add to Cart
            </button>
        @endunless
    </div>
</div>
