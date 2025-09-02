@extends('layouts.seller')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-semibold text-yellow-200">Add Product</h1>
        <p class="text-sm text-gray-300">Create a new watch listing</p>
    </div>

    <div class="glass rounded-xl border border-yellow-500/10 p-6">
        <form class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <label class="block">
                    <span class="text-sm text-gray-300">Name</span>
                    <input type="text" class="mt-1 w-full px-3 py-2 rounded bg-white/5 text-gray-100 border border-white/10" placeholder="Zentara Chrono S" />
                </label>
                <label class="block">
                    <span class="text-sm text-gray-300">SKU</span>
                    <input type="text" class="mt-1 w-full px-3 py-2 rounded bg-white/5 text-gray-100 border border-white/10" placeholder="ZT-CHR-001" />
                </label>
                <label class="block">
                    <span class="text-sm text-gray-300">Price</span>
                    <input type="number" step="0.01" class="mt-1 w-full px-3 py-2 rounded bg-white/5 text-gray-100 border border-white/10" placeholder="999.99" />
                </label>
                <label class="block">
                    <span class="text-sm text-gray-300">Stock</span>
                    <input type="number" class="mt-1 w-full px-3 py-2 rounded bg-white/5 text-gray-100 border border-white/10" placeholder="10" />
                </label>
            </div>
            <label class="block">
                <span class="text-sm text-gray-300">Description</span>
                <textarea rows="4" class="mt-1 w-full px-3 py-2 rounded bg-white/5 text-gray-100 border border-white/10" placeholder="Details about movement, case, strap, etc."></textarea>
            </label>
            <div class="flex items-center gap-3">
                <button type="button" class="px-4 py-2 rounded bg-yellow-500 text-gray-900 font-semibold">Save Draft</button>
                <button type="button" class="px-4 py-2 rounded bg-white/10">Publish</button>
            </div>
        </form>
    </div>
</div>
@endsection

