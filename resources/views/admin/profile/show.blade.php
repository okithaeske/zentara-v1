@extends('layouts.admin')

@section('content')
@php($user = auth()->user())

<div class="space-y-8">
    <div>
        <h1 class="text-2xl font-semibold text-yellow-200">Profile</h1>
        <p class="text-sm text-gray-300">Update your administrator identity and security details here.</p>
    </div>

    @include('profile.partials.dashboard-summary', ['user' => $user, 'roleLabel' => 'Admin'])

    <div class="rounded-2xl border border-white/10 bg-white/95 text-gray-900 shadow-xl">
        <div class="space-y-10 p-6 sm:p-10">
            @include('profile.partials.forms')
        </div>
    </div>
</div>
@endsection
