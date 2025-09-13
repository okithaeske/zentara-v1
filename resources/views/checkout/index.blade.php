<x-user-layout title="Checkout">
    <section class="py-10 bg-white text-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-2xl sm:text-3xl font-bold mb-6">Checkout</h1>

            @if ($errors->any())
                <div class="mb-4 p-3 rounded bg-red-50 text-red-800">{{ $errors->first() }}</div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <livewire:checkout.form />

                <livewire:checkout.summary />
            </div>
        </div>
    </section>
    
</x-user-layout>

