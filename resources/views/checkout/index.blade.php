<x-user-layout title="Checkout">
    <section class="py-10 bg-white text-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-2xl sm:text-3xl font-bold mb-6">Checkout</h1>

            @if ($errors->any())
                <div class="mb-4 p-3 rounded bg-red-50 text-red-800">{{ $errors->first() }}</div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <form method="POST" action="{{ route('checkout.store') }}" class="lg:col-span-2 space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium mb-1">Full Name</label>
                            <input type="text" name="shipping_name" value="{{ old('shipping_name', auth()->user()->name ?? '') }}" class="w-full px-4 py-2 border rounded-lg" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Email</label>
                            <input type="email" name="shipping_email" value="{{ old('shipping_email', auth()->user()->email ?? '') }}" class="w-full px-4 py-2 border rounded-lg" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Phone</label>
                            <input type="text" name="shipping_phone" value="{{ old('shipping_phone') }}" class="w-full px-4 py-2 border rounded-lg">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Country</label>
                            <input type="text" name="shipping_country" value="{{ old('shipping_country') }}" class="w-full px-4 py-2 border rounded-lg" required>
                        </div>
                        <div class="sm:col-span-2">
                            <label class="block text-sm font-medium mb-1">Address</label>
                            <input type="text" name="shipping_address" value="{{ old('shipping_address') }}" class="w-full px-4 py-2 border rounded-lg" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">City</label>
                            <input type="text" name="shipping_city" value="{{ old('shipping_city') }}" class="w-full px-4 py-2 border rounded-lg" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Postal Code</label>
                            <input type="text" name="shipping_postal_code" value="{{ old('shipping_postal_code') }}" class="w-full px-4 py-2 border rounded-lg" required>
                        </div>
                        <div class="sm:col-span-2">
                            <label class="block text-sm font-medium mb-1">Notes (optional)</label>
                            <textarea name="notes" rows="3" class="w-full px-4 py-2 border rounded-lg">{{ old('notes') }}</textarea>
                        </div>
                    </div>

                    <input type="hidden" name="payment_method" value="card" />
                    <div class="space-y-4">
                        <h2 class="text-lg font-semibold">Card Details</h2>
                        <div>
                            <label class="block text-sm font-medium mb-1">Name on Card</label>
                            <input type="text" name="card_name" value="{{ old('card_name') }}" class="w-full px-4 py-2 border rounded-lg" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Card Number</label>
                            <input type="text" inputmode="numeric" autocomplete="cc-number" name="card_number" value="{{ old('card_number') }}" class="w-full px-4 py-2 border rounded-lg" placeholder="4242 4242 4242 4242" required>
                        </div>
                        <div class="grid grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium mb-1">Exp. Month</label>
                                <input type="number" name="card_exp_month" value="{{ old('card_exp_month') }}" class="w-full px-4 py-2 border rounded-lg" min="1" max="12" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-1">Exp. Year</label>
                                <input type="number" name="card_exp_year" value="{{ old('card_exp_year') }}" class="w-full px-4 py-2 border rounded-lg" min="{{ date('Y') }}" max="{{ date('Y') + 15 }}" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-1">CVC</label>
                                <input type="password" inputmode="numeric" name="card_cvc" value="" class="w-full px-4 py-2 border rounded-lg" maxlength="4" required>
                            </div>
                        </div>
                        <p class="text-sm text-gray-600">Note: This demo validates card details locally and records a transaction; it does not charge your card.</p>
                    </div>

                    <button id="place-order" class="px-6 py-3 bg-yellow-500 text-gray-900 font-semibold rounded-lg hover:bg-yellow-400">Place Order</button>
                </form>

                <livewire:checkout.summary />
            </div>
        </div>
    </section>
    
</x-user-layout>

