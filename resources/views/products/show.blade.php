<x-user-layout :title="$product->name">
    <section class="py-12 bg-white text-gray-900">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <a href="{{ url()->previous() === url()->current() ? route('products.index') : url()->previous() }}" class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900 mb-6">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Back
            </a>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <div class="bg-gray-100 rounded-xl overflow-hidden">
                    @if ($product->image_path)
                        <img src="{{ Storage::url($product->image_path) }}" alt="{{ $product->name }}" class="w-full h-full object-cover" />
                    @else
                        <div class="w-full aspect-square flex items-center justify-center text-gray-400">No image</div>
                    @endif
                </div>

                <div>
                    <h1 class="text-3xl font-bold">{{ $product->name }}</h1>
                    <div class="mt-3 flex items-center gap-4">
                        <span class="text-2xl font-bold">${{ number_format($product->price, 2) }}</span>
                        <span class="text-sm text-gray-500">SKU: {{ $product->sku }}</span>
                    </div>

                    <div class="mt-6 prose prose-sm max-w-none">
                        @if ($product->description)
                            <p class="text-gray-700">{!! nl2br(e($product->description)) !!}</p>
                        @else
                            <p class="text-gray-500">No description provided.</p>
                        @endif
                    </div>

                    <div class="mt-6">
                        @if ($product->stock > 0)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-green-100 text-green-700">In stock</span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-red-100 text-red-700">Out of stock</span>
                        @endif
                    </div>

                    <div class="mt-8 flex flex-col sm:flex-row gap-3">
                        <form method="POST" action="{{ route('cart.add', $product->id) }}" class="flex gap-3">
                            @csrf
                            <input type="number" name="qty" value="1" min="1" max="{{ $product->stock ?? 999 }}" class="w-24 px-3 py-3 border rounded-lg" />
                            <button class="px-6 py-3 bg-gray-900 text-white rounded-lg hover:bg-gray-800">Add to Cart</button>
                        </form>
                        <a href="{{ route('products.index') }}" class="px-6 py-3 border border-gray-300 rounded-lg hover:bg-gray-100">Continue shopping</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-user-layout>
