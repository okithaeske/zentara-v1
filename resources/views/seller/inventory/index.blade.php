@extends('layouts.seller')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-semibold text-yellow-200">Inventory</h1>
        <p class="text-sm text-gray-300">Stock levels and alerts</p>
    </div>

    <livewire:seller.inventory-table />
</div>
@endsection
