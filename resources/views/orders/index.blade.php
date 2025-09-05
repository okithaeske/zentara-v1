<x-user-layout title="My Orders">
    <section class="py-10 bg-white text-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-2xl sm:text-3xl font-bold mb-6">My Orders</h1>
            @if ($orders->count() === 0)
                <div class="text-gray-600">No orders yet.</div>
            @else
                <div class="overflow-x-auto border rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order #</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Placed</th>
                                <th class="px-4 py-3"></th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($orders as $order)
                                <tr>
                                    <td class="px-4 py-3 font-medium">#{{ $order->id }}</td>
                                    <td class="px-4 py-3">
                                        <span class="px-2 py-1 rounded text-xs bg-gray-100">{{ ucfirst($order->status) }}</span>
                                    </td>
                                    <td class="px-4 py-3 font-semibold">${{ number_format($order->total, 2) }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-600">{{ $order->created_at->format('M d, Y H:i') }}</td>
                                    <td class="px-4 py-3 text-right">
                                        <a href="{{ route('orders.show', $order) }}" class="text-yellow-600 hover:text-yellow-700">View</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-6">{{ $orders->links() }}</div>
            @endif
        </div>
    </section>
</x-user-layout>

