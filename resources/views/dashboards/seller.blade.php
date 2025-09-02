@php($title = 'Dashboard')
@extends('layouts.seller')

@section('content')
    <div class="space-y-6">
        <!-- Heading -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-yellow-200">Seller Dashboard</h1>
                <p class="text-sm text-gray-300">Quick overview of your watch store</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('seller.products.create') }}" class="px-3 py-2 rounded-md bg-yellow-500 text-gray-900 text-sm font-semibold">Add Product</a>
                <a href="#" class="px-3 py-2 rounded-md bg-white/10 text-gray-100 text-sm">Create Discount</a>
            </div>
        </div>

        <!-- KPIs -->
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
            <div class="glass rounded-xl p-4 border border-yellow-500/10">
                <div class="text-gray-300 text-sm">Today Revenue</div>
                <div class="mt-2 flex items-end justify-between">
                    <div class="text-2xl font-semibold text-yellow-200">$0.00</div>
                    <div class="text-xs text-gray-400">+0.0%</div>
                </div>
            </div>
            <div class="glass rounded-xl p-4 border border-yellow-500/10">
                <div class="text-gray-300 text-sm">Orders to Fulfill</div>
                <div class="mt-2 flex items-end justify-between">
                    <div class="text-2xl font-semibold text-yellow-200">0</div>
                    <div class="text-xs text-gray-400">SLA: —</div>
                </div>
            </div>
            <div class="glass rounded-xl p-4 border border-yellow-500/10">
                <div class="text-gray-300 text-sm">Low Stock Alerts</div>
                <div class="mt-2 flex items-end justify-between">
                    <div class="text-2xl font-semibold text-yellow-200">0</div>
                    <div class="text-xs text-gray-400">Threshold: 5</div>
                </div>
            </div>
            <div class="glass rounded-xl p-4 border border-yellow-500/10">
                <div class="text-gray-300 text-sm">Store Rating</div>
                <div class="mt-2 flex items-end justify-between">
                    <div class="text-2xl font-semibold text-yellow-200">—</div>
                    <div class="text-xs text-gray-400">0 reviews</div>
                </div>
            </div>
        </div>

        <!-- Two-column: Recent Orders + Top Products -->
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-4">
            <!-- Recent Orders -->
            <div class="xl:col-span-2 glass rounded-xl border border-yellow-500/10">
                <div class="p-4 border-b border-white/5 flex items-center justify-between">
                    <h2 class="text-base font-semibold text-yellow-200">Recent Orders</h2>
                    <a href="#" class="text-xs text-yellow-300 hover:underline">View all</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="text-left text-gray-400">
                            <tr>
                                <th class="px-4 py-3">Order</th>
                                <th class="px-4 py-3">Customer</th>
                                <th class="px-4 py-3">Items</th>
                                <th class="px-4 py-3">Total</th>
                                <th class="px-4 py-3">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5">
                            <tr>
                                <td class="px-4 py-3 text-gray-300">—</td>
                                <td class="px-4 py-3 text-gray-300">—</td>
                                <td class="px-4 py-3 text-gray-300">—</td>
                                <td class="px-4 py-3 text-gray-300">—</td>
                                <td class="px-4 py-3"><span class="px-2 py-1 text-xs rounded bg-white/10 text-gray-300">—</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Top Products -->
            <div class="glass rounded-xl border border-yellow-500/10">
                <div class="p-4 border-b border-white/5 flex items-center justify-between">
                    <h2 class="text-base font-semibold text-yellow-200">Top Products</h2>
                    <a href="#" class="text-xs text-yellow-300 hover:underline">Manage</a>
                </div>
                <ul class="divide-y divide-white/5">
                    <li class="p-4 flex items-center gap-3">
                        <div class="w-10 h-10 rounded bg-white/10"></div>
                        <div class="flex-1">
                            <div class="text-sm text-gray-200">—</div>
                            <div class="text-xs text-gray-400">0 sold</div>
                        </div>
                        <div class="text-sm text-yellow-200">$0</div>
                    </li>
                    <li class="p-4 flex items-center gap-3">
                        <div class="w-10 h-10 rounded bg-white/10"></div>
                        <div class="flex-1">
                            <div class="text-sm text-gray-200">—</div>
                            <div class="text-xs text-gray-400">0 sold</div>
                        </div>
                        <div class="text-sm text-yellow-200">$0</div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endsection
