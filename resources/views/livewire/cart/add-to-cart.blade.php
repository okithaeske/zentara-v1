<div class="flex gap-3 items-start">
    <div class="flex flex-col">
        <input type="number" min="1" max="{{ $product->stock ?? 999 }}" wire:model.live="qty" class="w-24 px-3 py-3 border rounded-lg @error('qty') border-red-500 @enderror" />
        <p class="text-xs text-gray-500 mt-1">Current quantity: {{ $qty }}</p>
        @error('qty')
            <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
        @enderror
    </div>
    <button wire:click="add" class="px-6 py-3 bg-gray-900 text-white rounded-lg hover:bg-gray-800">Add to Cart</button>
</div>
