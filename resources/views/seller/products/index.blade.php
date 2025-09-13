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

    <livewire:seller.products-table />
</div>
@endsection
