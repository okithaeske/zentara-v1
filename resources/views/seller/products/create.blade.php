@extends('layouts.seller')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-semibold text-yellow-200">Add Product</h1>
        <p class="text-sm text-gray-300">Create a new watch listing</p>
    </div>

    @if ($errors->any())
        <div class="px-4 py-2 rounded bg-red-600/20 text-red-300 border border-red-600/30">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="glass rounded-xl border border-yellow-500/10 p-6">
        <form class="space-y-4" method="POST" action="{{ route('seller.products.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <label class="block">
                    <span class="text-sm text-gray-300">Name</span>
                    <input name="name" type="text" class="mt-1 w-full px-3 py-2 rounded bg-white/5 text-gray-100 border border-white/10" value="{{ old('name') }}" placeholder="Zentara Chrono S" />
                </label>
                <label class="block">
                    <span class="text-sm text-gray-300">SKU</span>
                    <input name="sku" type="text" class="mt-1 w-full px-3 py-2 rounded bg-white/5 text-gray-100 border border-white/10" value="{{ old('sku') }}" placeholder="ZT-CHR-001" />
                </label>
                <label class="block">
                    <span class="text-sm text-gray-300">Price</span>
                    <input name="price" type="number" step="0.01" class="mt-1 w-full px-3 py-2 rounded bg-white/5 text-gray-100 border border-white/10" value="{{ old('price') }}" placeholder="999.99" />
                </label>
                <label class="block">
                    <span class="text-sm text-gray-300">Stock</span>
                    <input name="stock" type="number" class="mt-1 w-full px-3 py-2 rounded bg-white/5 text-gray-100 border border-white/10" value="{{ old('stock') }}" placeholder="10" />
                </label>
            </div>
            <label class="block">
                <span class="text-sm text-gray-300">Image</span>
                <input name="image" type="file" accept="image/*" class="mt-1 w-full text-gray-100" />
                <p class="text-xs text-gray-400 mt-1">JPEG/PNG/GIF/WebP up to 5MB.</p>
            </label>
            <label class="block">
                <span class="text-sm text-gray-300">Description</span>
                <textarea name="description" rows="4" class="mt-1 w-full px-3 py-2 rounded bg-white/5 text-gray-100 border border-white/10" placeholder="Details about movement, case, strap, etc.">{{ old('description') }}</textarea>
            </label>
            <div class="flex items-center gap-3">
                <button name="action" value="draft" class="px-4 py-2 rounded bg-yellow-500 text-gray-900 font-semibold">Save Draft</button>
                <button name="action" value="publish" class="px-4 py-2 rounded bg-white/10">Publish</button>
            </div>
        </form>
    </div>
</div>
@endsection
