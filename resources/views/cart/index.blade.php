<x-user-layout title="Your Cart">
    <section class="py-10 bg-white text-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-2xl sm:text-3xl font-bold mb-6">Shopping Cart</h1>

            @if (session('status'))
                <div class="mb-4 p-3 rounded bg-green-50 text-green-800">{{ session('status') }}</div>
            @endif
            @if ($errors->any())
                <div class="mb-4 p-3 rounded bg-red-50 text-red-800">{{ $errors->first() }}</div>
            @endif

            @if (empty($cart['items']))
                <div class="text-center py-16">
                    <p class="text-gray-600 mb-6">Your cart is empty.</p>
                    <a href="{{ route('products.index') }}" class="px-6 py-3 bg-gray-900 text-white rounded-lg hover:bg-gray-800">Browse products</a>
                </div>
            @else
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <div class="lg:col-span-2">
                        <div class="space-y-4">
                            @foreach ($cart['items'] as $item)
                                <div class="flex flex-col sm:flex-row gap-4 p-4 border rounded-lg">
                                    <div class="w-full sm:w-28 h-28 bg-gray-100 rounded overflow-hidden">
                                        @if ($item['image'])
                                            <img src="{{ Storage::url($item['image']) }}" alt="{{ $item['name'] }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-gray-400">No image</div>
                                        @endif
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex items-start justify-between gap-4">
                                            <div>
                                                <a href="{{ route('products.show', $item['id']) }}" class="text-lg font-semibold hover:underline">{{ $item['name'] }}</a>
                                                <div class="text-sm text-gray-500">SKU: {{ $item['sku'] }}</div>
                                                <div class="mt-1 text-gray-700 font-medium">${{ number_format($item['price'], 2) }}</div>
                                            </div>
                                            <form method="POST" action="{{ route('cart.remove', $item['id']) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button class="text-red-600 hover:underline">Remove</button>
                                            </form>
                                        </div>

                                        <div class="mt-3">
                                            <form method="POST" action="{{ route('cart.update', $item['id']) }}" class="inline-flex items-center gap-2">
                                                @csrf
                                                @method('PATCH')
                                                <label for="qty-{{ $item['id'] }}" class="text-sm text-gray-600">Qty</label>
                                                <input id="qty-{{ $item['id'] }}" type="number" name="qty" value="{{ $item['qty'] }}" min="0" max="999" class="w-20 px-3 py-2 border rounded-lg">
                                                <button class="px-3 py-2 bg-gray-900 text-white rounded-lg hover:bg-gray-800 text-sm">Update</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <form method="POST" action="{{ route('cart.clear') }}" class="mt-6">
                            @csrf
                            @method('DELETE')
                            <button class="text-sm text-gray-600 hover:text-red-600">Clear cart</button>
                        </form>
                    </div>

                    <aside class="border rounded-lg p-6 h-fit">
                        <h2 class="text-xl font-semibold mb-4">Summary</h2>
                        <div class="flex justify-between text-gray-700 mb-2">
                            <span>Subtotal</span>
                            <span>${{ number_format($cart['subtotal'], 2) }}</span>
                        </div>
                        <div class="flex justify-between text-gray-700 mb-4">
                            <span>Shipping</span>
                            <span>$0.00</span>
                        </div>
                        <div class="flex justify-between text-lg font-bold">
                            <span>Total</span>
                            <span>${{ number_format($cart['subtotal'], 2) }}</span>
                        </div>
                        <a href="{{ route('checkout.index') }}" class="mt-6 block text-center px-6 py-3 bg-yellow-500 text-gray-900 font-semibold rounded-lg hover:bg-yellow-400">Proceed to Checkout</a>
                    </aside>
                </div>
            @endif
        </div>
    </section>
</x-user-layout>

