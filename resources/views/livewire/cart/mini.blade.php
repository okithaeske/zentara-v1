<div x-data>
    @if($open)
        <div class="fixed inset-0 z-[95]" aria-modal="true" role="dialog">
            <div class="absolute inset-0 bg-black/50" wire:click="close"></div>
            <div class="absolute inset-y-0 right-0 w-full max-w-md bg-white shadow-2xl z-[96] flex flex-col">
                <div class="p-4 border-b flex items-center justify-between">
                    <h3 class="text-lg font-semibold">Your Cart</h3>
                    <button class="text-gray-500 hover:text-gray-700" wire:click="close" aria-label="Close">✕</button>
                </div>
                <div class="flex-1 overflow-auto p-4 space-y-3">
                    @if (empty($cart['items']))
                        <p class="text-gray-500">Your cart is empty.</p>
                    @else
                        @foreach ($cart['items'] as $item)
                            <div class="flex gap-3 items-center">
                                <div class="w-16 h-16 bg-gray-100 overflow-hidden rounded">
                                    @if ($item['image'])
                                        <img src="{{ Storage::url($item['image']) }}" alt="{{ $item['name'] }}" class="w-full h-full object-cover">
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <div class="font-medium text-gray-900 truncate">{{ $item['name'] }}</div>
                                    <div class="text-sm text-gray-500">Qty {{ $item['qty'] }}</div>
                                </div>
                                <div class="text-gray-900 font-semibold">${{ number_format($item['price'] * $item['qty'], 2) }}</div>
                                <button class="text-red-600 text-sm" wire:click="remove({{ $item['id'] }})">Remove</button>
                            </div>
                        @endforeach
                    @endif
                </div>
                <div class="p-4 border-t space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-gray-600">Subtotal</span>
                        <span class="text-xl font-bold text-gray-900">${{ number_format($cart['subtotal'], 2) }}</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <a href="{{ route('cart.index') }}" class="flex-1 inline-flex items-center justify-center px-4 py-2 rounded-lg border border-gray-300 hover:bg-gray-100">View Cart</a>
                        <a href="{{ route('checkout.index') }}" class="flex-1 inline-flex items-center justify-center px-4 py-2 rounded-lg bg-gray-900 text-white hover:bg-gray-800">Checkout</a>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

