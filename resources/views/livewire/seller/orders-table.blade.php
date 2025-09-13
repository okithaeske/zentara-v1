<div class="glass rounded-xl border border-yellow-500/10 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="text-left text-gray-400">
                <tr>
                    <th class="px-4 py-3">Order #</th>
                    <th class="px-4 py-3">Customer</th>
                    <th class="px-4 py-3">Your Items</th>
                    <th class="px-4 py-3">Your Total</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @forelse ($orders as $order)
                    <tr>
                        <td class="px-4 py-3 text-gray-100 font-medium">#{{ $order->id }}</td>
                        <td class="px-4 py-3 text-gray-300">{{ $order->shipping_name }}</td>
                        <td class="px-4 py-3 text-gray-300">{{ $order->seller_items_count }}</td>
                        <td class="px-4 py-3 text-gray-300">${{ number_format($order->seller_total, 2) }}</td>
                        <td class="px-4 py-3"><span class="px-2 py-1 text-xs rounded bg-white/10 text-gray-300">{{ ucfirst($order->status) }}</span></td>
                        <td class="px-4 py-3 text-right">
                            <a href="{{ route('seller.orders.show', $order->id) }}" class="px-2 py-1 text-xs rounded bg-yellow-500 text-gray-900">View</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-6 text-center text-gray-400">No orders yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-4">
        {{ $orders->links() }}
    </div>
</div>

