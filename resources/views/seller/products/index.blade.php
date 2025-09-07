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

    @if (session('status'))
        <div class="px-4 py-2 rounded bg-green-600/20 text-green-300 border border-green-600/30">
            {{ session('status') }}
        </div>
    @endif

    <div class="glass rounded-xl border border-yellow-500/10 overflow-hidden">
        <form class="p-4 border-b border-white/5 flex items-center gap-3" method="GET" action="{{ route('seller.products.index') }}">
            <input name="q" value="{{ request('q') }}" type="text" placeholder="Search products (name or SKU)..." class="w-full px-3 py-2 rounded bg-white/5 text-gray-100 placeholder-gray-400 border border-white/10" />
            <select name="status" class="px-3 py-2 rounded bg-white/5 text-gray-100 border border-white/10">
                <option value="">All Statuses</option>
                <option value="draft" @selected(request('status')==='draft')>Draft</option>
                <option value="published" @selected(request('status')==='published')>Published</option>
            </select>
            <button class="px-3 py-2 rounded bg-white/10 text-sm">Apply</button>
            @if(request()->hasAny(['q','status']))
                <a href="{{ route('seller.products.index') }}" class="px-3 py-2 rounded bg-white/5 text-sm">Reset</a>
            @endif
        </form>
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="text-left text-gray-400">
                    <tr>
                        <th class="px-4 py-3">Image</th>
                        <th class="px-4 py-3">Product</th>
                        <th class="px-4 py-3">SKU</th>
                        <th class="px-4 py-3">Price</th>
                        <th class="px-4 py-3">Stock</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($products as $product)
                        <tr>
                            <td class="px-4 py-3">
                                @if ($product->image_path)
                                    <img src="{{ Storage::url($product->image_path) }}" alt="{{ $product->name }}" class="h-10 w-10 rounded object-cover border border-white/10" />
                                @else
                                    <div class="h-10 w-10 rounded bg-white/5 border border-white/10"></div>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-gray-300">{{ $product->name }}</td>
                            <td class="px-4 py-3 text-gray-300">{{ $product->sku }}</td>
                            <td class="px-4 py-3 text-gray-300">${{ number_format($product->price, 2) }}</td>
                            <td class="px-4 py-3 text-gray-300">{{ $product->stock }}</td>
                            <td class="px-4 py-3">
                                <span class="px-2 py-1 text-xs rounded bg-white/10 text-gray-300">{{ ucfirst($product->status) }}</span>
                            </td>
                            <td class="px-4 py-3 space-x-2">
                                <a href="{{ route('seller.products.edit', $product) }}" class="px-2 py-1 text-xs rounded bg-white/10">Edit</a>
                                <form action="{{ route('seller.products.destroy', $product) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-2 py-1 text-xs rounded bg-white/10" onclick="return confirm('Delete this product?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-6 text-center text-gray-400">No products yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-white/5">
            {{ $products->links() }}
        </div>
    </div>
</div>
@endsection
