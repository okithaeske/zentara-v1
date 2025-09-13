<form wire:submit.prevent="placeOrder" class="lg:col-span-2 space-y-6">
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
        <div>
            <label class="block text-sm font-medium mb-1">Full Name</label>
            <input type="text" wire:model.lazy="shipping_name" class="w-full px-4 py-2 border rounded-lg @error('shipping_name') border-red-500 @enderror" required>
            @error('shipping_name') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Email</label>
            <input type="email" wire:model.lazy="shipping_email" class="w-full px-4 py-2 border rounded-lg @error('shipping_email') border-red-500 @enderror" required>
            @error('shipping_email') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Phone</label>
            <input type="text" wire:model.lazy="shipping_phone" class="w-full px-4 py-2 border rounded-lg @error('shipping_phone') border-red-500 @enderror">
            @error('shipping_phone') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Country</label>
            <input type="text" wire:model.lazy="shipping_country" class="w-full px-4 py-2 border rounded-lg @error('shipping_country') border-red-500 @enderror" required>
            @error('shipping_country') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
        </div>
        <div class="sm:col-span-2">
            <label class="block text-sm font-medium mb-1">Address</label>
            <input type="text" wire:model.lazy="shipping_address" class="w-full px-4 py-2 border rounded-lg @error('shipping_address') border-red-500 @enderror" required>
            @error('shipping_address') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">City</label>
            <input type="text" wire:model.lazy="shipping_city" class="w-full px-4 py-2 border rounded-lg @error('shipping_city') border-red-500 @enderror" required>
            @error('shipping_city') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Postal Code</label>
            <input type="text" wire:model.lazy="shipping_postal_code" class="w-full px-4 py-2 border rounded-lg @error('shipping_postal_code') border-red-500 @enderror" required>
            @error('shipping_postal_code') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
        </div>
        <div class="sm:col-span-2">
            <label class="block text-sm font-medium mb-1">Notes (optional)</label>
            <textarea wire:model.lazy="notes" rows="3" class="w-full px-4 py-2 border rounded-lg @error('notes') border-red-500 @enderror"></textarea>
            @error('notes') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
        </div>
    </div>

    <input type="hidden" wire:model="payment_method" value="card" />
    <div class="space-y-4">
        <h2 class="text-lg font-semibold">Card Details</h2>
        <div>
            <label class="block text-sm font-medium mb-1">Name on Card</label>
            <input type="text" wire:model.lazy="card_name" class="w-full px-4 py-2 border rounded-lg @error('card_name') border-red-500 @enderror" required>
            @error('card_name') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Card Number</label>
            <input type="text" inputmode="numeric" autocomplete="cc-number" wire:model.lazy="card_number" class="w-full px-4 py-2 border rounded-lg @error('card_number') border-red-500 @enderror" placeholder="4242 4242 4242 4242" required>
            @error('card_number') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
        </div>
        <div class="grid grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium mb-1">Exp. Month</label>
                <input type="number" wire:model.lazy="card_exp_month" class="w-full px-4 py-2 border rounded-lg @error('card_exp_month') border-red-500 @enderror" min="1" max="12" required>
                @error('card_exp_month') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Exp. Year</label>
                <input type="number" wire:model.lazy="card_exp_year" class="w-full px-4 py-2 border rounded-lg @error('card_exp_year') border-red-500 @enderror" min="{{ date('Y') }}" max="{{ date('Y') + 15 }}" required>
                @error('card_exp_year') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">CVC</label>
                <input type="password" inputmode="numeric" wire:model.lazy="card_cvc" class="w-full px-4 py-2 border rounded-lg @error('card_cvc') border-red-500 @enderror" maxlength="4" required>
                @error('card_cvc') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
            </div>
        </div>
        <p class="text-sm text-gray-600">Note: This demo validates card details locally and records a transaction; it does not charge your card.</p>
    </div>

    <button type="submit" class="px-6 py-3 bg-yellow-500 text-gray-900 font-semibold rounded-lg hover:bg-yellow-400">Place Order</button>
</form>

