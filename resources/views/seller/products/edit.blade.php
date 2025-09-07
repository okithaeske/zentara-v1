@extends('layouts.seller')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-yellow-200">Edit Product</h1>
            <p class="text-sm text-gray-300">Update your listing</p>
        </div>
        <a href="{{ route('seller.products.index') }}" class="px-3 py-2 rounded-md bg-white/10 text-sm">Back</a>
    </div>

    @if (session('status'))
        <div class="px-4 py-2 rounded bg-green-600/20 text-green-300 border border-green-600/30">
            {{ session('status') }}
        </div>
    @endif
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
        <form class="space-y-4" method="POST" action="{{ route('seller.products.update', $product) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <label class="block">
                    <span class="text-sm text-gray-300">Name</span>
                    <input name="name" type="text" class="mt-1 w-full px-3 py-2 rounded bg-white/5 text-gray-100 border border-white/10" value="{{ old('name', $product->name) }}" />
                </label>
                <label class="block">
                    <span class="text-sm text-gray-300">SKU</span>
                    <input name="sku" type="text" class="mt-1 w-full px-3 py-2 rounded bg-white/5 text-gray-100 border border-white/10" value="{{ old('sku', $product->sku) }}" />
                </label>
                <label class="block">
                    <span class="text-sm text-gray-300">Price</span>
                    <input name="price" type="number" step="0.01" class="mt-1 w-full px-3 py-2 rounded bg-white/5 text-gray-100 border border-white/10" value="{{ old('price', $product->price) }}" />
                </label>
                <label class="block">
                    <span class="text-sm text-gray-300">Stock</span>
                    <input name="stock" type="number" class="mt-1 w-full px-3 py-2 rounded bg-white/5 text-gray-100 border border-white/10" value="{{ old('stock', $product->stock) }}" />
                </label>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <span class="text-sm text-gray-300">Image</span>
                    <div class="mt-2 flex items-start gap-4">
                        @if ($product->image_path)
                            <img src="{{ Storage::url($product->image_path) }}" alt="Product image" class="h-24 w-24 object-cover rounded border border-white/10" />
                        @else
                            <div class="h-24 w-24 rounded bg-white/5 border border-white/10 flex items-center justify-center text-xs text-gray-400">No image</div>
                        @endif
                        <div class="flex-1">
                            <input name="image" type="file" accept="image/*" class="w-full text-gray-100" />
                            <p class="text-xs text-gray-400 mt-1">Upload to replace. JPEG/PNG/GIF/WebP up to 5MB.</p>
                            @if ($product->image_path)
                                <label class="inline-flex items-center gap-2 mt-2 text-sm text-gray-300">
                                    <input type="checkbox" name="remove_image" value="1" class="rounded bg-white/5 border-white/10" /> Remove current image
                                </label>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <label class="block">
                <span class="text-sm text-gray-300">Description</span>
                <textarea name="description" rows="4" class="mt-1 w-full px-3 py-2 rounded bg-white/5 text-gray-100 border border-white/10">{{ old('description', $product->description) }}</textarea>
            </label>
            <div class="flex items-center gap-3">
                <button name="action" value="draft" class="px-4 py-2 rounded bg-yellow-500 text-gray-900 font-semibold">Save Draft</button>
                <button name="action" value="publish" class="px-4 py-2 rounded bg-white/10">Publish</button>
            </div>
        </form>
        <form method="POST" action="{{ route('seller.products.destroy', $product) }}" class="mt-4">
            @csrf
            @method('DELETE')
            <button type="submit" class="px-4 py-2 rounded bg-red-600/20 border border-red-600/30" onclick="return confirm('Delete this product?')">Delete</button>
        </form>
    </div>
</div>
@endsection
