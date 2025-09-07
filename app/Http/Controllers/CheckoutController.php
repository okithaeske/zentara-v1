<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    protected function cart()
    {
        return session('cart', ['items' => [], 'count' => 0, 'subtotal' => 0]);
    }

    public function show(Request $request)
    {
        $cart = $this->cart();
        if (empty($cart['items'])) {
            return redirect()->route('products.index')->with('status', 'Your cart is empty.');
        }
        return view('checkout.index', compact('cart'));
    }

    public function store(Request $request)
    {
        $cart = $this->cart();
        if (empty($cart['items'])) {
            return redirect()->route('products.index')->withErrors('Your cart is empty.');
        }

        $data = $request->validate([
            'shipping_name' => ['required', 'string', 'max:255'],
            'shipping_email' => ['required', 'email', 'max:255'],
            'shipping_phone' => ['nullable', 'string', 'max:50'],
            'shipping_address' => ['required', 'string', 'max:255'],
            'shipping_city' => ['required', 'string', 'max:100'],
            'shipping_country' => ['required', 'string', 'max:100'],
            'shipping_postal_code' => ['required', 'string', 'max:20'],
            'notes' => ['nullable', 'string', 'max:2000'],
            'payment_method' => ['required', 'in:card'],
            // Card inputs (not stored):
            'card_name' => ['required', 'string', 'max:255'],
            'card_number' => ['required', 'string'],
            'card_exp_month' => ['required', 'integer', 'between:1,12'],
            'card_exp_year' => ['required', 'integer', 'min:' . (int)date('Y'), 'max:' . ((int)date('Y') + 15)],
            'card_cvc' => ['required', 'string', 'min:3', 'max:4'],
        ]);

        $user = $request->user();

        $order = DB::transaction(function () use ($cart, $data, $user) {
            // Refresh product data and validate stock
            $productIds = array_keys($cart['items']);
            $products = Product::whereIn('id', $productIds)->lockForUpdate()->get()->keyBy('id');

            $subtotal = 0.0;
            foreach ($cart['items'] as $pid => $item) {
                /** @var Product|null $p */
                $p = $products[$pid] ?? null;
                if (!$p || $p->status !== 'published') {
                    abort(422, 'One or more products are no longer available.');
                }
                $qty = min($item['qty'], max(0, (int) $p->stock));
                if ($qty < 1) {
                    abort(422, 'Insufficient stock for product: ' . $p->name);
                }
                $subtotal += (float)$p->price * $qty;
            }

            $shipping = 0.00; // Flat for now; could compute later
            $total = $subtotal + $shipping;

            // Validate card locally (Luhn + basic checks). This does NOT charge.
            $digits = preg_replace('/\D+/', '', $data['card_number']);
            if (!$digits || strlen($digits) < 12 || strlen($digits) > 19 || !self::luhnValid($digits)) {
                abort(422, 'Invalid card number.');
            }
            $brand = self::detectBrand($digits);
            $last4 = substr($digits, -4);
            $expYear = (int) $data['card_exp_year'];
            $expMonth = (int) $data['card_exp_month'];
            $nowYear = (int) date('Y');
            $nowMonth = (int) date('n');
            if ($expYear === $nowYear && $expMonth < $nowMonth) {
                abort(422, 'Card is expired.');
            }

            $order = Order::create([
                'user_id' => $user?->id,
                'status' => 'paid',
                'subtotal' => round($subtotal, 2),
                'shipping_amount' => round($shipping, 2),
                'total' => round($total, 2),
                'payment_method' => $data['payment_method'],
                'shipping_name' => $data['shipping_name'],
                'shipping_email' => $data['shipping_email'],
                'shipping_phone' => $data['shipping_phone'] ?? null,
                'shipping_address' => $data['shipping_address'],
                'shipping_city' => $data['shipping_city'],
                'shipping_country' => $data['shipping_country'],
                'shipping_postal_code' => $data['shipping_postal_code'],
                'notes' => $data['notes'] ?? null,
            ]);

            foreach ($cart['items'] as $pid => $item) {
                $p = $products[$pid];
                $qty = min($item['qty'], max(0, (int) $p->stock));
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $p->id,
                    'name' => $p->name,
                    'unit_price' => $p->price,
                    'quantity' => $qty,
                    'total' => round($p->price * $qty, 2),
                ]);
                // Decrement stock
                if (!is_null($p->stock)) {
                    $p->decrement('stock', $qty);
                }
            }

            // Record a transaction (no sensitive data stored)
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
                'reference' => 'OFF-' . \Illuminate\Support\Str::uuid(),
            ]);

            return $order;
        });

        // Clear cart
        session()->forget('cart');

        return redirect()->route('checkout.success', $order)->with('status', 'Order placed successfully.');
    }

    public function success(Order $order)
    {
        return view('checkout.success', compact('order'));
    }


    private static function luhnValid(string $number): bool
    {
        $sum = 0; $alt = false;
        for ($i = strlen($number) - 1; $i >= 0; $i--) {
            $n = (int)$number[$i];
            if ($alt) { $n *= 2; if ($n > 9) { $n -= 9; } }
            $sum += $n; $alt = !$alt;
        }
        return $sum % 10 === 0;
    }

    private static function detectBrand(string $digits): string
    {
        if (preg_match('/^4\d{12,18}$/', $digits)) return 'visa';
        if (preg_match('/^(5[1-5]\d{14}|2(2[2-9]\d{12}|[3-6]\d{13}|7[01]\d{12}|720\d{12}))$/', $digits)) return 'mastercard';
        if (preg_match('/^(34|37)\d{13}$/', $digits)) return 'amex';
        if (preg_match('/^6(011\d{12}|5\d{14}|4[4-9]\d{13})$/', $digits)) return 'discover';
        return 'card';
    }
}
