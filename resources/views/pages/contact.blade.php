<x-user-layout title="Contact">

    <section class="py-12">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header Section -->
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">We're Here to Support Your Journey</h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    Whether you have questions about meditation techniques, need technical support, or want to share
                    your experience,
                    we'd love to hear from you.
                </p>
            </div>

            <div class="grid lg:grid-cols-2 gap-12">
                <!-- Contact Form -->
                <div class="bg-white shadow-sm rounded-lg p-8">
                    <h3 class="text-xl font-semibold text-gray-900 mb-6">Send Us a Message</h3>

                    @if (session('success'))
                        <div class="mb-6 rounded-md bg-green-50 text-green-800 border border-green-200 px-4 py-3">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('contact.submit') }}" method="POST" class="space-y-6">
                        @csrf
                        <!-- Replace with a real POST route/Livewire component later -->

                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <label for="first_name" class="block text-sm font-medium text-gray-700 mb-2">First
                                    Name</label>
                                <input id="first_name" name="first_name" type="text"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm bg-white text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:ring-blue-500 focus:outline-none"
                                    placeholder="Sarah" />
                            </div>
                            <div>
                                <label for="last_name" class="block text-sm font-medium text-gray-700 mb-2">Last
                                    Name</label>
                                <input id="last_name" name="last_name" type="text"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm bg-white text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:ring-blue-500 focus:outline-none"
                                    placeholder="Johnson" />
                            </div>
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email
                                Address</label>
                            <input id="email" name="email" type="email"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm bg-white text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:ring-blue-500 focus:outline-none"
                                placeholder="sarah@example.com" />
                        </div>

                        <div>
                            <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">Subject</label>
                            <select id="subject" name="subject"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm bg-white text-gray-900 focus:border-blue-500 focus:ring-blue-500 focus:outline-none">
                                <option value="">Choose a topic...</option>
                                <option value="meditation_guidance">Meditation Guidance</option>
                                <option value="technical_support">Technical Support</option>
                                <option value="billing_subscription">Billing & Subscription</option>
                                <option value="partnership">Partnership Opportunities</option>
                                <option value="feedback">Feedback & Suggestions</option>
                                <option value="other">Other</option>
                            </select>
                        </div>

                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700 mb-2">Message</label>
                            <textarea id="message" name="message" rows="6"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm bg-white text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:ring-blue-500 focus:outline-none"
                                placeholder="Tell us how we can help you on your mindfulness journey..."></textarea>
                        </div>

                        <div class="flex items-center">
                            <input id="newsletter" name="newsletter" type="checkbox"
                                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="newsletter" class="ml-2 block text-sm text-gray-700">
                                Send me weekly mindfulness tips and meditation reminders
                            </label>
                        </div>

                        <button type="submit"
                            class="w-full bg-blue-600 bg-gradient-to-r from-blue-600 to-purple-600 text-white px-6 py-3 rounded-md font-medium shadow-sm hover:bg-blue-700 hover:from-blue-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200">
                            Send Message
                        </button>
                    </form>
                </div>

                <!-- Contact Information & FAQ -->
                <div class="space-y-8">
                    <!-- Contact Details -->
                    <div class="bg-blue-50 rounded-lg p-8">
                        <h3 class="text-xl font-semibold text-gray-900 mb-6">Get in Touch</h3>
                        <div class="space-y-4">
                            <div class="flex items-start">
                                <svg class="w-5 h-5 text-blue-600 mt-1 mr-3" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                    </path>
                                </svg>
                                <div>
                                    <p class="font-medium text-gray-900">Email</p>
                                    <p class="text-gray-600">hello@zentara.com</p>
                                    <p class="text-sm text-gray-500">We respond within 24 hours</p>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <svg class="w-5 h-5 text-blue-600 mt-1 mr-3" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <div>
                                    <p class="font-medium text-gray-900">Support Hours</p>
                                    <p class="text-gray-600">Monday - Friday: 9AM - 6PM PST</p>
                                    <p class="text-gray-600">Weekend: 10AM - 4PM PST</p>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <svg class="w-5 h-5 text-blue-600 mt-1 mr-3" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                    </path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <div>
                                    <p class="font-medium text-gray-900">Location</p>
                                    <p class="text-gray-600">San Francisco, CA</p>
                                    <p class="text-sm text-gray-500">Serving practitioners worldwide</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Help -->
                    <div class="bg-green-50 rounded-lg p-8">
                        <h3 class="text-xl font-semibold text-gray-900 mb-6">Quick Help</h3>
                        <div class="space-y-4">
                            <div>
                                <h4 class="font-medium text-gray-900 mb-2">New to Meditation?</h4>
                                <p class="text-gray-600 text-sm mb-2">
                                    Start with our beginner-friendly "First Steps" program designed specifically for
                                    newcomers.
                                </p>
                                <a href="" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                    Explore Beginner Program →
                                </a>
                            </div>

                            <div>
                                <h4 class="font-medium text-gray-900 mb-2">Technical Issues?</h4>
                                <p class="text-gray-600 text-sm mb-2">
                                    Check our help center for solutions to common problems and troubleshooting guides.
                                </p>
                                <a href="" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                    Visit Help Center →
                                </a>
                            </div>

                            <div>
                                <h4 class="font-medium text-gray-900 mb-2">Account Questions?</h4>
                                <p class="text-gray-600 text-sm mb-2">
                                    Manage your subscription, update payment methods, or modify your profile settings.
                                </p>
                                <a href="" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                    Account Settings →
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Community -->
                    <div class="bg-purple-50 rounded-lg p-8">
                        <h3 class="text-xl font-semibold text-gray-900 mb-4">Join Our Community</h3>
                        <p class="text-gray-600 mb-4">
                            Connect with fellow practitioners, share insights, and get inspired by others on their
                            mindfulness journey.
                        </p>
                        <div class="flex space-x-4">
                            <a href="#" class="flex items-center text-blue-600 hover:text-blue-800 text-sm font-medium">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z" />
                                </svg>
                                Follow on Twitter
                            </a>
                            <a href="#" class="flex items-center text-blue-600 hover:text-blue-800 text-sm font-medium">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M22.46 6c-.77.35-1.6.58-2.46.69.88-.53 1.56-1.37 1.88-2.38-.83.5-1.75.85-2.72 1.05C18.37 4.5 17.26 4 16 4c-2.35 0-4.27 1.92-4.27 4.29 0 .34.04.67.11.98C8.28 9.09 5.11 7.38 3 4.79c-.37.63-.58 1.37-.58 2.15 0 1.49.75 2.81 1.91 3.56-.71 0-1.37-.2-1.95-.5v.03c0 2.08 1.48 3.82 3.44 4.21a4.22 4.22 0 0 1-1.93.07 4.28 4.28 0 0 0 4 2.98 8.521 8.521 0 0 1-5.33 1.84c-.34 0-.68-.02-1.02-.06C3.44 20.29 5.7 21 8.12 21 16 21 20.33 14.46 20.33 8.79c0-.19 0-.37-.01-.56.84-.6 1.56-1.36 2.14-2.23z" />
                                </svg>
                                Discord Community
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- FAQ Section -->
            <div class="mt-16">
                <h3 class="text-2xl font-semibold text-gray-900 mb-8 text-center">FAQs</h3>
                <div class="grid md:grid-cols-2 gap-8">
                    <div class="space-y-6">
                        <div>
                            <h4 class="font-semibold text-gray-900 mb-2">How long should I meditate as a beginner?</h4>
                            <p class="text-gray-600 text-sm">
                                Start with just 3-5 minutes daily. Our "First Steps" program gradually builds your
                                practice
                                to 10-15 minutes over several weeks. Consistency matters more than duration.
                            </p>
                        </div>

                        <div>
                            <h4 class="font-semibold text-gray-900 mb-2">Can I cancel my subscription anytime?</h4>
                            <p class="text-gray-600 text-sm">
                                Yes, you can cancel your subscription at any time from your account settings.
                                You'll continue to have access until the end of your current billing period.
                            </p>
                        </div>

                        <div>
                            <h4 class="font-semibold text-gray-900 mb-2">Do you offer guided meditations offline?</h4>
                            <p class="text-gray-600 text-sm">
                                Premium subscribers can download meditations for offline listening.
                                Perfect for travel, commutes, or areas with limited internet connectivity.
                            </p>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div>
                            <h4 class="font-semibold text-gray-900 mb-2">What meditation styles do you teach?</h4>
                            <p class="text-gray-600 text-sm">
                                We offer mindfulness, loving-kindness, body scan, breath awareness, walking meditation,
                                and specialized programs for sleep, stress, and emotional well-being.
                            </p>
                        </div>

                        <div>
                            <h4 class="font-semibold text-gray-900 mb-2">Is there a free trial available?</h4>
                            <p class="text-gray-600 text-sm">
                                Yes! New users get a 14-day free trial with full access to our meditation library,
                                programs, and community features. No credit card required to start.
                            </p>
                        </div>

                        <div>
                            <h4 class="font-semibold text-gray-900 mb-2">Can I meditate with friends or family?</h4>
                            <p class="text-gray-600 text-sm">
                                Our group meditation feature allows you to practice together virtually,
                                share progress, and support each other's mindfulness journey.
                            </p>
                        </div>
                    </div>
                </div>
            </div>




    </section>
</x-user-layout>
