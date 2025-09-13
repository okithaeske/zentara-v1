<div class="flex gap-3">
    <input type="number" min="1" max="{{ $product->stock ?? 999 }}" wire:model.lazy="qty" class="w-24 px-3 py-3 border rounded-lg" />
    <button wire:click="add" class="px-6 py-3 bg-gray-900 text-white rounded-lg hover:bg-gray-800">Add to Cart</button>
    @error('qty')
        <div class="text-sm text-red-600 mt-2">{{ $message }}</div>
    @enderror
</div>

