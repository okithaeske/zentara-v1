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

                    <div>
                        <label class="block text-sm font-medium mb-2">Payment Method</label>
                        <div class="flex flex-col gap-3">
                            <label class="inline-flex items-center gap-2">
                                <input type="radio" name="payment_method" value="cod" class="h-4 w-4" checked>
                                <span>Cash on Delivery</span>
                            </label>
                            <label class="inline-flex items-center gap-2">
                                <input type="radio" name="payment_method" value="card" class="h-4 w-4" @if(!($stripeEnabled ?? false)) disabled @endif>
                                <span class="@if(!($stripeEnabled ?? false)) text-gray-500 @endif">Card @if(!($stripeEnabled ?? false)) (enable Stripe to use) @endif</span>
                            </label>
                            @if ($stripeEnabled ?? false)
                                <div id="card-section" class="hidden mt-2 space-y-3">
                                    <div id="card-element" class="p-3 border rounded-lg bg-white"></div>
                                    <div id="card-errors" class="text-sm text-red-600"></div>
                                    <input type="hidden" name="payment_intent_id" id="payment_intent_id" />
                                </div>
                            @endif
                        </div>
                    </div>

                    <button id="place-order" class="px-6 py-3 bg-yellow-500 text-gray-900 font-semibold rounded-lg hover:bg-yellow-400">Place Order</button>
                </form>

                <aside class="border rounded-lg p-6 h-fit">
                    <h2 class="text-xl font-semibold mb-4">Order Summary</h2>
                    <div class="space-y-3 max-h-72 overflow-auto pr-2">
                        @foreach ($cart['items'] as $item)
                            <div class="flex justify-between text-sm">
                                <span class="truncate">{{ $item['name'] }} × {{ $item['qty'] }}</span>
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
            </div>
        </div>
    </section>
    @if ($stripeEnabled ?? false)
        <script src="https://js.stripe.com/v3/"></script>
        <script>
            document.addEventListener('DOMContentLoaded', async () => {
                const cardRadio = document.querySelector('input[name="payment_method"][value="card"]');
                const codRadio = document.querySelector('input[name="payment_method"][value="cod"]');
                const cardSection = document.getElementById('card-section');
                const form = document.querySelector('form[action="{{ route('checkout.store') }}"]');
                const placeBtn = document.getElementById('place-order');
                const stripe = Stripe('{{ config('services.stripe.key') }}');
                let elements, card, clientSecret;

                function mountCard() {
                    if (elements) return;
                    elements = stripe.elements({
                        appearance: {
                            theme: 'flat',
                            variables: {
                                colorText: '#111827',
                                colorTextPlaceholder: '#9CA3AF',
                                colorBackground: '#ffffff',
                                borderRadius: '8px',
                                fontFamily: 'Inter, system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif',
                            },
                        },
                    });
                    card = elements.create('payment');
                    card.mount('#card-element');
                }

                function toggleCardSection() {
                    if (cardRadio && cardRadio.checked) {
                        cardSection?.classList.remove('hidden');
                        mountCard();
                    } else {
                        cardSection?.classList.add('hidden');
                    }
                }

                [cardRadio, codRadio].forEach(r => r && r.addEventListener('change', toggleCardSection));
                toggleCardSection();

                async function ensureIntent() {
                    if (clientSecret) return clientSecret;
                    const res = await fetch('{{ route('checkout.intent') }}', {
                        method: 'POST',
                        headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
                    });
                    const data = await res.json();
                    if (!res.ok || !data.client_secret) throw new Error('Payment init failed');
                    clientSecret = data.client_secret;
                    return clientSecret;
                }

                form.addEventListener('submit', async (e) => {
                    if (!cardRadio || !cardRadio.checked) return; // COD flow
                    e.preventDefault();
                    placeBtn.disabled = true;
                    try {
                        mountCard();
                        const secret = await ensureIntent();
                        const { error, paymentIntent } = await stripe.confirmPayment({
                            elements,
                            clientSecret: secret,
                            confirmParams: {},
                            redirect: 'if_required',
                        });
                        if (error) throw error;
                        if (paymentIntent && (paymentIntent.status === 'succeeded' || paymentIntent.status === 'requires_capture')) {
                            document.getElementById('payment_intent_id').value = paymentIntent.id;
                            form.submit();
                        } else {
                            throw new Error('Payment not completed.');
                        }
                    } catch (err) {
                        const el = document.getElementById('card-errors');
                        if (el) el.textContent = err.message || 'Payment failed.';
                        placeBtn.disabled = false;
                    }
                });
            });
        </script>
    @endif
</x-user-layout>
