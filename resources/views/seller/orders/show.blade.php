@extends('layouts.seller')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-yellow-200">Order #{{ $order->id }}</h1>
            <p class="text-sm text-gray-300">Customer: {{ $order->shipping_name }} ({{ $order->shipping_email }})</p>
        </div>
        <span class="px-3 py-1 text-xs rounded bg-white/10 text-gray-300">{{ ucfirst($order->status) }}</span>
    </div>

    <div class="glass rounded-xl border border-yellow-500/10 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="text-left text-gray-400">
                    <tr>
                        <th class="px-4 py-3">Product</th>
                        <th class="px-4 py-3">Qty</th>
                        <th class="px-4 py-3">Unit</th>
                        <th class="px-4 py-3">Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @foreach ($items as $item)
                        <tr>
                            <td class="px-4 py-3 text-gray-100">{{ $item->name }}</td>
                            <td class="px-4 py-3 text-gray-300">{{ $item->quantity }}</td>
                            <td class="px-4 py-3 text-gray-300">${{ number_format($item->unit_price, 2) }}</td>
                            <td class="px-4 py-3 text-gray-300">${{ number_format($item->total, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="p-4 flex justify-end text-gray-200">
            <div class="text-right">
                <div>Your Subtotal:</div>
                <div class="text-xl font-semibold">${{ number_format($sellerTotal, 2) }}</div>
            </div>
        </div>
    </div>

    <div class="text-sm text-gray-400">
        <div>Ship to: {{ $order->shipping_address }}, {{ $order->shipping_city }}, {{ $order->shipping_country }} {{ $order->shipping_postal_code }}</div>
        @if($order->notes)
            <div class="mt-2">Notes: {{ $order->notes }}</div>
        @endif
    </div>
</div>
@endsection

