@extends('layouts.seller')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-yellow-200">Products</h1>
            <p class="text-sm text-gray-300">Manage your watch listings</p>
        </div>
        <a href="{{ route('seller.products.create') }}" class="px-3 py-2 rounded-md bg-yellow-500 text-gray-900 text-sm font-semibold">Add Product</a>
    </div>

    <div class="glass rounded-xl border border-yellow-500/10 overflow-hidden">
        <div class="p-4 border-b border-white/5 flex items-center gap-3">
            <input type="text" placeholder="Search products..." class="w-full px-3 py-2 rounded bg-white/5 text-gray-100 placeholder-gray-400 border border-white/10" />
            <button class="px-3 py-2 rounded bg-white/10 text-sm">Filter</button>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="text-left text-gray-400">
                    <tr>
                        <th class="px-4 py-3">Product</th>
                        <th class="px-4 py-3">SKU</th>
                        <th class="px-4 py-3">Price</th>
                        <th class="px-4 py-3">Stock</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    <tr>
                        <td class="px-4 py-3 text-gray-300">—</td>
                        <td class="px-4 py-3 text-gray-300">—</td>
                        <td class="px-4 py-3 text-gray-300">—</td>
                        <td class="px-4 py-3 text-gray-300">—</td>
                        <td class="px-4 py-3"><span class="px-2 py-1 text-xs rounded bg-white/10 text-gray-300">Draft</span></td>
                        <td class="px-4 py-3 space-x-2">
                            <button class="px-2 py-1 text-xs rounded bg-white/10">Edit</button>
                            <button class="px-2 py-1 text-xs rounded bg-white/10">Disable</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

