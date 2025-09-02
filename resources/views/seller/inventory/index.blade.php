@extends('layouts.seller')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-semibold text-yellow-200">Inventory</h1>
        <p class="text-sm text-gray-300">Stock levels and alerts</p>
    </div>

    <div class="glass rounded-xl border border-yellow-500/10 p-6">
        <div class="text-gray-300">No low-stock items. Set thresholds per product to get alerts.</div>
    </div>
</div>
@endsection

