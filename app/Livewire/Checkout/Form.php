<?php

namespace App\Livewire\Checkout;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Form extends Component
{
    #[Validate('required|string|max:255')]
    public string $shipping_name = '';
    #[Validate('required|email|max:255')]
    public string $shipping_email = '';
    #[Validate('nullable|string|max:50')]
    public ?string $shipping_phone = null;
    #[Validate('required|string|max:100')]
    public string $shipping_country = '';
    #[Validate('required|string|max:255')]
    public string $shipping_address = '';
    #[Validate('required|string|max:100')]
    public string $shipping_city = '';
    #[Validate('required|string|max:20')]
    public string $shipping_postal_code = '';
    #[Validate('nullable|string|max:2000')]
    public ?string $notes = null;

    public string $payment_method = 'card';

    // Card fields (demo only)
    #[Validate('required|string|max:255')]
    public string $card_name = '';
    #[Validate('required|string')]
    public string $card_number = '';
    #[Validate('required|integer|between:1,12')]
    public int $card_exp_month = 1;
    #[Validate('required|integer|min:' . 2000 . '|max:' . 2100)]
    public int $card_exp_year = 2030;
    #[Validate('required|string|min:3|max:4')]
    public string $card_cvc = '';

    public function mount(): void
    {
        $user = auth()->user();
        if ($user) {
            $this->shipping_name = $user->name ?? '';
            $this->shipping_email = $user->email ?? '';
        }
    }

    public function updated($name): void
    {
        $this->validateOnly($name);
    }

    protected function cart(): array
    {
        return session('cart', ['items' => [], 'count' => 0, 'subtotal' => 0]);
    }

    public function placeOrder()
    {
        $this->validate();

        $cart = $this->cart();
        if (empty($cart['items'])) {
            $this->addError('card_name', 'Your cart is empty.');
            return;
        }

        $order = DB::transaction(function () use ($cart) {
            $productIds = array_keys($cart['items']);
            $products = Product::whereIn('id', $productIds)->lockForUpdate()->get()->keyBy('id');

            $subtotal = 0.0;
            foreach ($cart['items'] as $pid => $item) {
                $p = $products[$pid] ?? null;
                if (!$p || $p->status !== 'published') {
                    abort(422, 'One or more products are no longer available.');
                }
                $qty = min($item['qty'], max(0, (int)$p->stock));
                if ($qty < 1) {
                    abort(422, 'Insufficient stock for product: ' . $p->name);
                }
                $subtotal += (float)$p->price * $qty;
            }

            $shipping = 0.00;
            $total = $subtotal + $shipping;

            $digits = preg_replace('/\D+/', '', $this->card_number);
            if (!$digits || strlen($digits) < 12 || strlen($digits) > 19 || !$this->luhnValid($digits)) {
                abort(422, 'Invalid card number.');
            }
            $brand = $this->detectBrand($digits);
            $last4 = substr($digits, -4);
            $expYear = (int) $this->card_exp_year;
            $expMonth = (int) $this->card_exp_month;
            $nowYear = (int) date('Y');
            $nowMonth = (int) date('n');
            if ($expYear === $nowYear && $expMonth < $nowMonth) {
                abort(422, 'Card is expired.');
            }

            $order = Order::create([
                'user_id' => auth()->id(),
                'status' => 'paid',
                'subtotal' => round($subtotal, 2),
                'shipping_amount' => round($shipping, 2),
                'total' => round($total, 2),
                'payment_method' => $this->payment_method,
                'shipping_name' => $this->shipping_name,
                'shipping_email' => $this->shipping_email,
                'shipping_phone' => $this->shipping_phone,
                'shipping_address' => $this->shipping_address,
                'shipping_city' => $this->shipping_city,
                'shipping_country' => $this->shipping_country,
                'shipping_postal_code' => $this->shipping_postal_code,
                'notes' => $this->notes,
            ]);

            foreach ($cart['items'] as $pid => $item) {
                $p = $products[$pid];
                $qty = min($item['qty'], max(0, (int)$p->stock));
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $p->id,
                    'name' => $p->name,
                    'unit_price' => $p->price,
                    'quantity' => $qty,
                    'total' => round($p->price * $qty, 2),
                ]);
                if (!is_null($p->stock)) {
                    $p->decrement('stock', $qty);
                }
            }

            \App\Models\Transaction::create([
                'order_id' => $order->id,
                'amount' => round($total, 2),
                'currency' => config('cashier.currency', env('STRIPE_CURRENCY', 'usd')),
                'method' => 'card',
                'gateway' => 'offline',
                'status' => 'captured',
                'card_last4' => $last4,
                'card_brand' => $brand,
                'card_exp_month' => $expMonth,
                'card_exp_year' => $expYear,
                'reference' => 'OFF-' . Str::uuid(),
            ]);

            return $order;
        });

        session()->forget('cart');
        return redirect()->route('checkout.success', $order);
    }

    private function luhnValid(string $number): bool
    {
        $sum = 0; $alt = false;
        for ($i = strlen($number) - 1; $i >= 0; $i--) {
            $n = (int)$number[$i];
            if ($alt) { $n *= 2; if ($n > 9) { $n -= 9; } }
            $sum += $n; $alt = !$alt;
        }
        return $sum % 10 === 0;
    }

    private function detectBrand(string $digits): string
    {
        if (preg_match('/^4\d{12,18}$/', $digits)) return 'visa';
        if (preg_match('/^(5[1-5]\d{14}|2(2[2-9]\d{12}|[3-6]\d{13}|7[01]\d{12}|720\d{12}))$/', $digits)) return 'mastercard';
        if (preg_match('/^(34|37)\d{13}$/', $digits)) return 'amex';
        if (preg_match('/^6(011\d{12}|5\d{14}|4[4-9]\d{13})$/', $digits)) return 'discover';
        return 'card';
    }

    public function render()
    {
        return view('livewire.checkout.form');
    }
}

