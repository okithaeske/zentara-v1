<x-user-layout title="About">
    <x-slot name="header">
        <h1 class="text-2xl font-semibold text-gray-900">About</h1>
    </x-slot>

    <section class="py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="prose max-w-none">
                <p>
                    This is the About page of {{ config('app.name', 'Laravel') }}.
                </p>
                <p>
                    Replace this content with your company story, mission, and team info.
                </p>
            </div>
        </div>
    </section>
</x-user-layout>

