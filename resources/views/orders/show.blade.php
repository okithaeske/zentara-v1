<x-user-layout title="Order #{{ $order->id }}">
    <section class="py-10 bg-white text-gray-900">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-2xl sm:text-3xl font-bold">Order #{{ $order->id }}</h1>
                <span class="px-3 py-1 rounded bg-gray-100 text-sm">{{ ucfirst($order->status) }}</span>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2 space-y-4">
                    @foreach ($order->items as $item)
                        <div class="flex items-center justify-between border rounded-lg p-4">
                            <div>
                                <div class="font-semibold">{{ $item->name }}</div>
                                <div class="text-sm text-gray-600">Qty: {{ $item->quantity }} • Unit: ${{ number_format($item->unit_price, 2) }}</div>
                            </div>
                            <div class="font-semibold">${{ number_format($item->total, 2) }}</div>
                        </div>
                    @endforeach
                </div>
                <aside class="border rounded-lg p-6 h-fit space-y-2">
                    <div class="flex justify-between"><span>Subtotal</span><span>${{ number_format($order->subtotal, 2) }}</span></div>
                    <div class="flex justify-between"><span>Shipping</span><span>${{ number_format($order->shipping_amount, 2) }}</span></div>
                    <div class="flex justify-between text-lg font-bold"><span>Total</span><span>${{ number_format($order->total, 2) }}</span></div>
                    <div class="mt-4 text-sm text-gray-600">
                        <div>{{ $order->shipping_name }}</div>
                        <div>{{ $order->shipping_email }}</div>
                        <div>{{ $order->shipping_address }}, {{ $order->shipping_city }}, {{ $order->shipping_country }} {{ $order->shipping_postal_code }}</div>
                    </div>
                </aside>
            </div>
        </div>
    </section>
</x-user-layout>

