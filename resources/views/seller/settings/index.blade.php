@extends('layouts.seller')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-semibold text-yellow-200">Settings</h1>
        <p class="text-sm text-gray-300">Store profile and preferences</p>
    </div>

    <div class="glass rounded-xl border border-yellow-500/10 p-6 space-y-4">
        <label class="block">
            <span class="text-sm text-gray-300">Store Name</span>
            <input type="text" class="mt-1 w-full px-3 py-2 rounded bg-white/5 text-gray-100 border border-white/10" placeholder="Your Store" />
        </label>
        <label class="block">
            <span class="text-sm text-gray-300">Support Email</span>
            <input type="email" class="mt-1 w-full px-3 py-2 rounded bg-white/5 text-gray-100 border border-white/10" placeholder="support@example.com" />
        </label>
        <div class="flex items-center gap-3">
            <button type="button" class="px-4 py-2 rounded bg-yellow-500 text-gray-900 font-semibold">Save</button>
            <button type="button" class="px-4 py-2 rounded bg-white/10">Cancel</button>
        </div>
    </div>
</div>
@endsection

