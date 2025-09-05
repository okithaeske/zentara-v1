@extends('layouts.seller')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-semibold text-yellow-200">Payouts</h1>
        <p class="text-sm text-gray-300">Balance, next payout, and statements</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="glass rounded-xl p-4 border border-yellow-500/10">
            <div class="text-gray-300 text-sm">Current Balance</div>
            <div class="text-2xl font-semibold text-yellow-200 mt-2">${{ number_format($currentBalance ?? 0, 2) }}</div>
        </div>
        <div class="glass rounded-xl p-4 border border-yellow-500/10">
            <div class="text-gray-300 text-sm">Next Payout</div>
            <div class="text-2xl font-semibold text-yellow-200 mt-2">—</div>
        </div>
        <div class="glass rounded-xl p-4 border border-yellow-500/10">
            <div class="text-gray-300 text-sm">Fees (30d)</div>
            <div class="text-2xl font-semibold text-yellow-200 mt-2">${{ number_format($fees30d ?? 0, 2) }}</div>
        </div>
    </div>

    <div class="glass rounded-xl border border-yellow-500/10 overflow-hidden">
        <div class="p-4 border-b border-white/5">Recent Payouts</div>
        <div class="p-4 text-gray-300">No payouts yet.</div>
    </div>
</div>
@endsection
