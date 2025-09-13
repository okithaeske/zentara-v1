<div>
    @if($open && $product)
        <div class="fixed inset-0 z-[90]" aria-modal="true" role="dialog">
            <div class="absolute inset-0 bg-black/60" wire:click="close"></div>
            <div class="relative mx-auto my-10 w-full max-w-3xl bg-white rounded-2xl shadow-xl overflow-hidden z-[91]">
                <div class="grid grid-cols-1 md:grid-cols-2">
                    <div class="bg-gray-100">
                        @if ($product->image_path)
                            <img src="{{ Storage::url($product->image_path) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                        @else
                            <div class="aspect-square w-full h-full flex items-center justify-center text-gray-400">No image</div>
                        @endif
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="flex items-start justify-between gap-4">
                            <h3 class="text-2xl font-semibold text-gray-900">{{ $product->name }}</h3>
                            <button type="button" class="text-gray-400 hover:text-gray-600" wire:click="close" aria-label="Close">✕</button>
                        </div>
                        <div class="text-sm text-gray-500">SKU: {{ $product->sku }}</div>
                        <div class="text-3xl font-bold text-gray-900">${{ number_format($product->price, 2) }}</div>
                        <div class="text-gray-700 prose prose-sm max-w-none">
                            @if ($product->description)
                                {!! nl2br(e($product->description)) !!}
                            @else
                                <span class="text-gray-500">No description provided.</span>
                            @endif
                        </div>
                        <div class="flex items-center gap-3">
                            <label class="text-sm text-gray-600">Qty</label>
                            <input type="number" min="1" max="{{ $product->stock ?? 999 }}" wire:model.lazy="qty" class="w-24 px-3 py-2 border rounded-lg">
                        </div>
                        <div class="flex items-center gap-3 pt-2">
                            <button type="button" wire:click="addToCart" class="px-5 py-3 rounded-lg bg-gray-900 text-white hover:bg-gray-800">Add to Cart</button>
                            <a href="{{ route('products.show', $product) }}" class="px-5 py-3 rounded-lg border border-gray-300 hover:bg-gray-100">View Details</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

