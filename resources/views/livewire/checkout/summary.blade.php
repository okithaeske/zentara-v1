<aside class="border rounded-lg p-6 h-fit">
    <h2 class="text-xl font-semibold mb-4">Order Summary</h2>
    <div class="space-y-3 max-h-72 overflow-auto pr-2">
        @foreach ($cart['items'] as $item)
            <div class="flex justify-between text-sm">
                <span class="truncate">{{ $item['name'] }} A- {{ $item['qty'] }}</span>
                <span>${{ number_format($item['price'] * $item['qty'], 2) }}</span>
            </div>
        @endforeach
    </div>
    <div class="border-t mt-4 pt-4 space-y-2 text-gray-700">
        <div class="flex justify-between">
            <span>Subtotal</span>
            <span>${{ number_format($cart['subtotal'], 2) }}</span>
        </div>
        <div class="flex justify-between">
            <span>Shipping</span>
            <span>$0.00</span>
        </div>
        <div class="flex justify-between text-lg font-bold">
            <span>Total</span>
            <span>${{ number_format($cart['subtotal'], 2) }}</span>
        </div>
    </div>
</aside>

