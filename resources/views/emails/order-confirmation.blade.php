<!DOCTYPE html>
<html lang="en">
<body style="font-family: Arial, sans-serif; color: #111;">
    @php($currency = strtoupper(config('cashier.currency', env('STRIPE_CURRENCY', 'usd'))))

    <p>Hi {{ $order->shipping_name ?? ($order->user->name ?? 'there') }},</p>

    <p>Thank you for your order with <strong>{{ config('app.name') }}</strong>. We’re getting everything ready and will share tracking details as soon as your items ship.</p>

    <p><strong>Order #{{ $order->id }}</strong><br>
       Placed on {{ $order->created_at->format('F j, Y') }}</p>

    <p><strong>Order summary</strong></p>
    <ul>
        @foreach ($order->items as $item)
            <li>
                {{ $item->quantity }} × {{ $item->name }} — {{ number_format($item->total, 2) }} {{ $currency }}
            </li>
        @endforeach
    </ul>

    <p>
        Subtotal: {{ number_format($order->subtotal, 2) }} {{ $currency }}<br>
        Shipping: {{ number_format($order->shipping_amount, 2) }} {{ $currency }}<br>
        <strong>Total: {{ number_format($order->total, 2) }} {{ $currency }}</strong>
    </p>

    <p><strong>Shipping to</strong><br>
        {{ $order->shipping_name }}<br>
        {{ $order->shipping_address }}<br>
        {{ $order->shipping_city }}, {{ $order->shipping_country }} {{ $order->shipping_postal_code }}<br>
        @if ($order->shipping_phone)
            Phone: {{ $order->shipping_phone }}<br>
        @endif
        Email: {{ $order->shipping_email }}
    </p>

    @if ($order->notes)
        <p><strong>Order notes</strong><br>
        {{ $order->notes }}</p>
    @endif

    <p>If you have any questions, just reply to this email and our concierge team will be happy to help.</p>

    <p>Warm regards,<br>
    The {{ config('app.name') }} Team</p>
</body>
</html>