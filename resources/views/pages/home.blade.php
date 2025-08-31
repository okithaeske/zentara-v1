<x-user-layout title="Home">
    <!-- Hero Section -->
    <section class="relative bg-gradient-to-br from-gray-900 via-black to-gray-800 text-white overflow-hidden">
        <!-- Background Video -->
        <video autoplay muted loop playsinline class="absolute inset-0 w-full h-full object-cover z-0">
            <source src="\vids\heroindex.mp4" type="video/mp4">
            <source src="/videos/hero-background.webm" type="video/webm">
            <!-- Fallback for browsers that don't support video -->
            Your browser does not support the video tag.
        </video>

        <!-- Dark overlay for better text readability -->
        <div class="absolute inset-0 bg-black opacity-60 z-10"></div>

        <!-- Content -->
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 lg:py-32 z-20">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div class="space-y-8">
                    <div class="space-y-4">
                        <h1 class="text-5xl lg:text-7xl font-bold leading-tight">
                            <span class="block text-white">Timeless</span>
                            <span class="block text-yellow-500">Elegance</span>
                        </h1>
                        <p class="text-xl text-gray-300 leading-relaxed max-w-lg">
                            Discover our curated collection of luxury timepieces from the world's most prestigious
                            watchmakers.
                        </p>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="{{ Route::has('collections') ? route('collections') : '#' }}"
                            class="inline-flex items-center justify-center px-8 py-4 bg-yellow-500 text-black font-semibold rounded-lg hover:bg-yellow-400 transform hover:scale-105 transition-all duration-300 shadow-xl">
                            Explore Collection
                            <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 7l5 5m0 0l-5 5m5-5H6" />
                            </svg>
                        </a>
                        <a href="{{ route('about') }}"
                            class="inline-flex items-center justify-center px-8 py-4 border-2 border-yellow-500 text-yellow-500 font-semibold rounded-lg hover:bg-yellow-500 hover:text-black transition-all duration-300">
                            Our Heritage
                        </a>
                    </div>
                </div>
                <div class="relative">
                    <!-- Hero watch image -->
                    <div class="aspect-square rounded-2xl shadow-2xl overflow-hidden border border-yellow-500/20">
                        <img src="\images\hero.jpeg" alt="Hero Watch" class="w-full h-full object-cover" />
                    </div>
                    <!-- Decorative elements -->
                    <div
                        class="absolute -top-4 -right-4 w-72 h-72 bg-yellow-500 rounded-full mix-blend-multiply filter blur-xl opacity-10 animate-pulse">
                    </div>
                    <div
                        class="absolute -bottom-8 -left-4 w-72 h-72 bg-yellow-600 rounded-full mix-blend-multiply filter blur-xl opacity-10 animate-pulse">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Featured Categories -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Shop by Category</h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">From classic dress watches to modern sports
                    timepieces, find the perfect watch for every occasion.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Luxury Category -->
                <div
                    class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 overflow-hidden">
                    <div class="aspect-[4/3] overflow-hidden">
                        <img src="\images\lux.jpeg" alt="Luxury Watch"
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" />
                    </div>
                    <div class="p-6">
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">Luxury Collection</h3>
                        <p class="text-gray-600 mb-6">Exquisite timepieces from prestigious Swiss maisons</p>
                        <a href="{{ Route::has('luxury') ? route('luxury') : '#' }}"
                            class="inline-flex items-center text-yellow-600 font-semibold hover:text-yellow-700 transition-colors">
                            Explore Luxury
                            <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 7l5 5m0 0l-5 5m5-5H6" />
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Sports Category -->
                <div
                    class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 overflow-hidden">
                    <div class="aspect-[4/3] overflow-hidden">
                        <img src="\images\sports.jpeg" alt="Sports Watch"
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" />
                    </div>
                    <div class="p-6">
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">Sports Collection</h3>
                        <p class="text-gray-600 mb-6">Professional timepieces built for performance</p>
                        <a href=""
                            class="inline-flex items-center text-blue-600 font-semibold hover:text-blue-700 transition-colors">
                            Shop Sports
                            <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 7l5 5m0 0l-5 5m5-5H6" />
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Classic Category -->
                <div
                    class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 overflow-hidden">
                    <div class="aspect-[4/3] overflow-hidden">
                        <img src="\images\classic.jpeg" alt="Classic Watch"
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" />
                    </div>
                    <div class="p-6">
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">Classic Collection</h3>
                        <p class="text-gray-600 mb-6">Timeless designs for the discerning gentleman</p>
                        <a href=""
                            class="inline-flex items-center text-amber-600 font-semibold hover:text-amber-700 transition-colors">
                            View Classic
                            <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 7l5 5m0 0l-5 5m5-5H6" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Products -->
    <section class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Featured Timepieces</h2>
                <p class="text-xl text-gray-600">Handpicked selections from our master horologists</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Product 1 -->
                <div
                    class="group bg-white rounded-xl shadow-md hover:shadow-2xl transition-all duration-500 overflow-hidden">
                    <div
                        class="aspect-square bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center relative overflow-hidden">
                        <div class="text-center space-y-2">
                            <svg class="w-12 h-12 text-gray-400 mx-auto" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm0-14c-3.31 0-6 2.69-6 6s2.69 6 6 6 6-2.69 6-6-2.69-6-6-6zm3 8h-4V8h2v4h2v2z" />
                            </svg>
                            <p class="text-xs text-gray-500">Product Image</p>
                        </div>
                        <!-- Hover overlay -->
                        <div
                            class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                            <button
                                class="bg-yellow-500 text-black px-4 py-2 rounded-lg font-semibold transform translate-y-4 group-hover:translate-y-0 transition-transform duration-300">
                                Quick View
                            </button>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Swiss Master Classic</h3>
                        <p class="text-gray-600 text-sm mb-4">Elegant dress watch with leather strap</p>
                        <div class="flex items-center justify-between">
                            <span class="text-2xl font-bold text-gray-900">$2,499</span>
                            <button
                                class="bg-gray-900 text-white px-4 py-2 rounded-lg hover:bg-gray-800 transition-colors">
                                Add to Cart
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Product 2 -->
                <div
                    class="group bg-white rounded-xl shadow-md hover:shadow-2xl transition-all duration-500 overflow-hidden">
                    <div
                        class="aspect-square bg-gradient-to-br from-blue-100 to-blue-200 flex items-center justify-center relative overflow-hidden">
                        <div class="text-center space-y-2">
                            <svg class="w-12 h-12 text-blue-400 mx-auto" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm0-14c-3.31 0-6 2.69-6 6s2.69 6 6 6 6-2.69 6-6-2.69-6-6-6zm3 8h-4V8h2v4h2v2z" />
                            </svg>
                            <p class="text-xs text-gray-500">Product Image</p>
                        </div>
                        <div
                            class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                            <button
                                class="bg-yellow-500 text-black px-4 py-2 rounded-lg font-semibold transform translate-y-4 group-hover:translate-y-0 transition-transform duration-300">
                                Quick View
                            </button>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Ocean Explorer Pro</h3>
                        <p class="text-gray-600 text-sm mb-4">Professional diving watch, 300m water resistant</p>
                        <div class="flex items-center justify-between">
                            <span class="text-2xl font-bold text-gray-900">$3,299</span>
                            <button
                                class="bg-gray-900 text-white px-4 py-2 rounded-lg hover:bg-gray-800 transition-colors">
                                Add to Cart
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Product 3 -->
                <div
                    class="group bg-white rounded-xl shadow-md hover:shadow-2xl transition-all duration-500 overflow-hidden">
                    <div
                        class="aspect-square bg-gradient-to-br from-rose-100 to-rose-200 flex items-center justify-center relative overflow-hidden">
                        <div class="text-center space-y-2">
                            <svg class="w-12 h-12 text-rose-400 mx-auto" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm0-14c-3.31 0-6 2.69-6 6s2.69 6 6 6 6-2.69 6-6-2.69-6-6-6zm3 8h-4V8h2v4h2v2z" />
                            </svg>
                            <p class="text-xs text-gray-500">Product Image</p>
                        </div>
                        <div
                            class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                            <button
                                class="bg-yellow-500 text-black px-4 py-2 rounded-lg font-semibold transform translate-y-4 group-hover:translate-y-0 transition-transform duration-300">
                                Quick View
                            </button>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Rose Gold Elegance</h3>
                        <p class="text-gray-600 text-sm mb-4">Sophisticated ladies' timepiece with diamond accents</p>
                        <div class="flex items-center justify-between">
                            <span class="text-2xl font-bold text-gray-900">$4,799</span>
                            <button
                                class="bg-gray-900 text-white px-4 py-2 rounded-lg hover:bg-gray-800 transition-colors">
                                Add to Cart
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Product 4 -->
                <div
                    class="group bg-white rounded-xl shadow-md hover:shadow-2xl transition-all duration-500 overflow-hidden">
                    <div
                        class="aspect-square bg-gradient-to-br from-green-100 to-green-200 flex items-center justify-center relative overflow-hidden">
                        <div class="text-center space-y-2">
                            <svg class="w-12 h-12 text-green-500 mx-auto" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm0-14c-3.31 0-6 2.69-6 6s2.69 6 6 6 6-2.69 6-6-2.69-6-6-6zm3 8h-4V8h2v4h2v2z" />
                            </svg>
                            <p class="text-xs text-gray-500">Product Image</p>
                        </div>
                        <div
                            class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                            <button
                                class="bg-yellow-500 text-black px-4 py-2 rounded-lg font-semibold transform translate-y-4 group-hover:translate-y-0 transition-transform duration-300">
                                Quick View
                            </button>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Vintage Heritage</h3>
                        <p class="text-gray-600 text-sm mb-4">Classic mechanical movement with modern reliability</p>
                        <div class="flex items-center justify-between">
                            <span class="text-2xl font-bold text-gray-900">$1,899</span>
                            <button
                                class="bg-gray-900 text-white px-4 py-2 rounded-lg hover:bg-gray-800 transition-colors">
                                Add to Cart
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Brand Story Section -->
    <section class="py-20 bg-gray-900 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <div>
                    <h2 class="text-4xl font-bold mb-6">Crafted for Generations</h2>
                    <p class="text-xl text-gray-300 mb-8 leading-relaxed">
                        For over a century, Zentara has been synonymous with precision, elegance, and innovation.
                        Each timepiece in our collection represents the pinnacle of horological artistry,
                        meticulously crafted by master watchmakers who understand that time is the most precious gift.
                    </p>
                    <div class="grid grid-cols-2 gap-8">
                        <div class="text-center">
                            <div class="text-3xl font-bold text-yellow-500 mb-2">150+</div>
                            <div class="text-gray-400">Years of Heritage</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-yellow-500 mb-2">50,000+</div>
                            <div class="text-gray-400">Satisfied Customers</div>
                        </div>
                    </div>
                    <a href="{{ route('about') }}"
                        class="inline-flex items-center mt-8 text-yellow-500 font-semibold hover:text-yellow-400 transition-colors">
                        Discover Our Story
                        <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7l5 5m0 0l-5 5m5-5H6" />
                        </svg>
                    </a>
                </div>
                <div class="relative">
                    <div
                        class="aspect-[4/3] bg-gradient-to-br from-gray-700 to-gray-900 rounded-2xl shadow-2xl flex items-center justify-center border border-yellow-500/20">
                        <img src="\images\brand_image.png" alt="brand image">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Premium Services</h2>
                <p class="text-xl text-gray-600">Experience luxury beyond the timepiece</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Service 1 -->
                <div class="text-center group">
                    <div
                        class="w-16 h-16 bg-yellow-500 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Lifetime Warranty</h3>
                    <p class="text-gray-600">Comprehensive protection for your investment with our exclusive lifetime
                        warranty program.</p>
                </div>

                <!-- Service 2 -->
                <div class="text-center group">
                    <div
                        class="w-16 h-16 bg-yellow-500 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Express Delivery</h3>
                    <p class="text-gray-600">Secure, insured delivery worldwide with white-glove service and signature
                        confirmation.</p>
                </div>

                <!-- Service 3 -->
                <div class="text-center group">
                    <div
                        class="w-16 h-16 bg-yellow-500 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Expert Service</h3>
                    <p class="text-gray-600">Professional maintenance and repair by certified horologists with genuine
                        parts only.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Newsletter Section -->
    <section class="py-20 bg-gradient-to-r from-gray-900 to-black text-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-4xl font-bold mb-4">Stay Connected</h2>
            <p class="text-xl text-gray-300 mb-8">Be the first to know about new arrivals, exclusive events, and
                horological insights.</p>

            <form class="flex flex-col sm:flex-row gap-4 max-w-md mx-auto">
                <input type="email" placeholder="Enter your email"
                    class="flex-1 px-6 py-4 rounded-lg bg-white/10 border border-gray-600 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                <button type="submit"
                    class="px-8 py-4 bg-yellow-500 text-black font-semibold rounded-lg hover:bg-yellow-400 transform hover:scale-105 transition-all duration-300 shadow-lg">
                    Subscribe
                </button>
            </form>
        </div>
    </section>

    <!-- Features Banner -->
    <section class="py-16 bg-gray-50 border-t border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 text-center">
                <div class="flex flex-col items-center space-y-3">
                    <svg class="w-8 h-8 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                    <h4 class="font-semibold text-gray-900">Authentic Guarantee</h4>
                    <p class="text-sm text-gray-600">100% authentic timepieces</p>
                </div>

                <div class="flex flex-col items-center space-y-3">
                    <svg class="w-8 h-8 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                    </svg>
                    <h4 class="font-semibold text-gray-900">Secure Payment</h4>
                    <p class="text-sm text-gray-600">Protected transactions</p>
                </div>

                <div class="flex flex-col items-center space-y-3">
                    <svg class="w-8 h-8 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                    <h4 class="font-semibold text-gray-900">Fast Shipping</h4>
                    <p class="text-sm text-gray-600">Express worldwide delivery</p>
                </div>

                <div class="flex flex-col items-center space-y-3">
                    <svg class="w-8 h-8 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <h4 class="font-semibold text-gray-900">Expert Support</h4>
                    <p class="text-sm text-gray-600">Horological consultants</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="py-20 bg-gradient-to-br from-yellow-500 to-amber-600 text-black">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-4xl font-bold mb-4">Find Your Perfect Timepiece</h2>
            <p class="text-xl mb-8 opacity-80">Join thousands of satisfied customers who trust Zentara for their luxury
                watch needs.</p>

            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ Route::has('collections') ? route('collections') : '#' }}"
                    class="inline-flex items-center justify-center px-8 py-4 bg-black text-white font-semibold rounded-lg hover:bg-gray-800 transform hover:scale-105 transition-all duration-300 shadow-lg">
                    Shop All Watches
                    <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 7l5 5m0 0l-5 5m5-5H6" />
                    </svg>
                </a>
                <a href="{{ route('contact') }}"
                    class="inline-flex items-center justify-center px-8 py-4 border-2 border-black text-black font-semibold rounded-lg hover:bg-black hover:text-yellow-500 transition-all duration-300">
                    Schedule Consultation
                </a>
            </div>
        </div>
    </section>
</x-user-layout>