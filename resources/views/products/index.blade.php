<x-user-layout title="Products">
    <!-- Hero Section with Gradient Background -->
    <div class="relative bg-gradient-to-br from-slate-900 via-gray-900 to-black">
        <div class="absolute inset-0 bg-black/20"></div>
        <div class="relative py-20 px-4">
            <div class="max-w-7xl mx-auto text-center">
                <h1 class="text-5xl md:text-6xl font-light text-white mb-4 tracking-wider">
                    Our <span
                        class="font-bold bg-gradient-to-r from-yellow-400 to-yellow-600 bg-clip-text text-transparent">Collection</span>
                </h1>
                <p class="text-xl text-gray-300 max-w-2xl mx-auto leading-relaxed">
                    Discover handcrafted excellence. Each piece tells a story of uncompromising quality and timeless
                    design.
                </p>
            </div>
        </div>
    </div>

    <!-- Main Products Section -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <livewire:products.index />
        </div>
    </section>

    <!-- Newsletter/CTA Section -->
    <section class="py-20 bg-gradient-to-r from-gray-900 to-black">
        <div class="max-w-4xl mx-auto text-center px-4">
            <h2 class="text-4xl font-light text-white mb-4">
                Stay in the <span
                    class="font-bold bg-gradient-to-r from-yellow-400 to-yellow-600 bg-clip-text text-transparent">Loop</span>
            </h2>
            <p class="text-xl text-gray-300 mb-8 max-w-2xl mx-auto">
                Be the first to discover new arrivals, exclusive collections, and special offers from our luxury
                catalog.
            </p>
            <div class="max-w-md mx-auto flex gap-2">
                <input type="email" placeholder="Enter your email"
                    class="flex-1 px-6 py-4 rounded-xl border-0 focus:outline-none focus:ring-4 focus:ring-yellow-500/20" />
                <button
                    class="px-8 py-4 bg-gradient-to-r from-yellow-500 to-yellow-600 text-white rounded-xl font-medium hover:from-yellow-600 hover:to-yellow-700 transition-all duration-300 shadow-lg">
                    Subscribe
                </button>
            </div>
        </div>
    </section>
</x-user-layout>
