@extends('layouts.admin')

@section('content')
@php($title = $seller->name . ' — Products')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-yellow-200">{{ $seller->name }}</h1>
            <p class="text-sm text-gray-300">Products by this seller</p>
        </div>
        <form method="GET" class="flex items-center gap-2">
            <input type="search" name="q" value="{{ request('q') }}" placeholder="Search products..." class="px-3 py-2 rounded bg-white/5 text-gray-100 placeholder-gray-400 border border-white/10" />
            <button class="px-3 py-2 rounded bg-white/10 text-sm text-gray-100">Search</button>
        </form>
    </div>

    <div class="glass rounded-xl border border-yellow-500/10 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="text-left text-gray-400">
                    <tr>
                        <th class="px-4 py-3">Product</th>
                        <th class="px-4 py-3">SKU</th>
                        <th class="px-4 py-3">Price</th>
                        <th class="px-4 py-3">Stock</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse ($products as $product)
                        <tr>
                            <td class="px-4 py-3 text-gray-100">{{ $product->name }}</td>
                            <td class="px-4 py-3 text-gray-300">{{ $product->sku }}</td>
                            <td class="px-4 py-3 text-gray-300">${{ number_format($product->price, 2) }}</td>
                            <td class="px-4 py-3 text-gray-300">{{ $product->stock }}</td>
                            <td class="px-4 py-3"><span class="px-2 py-1 text-xs rounded bg-white/10 text-gray-300">{{ ucfirst($product->status) }}</span></td>
                            <td class="px-4 py-3 text-right space-x-2">
                                <a href="{{ route('seller.products.edit', $product) }}" class="px-2 py-1 text-xs rounded bg-yellow-500 text-gray-900">Edit</a>
                                <form method="POST" action="{{ route('admin.products.update-status', $product) }}" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="{{ $product->status === 'published' ? 'draft' : 'published' }}" />
                                    <button class="px-2 py-1 text-xs rounded {{ $product->status === 'published' ? 'bg-white/10 text-gray-200' : 'bg-green-500 text-gray-900' }}">
                                        {{ $product->status === 'published' ? 'Unpublish' : 'Publish' }}
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('admin.products.destroy', $product) }}" class="inline" onsubmit="return confirm('Delete this product? This cannot be undone.');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="px-2 py-1 text-xs rounded bg-red-600 text-white">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-6 text-center text-gray-400">No products found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4">
            {{ $products->links() }}
        </div>
    </div>
</div>
@endsection
