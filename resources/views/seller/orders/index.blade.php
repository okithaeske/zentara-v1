@extends('layouts.seller')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-semibold text-yellow-200">Orders</h1>
        <p class="text-sm text-gray-300">Orders containing your products</p>
    </div>

    <livewire:seller.orders-table />
</div>
@endsection
