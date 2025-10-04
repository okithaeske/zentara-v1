<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\OrderConfirmation;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class CheckoutController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['required', 'integer', 'distinct', 'exists:products,id'],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
            'shipping_name' => ['required', 'string', 'max:255'],
            'shipping_email' => ['required', 'email', 'max:255'],
            'shipping_phone' => ['nullable', 'string', 'max:50'],
            'shipping_address' => ['required', 'string', 'max:255'],
            'shipping_city' => ['required', 'string', 'max:100'],
            'shipping_country' => ['required', 'string', 'max:100'],
            'shipping_postal_code' => ['required', 'string', 'max:20'],
            'notes' => ['nullable', 'string', 'max:2000'],
            'payment_method' => ['required', 'in:card'],
            'card_name' => ['required', 'string', 'max:255'],
            'card_number' => ['required', 'string'],
            'card_exp_month' => ['required', 'integer', 'between:1,12'],
            'card_exp_year' => ['required', 'integer', 'min:' . (int) date('Y'), 'max:' . ((int) date('Y') + 15)],
            'card_cvc' => ['required', 'string', 'min:3', 'max:4'],
        ]);

        $order = DB::transaction(function () use ($validated, $request) {
            $cartItems = collect($validated['items'])
                ->mapWithKeys(function ($item) {
                    $productId = (int) $item['product_id'];
                    $quantity = (int) $item['quantity'];
                    return [$productId => $quantity];
                });

            $productIds = $cartItems->keys();
            $products = Product::whereIn('id', $productIds)->lockForUpdate()->get()->keyBy('id');

            if ($products->count() !== $cartItems->count()) {
                abort(Response::HTTP_UNPROCESSABLE_ENTITY, 'One or more products are invalid.');
            }

            $subtotal = 0.0;
            $normalizedItems = [];

            foreach ($cartItems as $productId => $quantity) {
                /** @var Product|null $product */
                $product = $products[$productId] ?? null;
                if (! $product || $product->status !== 'published') {
                    abort(Response::HTTP_UNPROCESSABLE_ENTITY, 'One or more products are no longer available.');
                }

                $availableQty = min($quantity, max(0, (int) $product->stock));
                if ($availableQty < 1) {
                    abort(Response::HTTP_UNPROCESSABLE_ENTITY, 'Insufficient stock for product: ' . $product->name);
                }

                $lineTotal = round((float) $product->price * $availableQty, 2);
                $subtotal += $lineTotal;

                $normalizedItems[] = [
                    'product' => $product,
                    'quantity' => $availableQty,
                    'total' => $lineTotal,
                ];
            }

            $shipping = 0.00;
            $total = $subtotal + $shipping;

            $digits = preg_replace('/\D+/', '', (string) $validated['card_number']);
            if (! $digits) {
                $digits = '0000';
            }

            $expYear = (int) $validated['card_exp_year'];
            $expMonth = (int) $validated['card_exp_month'];
            $nowYear = (int) date('Y');
            $nowMonth = (int) date('n');
            if ($expYear === $nowYear && $expMonth < $nowMonth) {
                abort(Response::HTTP_UNPROCESSABLE_ENTITY, 'Card is expired.');
            }

            $order = Order::create([
                'user_id' => $request->user()?->id,
                'status' => 'paid',
                'subtotal' => round($subtotal, 2),
                'shipping_amount' => round($shipping, 2),
                'total' => round($total, 2),
                'payment_method' => $validated['payment_method'],
                'shipping_name' => $validated['shipping_name'],
                'shipping_email' => $validated['shipping_email'],
                'shipping_phone' => $validated['shipping_phone'] ?? null,
                'shipping_address' => $validated['shipping_address'],
                'shipping_city' => $validated['shipping_city'],
                'shipping_country' => $validated['shipping_country'],
                'shipping_postal_code' => $validated['shipping_postal_code'],
                'notes' => $validated['notes'] ?? null,
            ]);

            foreach ($normalizedItems as $item) {
                /** @var Product $product */
                $product = $item['product'];
                $quantity = $item['quantity'];

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'name' => $product->name,
                    'unit_price' => $product->price,
                    'quantity' => $quantity,
                    'total' => $item['total'],
                ]);

                if (! is_null($product->stock)) {
                    $product->decrement('stock', $quantity);
                }
            }

            Transaction::create([
                'order_id' => $order->id,
                'amount' => round($total, 2),
                'currency' => config('cashier.currency', env('STRIPE_CURRENCY', 'usd')),
                'method' => 'card',
                'gateway' => 'offline',
                'status' => 'captured',
                'card_last4' => substr(str_pad($digits, 4, '0', STR_PAD_LEFT), -4),
                'card_brand' => $this->detectBrand($digits),
                'card_exp_month' => $expMonth,
                'card_exp_year' => $expYear,
                'reference' => 'OFF-' . Str::uuid(),
            ]);

            return $order;
        });

        $order->load(['items.product']);

        try {
            Mail::to($order->shipping_email)->send(new OrderConfirmation($order));

            $user = $request->user();
            if ($user && strcasecmp($user->email, $order->shipping_email) !== 0) {
                Mail::to($user->email)->send(new OrderConfirmation($order));
            }

            foreach (config('mail.order_notifications', []) as $address) {
                if (! filter_var($address, FILTER_VALIDATE_EMAIL)) {
                    continue;
                }

                if (strcasecmp($address, $order->shipping_email) === 0) {
                    continue;
                }

                if ($request->user() && strcasecmp($address, $request->user()->email) === 0) {
                    continue;
                }

                Mail::to($address)->send(new OrderConfirmation($order));
            }
        } catch (\Throwable $exception) {
            report($exception);
        }

        return response()->json([
            'message' => 'Order placed successfully.',
            'data' => [
                'id' => (string) $order->getKey(),
                'status' => $order->status,
                'subtotal' => (float) $order->subtotal,
                'shipping_amount' => (float) $order->shipping_amount,
                'total' => (float) $order->total,
                'payment_method' => $order->payment_method,
                'shipping' => [
                    'name' => $order->shipping_name,
                    'email' => $order->shipping_email,
                    'phone' => $order->shipping_phone,
                    'address' => $order->shipping_address,
                    'city' => $order->shipping_city,
                    'country' => $order->shipping_country,
                    'postal_code' => $order->shipping_postal_code,
                    'notes' => $order->notes,
                ],
                'items' => $order->items->map(function (OrderItem $item) {
                    return [
                        'product_id' => $item->product_id,
                        'name' => $item->name,
                        'quantity' => (int) $item->quantity,
                        'unit_price' => (float) $item->unit_price,
                        'total' => (float) $item->total,
                    ];
                })->values(),
                'created_at' => $order->created_at?->toJSON(),
            ],
        ], Response::HTTP_CREATED);
    }

    private function detectBrand(string $digits): string
    {
        if (preg_match('/^4\d{12,18}$/', $digits)) {
            return 'visa';
        }

        if (preg_match('/^(5[1-5]\d{14}|2(2[2-9]\d{12}|[3-6]\d{13}|7[01]\d{12}|720\d{12}))$/', $digits)) {
            return 'mastercard';
        }

        if (preg_match('/^(34|37)\d{13}$/', $digits)) {
            return 'amex';
        }

        if (preg_match('/^6(011\d{12}|5\d{14}|4[4-9]\d{13})$/', $digits)) {
            return 'discover';
        }

        return 'card';
    }
}
