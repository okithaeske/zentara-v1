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
            'payment_method' => ['required', 'in:cod,card'],
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

            $order = Order::create([
                'user_id' => $user?->id,
                'status' => $data['payment_method'] === 'cod' ? 'pending' : 'pending',
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
}

