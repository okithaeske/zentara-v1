@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-yellow-200">Admin Dashboard</h1>
            <p class="text-sm text-gray-300">Store-wide metrics and controls</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.users.index') }}" class="px-3 py-2 rounded-md bg-white/10 text-gray-100 text-sm">Manage Users</a>
        </div>
    </div>

    <!-- KPIs -->
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-5 gap-4">
        <div class="glass rounded-xl p-4 border border-yellow-500/10">
            <div class="text-gray-300 text-sm">Users</div>
            <div class="mt-2 text-2xl font-semibold text-yellow-200">{{ $totalUsers }}</div>
        </div>
        <div class="glass rounded-xl p-4 border border-yellow-500/10">
            <div class="text-gray-300 text-sm">Sellers</div>
            <div class="mt-2 text-2xl font-semibold text-yellow-200">{{ $totalSellers }}</div>
        </div>
        <div class="glass rounded-xl p-4 border border-yellow-500/10">
            <div class="text-gray-300 text-sm">Products</div>
            <div class="mt-2 text-2xl font-semibold text-yellow-200">{{ $totalProducts }}</div>
        </div>
        <div class="glass rounded-xl p-4 border border-yellow-500/10">
            <div class="text-gray-300 text-sm">Orders (Paid)</div>
            <div class="mt-2 text-2xl font-semibold text-yellow-200">{{ $paidOrders }}/{{ $totalOrders }}</div>
        </div>
        <div class="glass rounded-xl p-4 border border-yellow-500/10">
            <div class="text-gray-300 text-sm">GMV (30d)</div>
            <div class="mt-2 text-2xl font-semibold text-yellow-200">${{ number_format($gmv30, 2) }}</div>
        </div>
    </div>

    <!-- Revenue breakdown -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="glass rounded-xl p-4 border border-yellow-500/10">
            <div class="text-gray-300 text-sm">Total GMV (Paid)</div>
            <div class="mt-2 text-2xl font-semibold text-yellow-200">${{ number_format($gmv, 2) }}</div>
        </div>
        <div class="glass rounded-xl p-4 border border-yellow-500/10">
            <div class="text-gray-300 text-sm">Customer Fees (2.5%)</div>
            <div class="mt-2 text-2xl font-semibold text-yellow-200">${{ number_format($customerFees, 2) }}</div>
        </div>
        <div class="glass rounded-xl p-4 border border-yellow-500/10">
            <div class="text-gray-300 text-sm">Seller Fees (3%)</div>
            <div class="mt-2 text-2xl font-semibold text-yellow-200">${{ number_format($sellerFees, 2) }}</div>
        </div>
    </div>
    <div class="glass rounded-xl p-4 border border-yellow-500/10">
        <div class="text-gray-300 text-sm">Platform Revenue (5.5%)</div>
        <div class="mt-2 text-2xl font-semibold text-yellow-200">${{ number_format($platformRevenue, 2) }}</div>
    </div>

    <!-- Top Sellers -->
    <div class="glass rounded-xl border border-yellow-500/10 overflow-hidden">
        <div class="p-4 border-b border-white/5 flex items-center justify-between">
            <h2 class="text-base font-semibold text-yellow-200">Top Sellers</h2>
            <span class="text-xs text-gray-400">by revenue (paid)</span>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="text-left text-gray-400">
                    <tr>
                        <th class="px-4 py-3">Seller</th>
                        <th class="px-4 py-3">Email</th>
                        <th class="px-4 py-3">Sold Qty</th>
                        <th class="px-4 py-3">Revenue</th>
                        <th class="px-4 py-3">Est. Fees (5.5%)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse ($topSellers as $row)
                        <tr>
                            <td class="px-4 py-3 text-gray-200">{{ $row['seller']?->name ?? 'Unknown' }}</td>
                            <td class="px-4 py-3 text-gray-400">{{ $row['seller']?->email ?? '—' }}</td>
                            <td class="px-4 py-3 text-gray-300">{{ $row['qty'] }}</td>
                            <td class="px-4 py-3 text-gray-300">${{ number_format($row['revenue'], 2) }}</td>
                            <td class="px-4 py-3 text-gray-300">${{ number_format($row['revenue'] * 0.055, 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-6 text-center text-gray-400">No sales yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
