@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-yellow-200">Edit Product</h1>
            <p class="text-sm text-gray-300">Admin editing seller product</p>
        </div>
        <a href="{{ $return ?? route('admin.sellers.index') }}" class="px-3 py-2 rounded-md bg-white/10 text-sm">Back</a>
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
        <form class="space-y-4" method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @if(!empty($return))
                <input type="hidden" name="return" value="{{ $return }}">
            @endif
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
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <label class="block">
                    <span class="text-sm text-gray-300">Status</span>
                    <select name="status" class="mt-1 w-full px-3 py-2 rounded bg-white/5 text-gray-100 border border-white/10">
                        <option value="draft" @selected(old('status', $product->status)==='draft')>Draft</option>
                        <option value="published" @selected(old('status', $product->status)==='published')>Published</option>
                    </select>
                </label>
                <div></div>
            </div>
            <div class="flex items-center gap-3">
                <button name="action" value="draft" class="px-4 py-2 rounded bg-yellow-500 text-gray-900 font-semibold">Save Draft</button>
                <button name="action" value="publish" class="px-4 py-2 rounded bg-white/10">Publish</button>
            </div>
        </form>
    </div>
</div>
@endsection
