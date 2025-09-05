<x-user-layout title="Order Placed">
    <section class="py-12 bg-white text-gray-900">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            @if (session('status'))
                <div class="mb-4 p-3 rounded bg-green-50 text-green-800">{{ session('status') }}</div>
            @endif
            <h1 class="text-3xl font-bold mb-2">Thank you for your order!</h1>
            <p class="text-gray-600 mb-6">Your order number is <span class="font-semibold">#{{ $order->id }}</span>.</p>
            <a href="{{ route('products.index') }}" class="px-6 py-3 bg-gray-900 text-white rounded-lg hover:bg-gray-800">Continue shopping</a>
        </div>
    </section>
</x-user-layout>

