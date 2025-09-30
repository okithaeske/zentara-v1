<x-user-layout title="Contact">

    <section class="py-12">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header Section -->
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Dedicated Support For Your Next Timepiece</h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    From sourcing limited editions to arranging servicing for a favourite piece, the Zentara UK concierge team is ready to help. Share a few details below and we will respond within one business day.
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

                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <label for="first_name" class="block text-sm font-medium text-gray-700 mb-2">First Name</label>
                                <input id="first_name" name="first_name" type="text"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm bg-white text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:ring-blue-500 focus:outline-none"
                                    placeholder="Amelia" />
                            </div>
                            <div>
                                <label for="last_name" class="block text-sm font-medium text-gray-700 mb-2">Last Name</label>
                                <input id="last_name" name="last_name" type="text"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm bg-white text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:ring-blue-500 focus:outline-none"
                                    placeholder="Walker" />
                            </div>
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                            <input id="email" name="email" type="email"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm bg-white text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:ring-blue-500 focus:outline-none"
                                placeholder="amelia@example.com" />
                        </div>

                        <div>
                            <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">Topic</label>
                            <select id="subject" name="subject"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm bg-white text-gray-900 focus:border-blue-500 focus:ring-blue-500 focus:outline-none">
                                <option value="">Choose a topic...</option>
                                <option value="product_enquiry">Product Enquiry</option>
                                <option value="order_support">Order Support</option>
                                <option value="servicing_repairs">Servicing & Repairs</option>
                                <option value="financing_tradein">Financing & Trade-In</option>
                                <option value="corporate_gifting">Corporate & Bespoke Gifting</option>
                                <option value="press_partnerships">Press & Partnerships</option>
                                <option value="other">Other</option>
                            </select>
                        </div>

                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700 mb-2">Message</label>
                            <textarea id="message" name="message" rows="6"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm bg-white text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:ring-blue-500 focus:outline-none"
                                placeholder="Tell us which reference, collection, or service you would like assistance with..."></textarea>
                        </div>

                        <div class="flex items-center">
                            <input id="newsletter" name="newsletter" type="checkbox"
                                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="newsletter" class="ml-2 block text-sm text-gray-600">
                                Keep me updated on new releases, restocks, and private previews.
                            </label>
                        </div>

                        <button type="submit"
                            class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-gray-900 hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900">
                            Submit Enquiry
                        </button>
                    </form>
                </div>

                <!-- Contact Details -->
                <div class="space-y-8">
                    <div class="bg-gray-900 text-white rounded-lg p-8">
                        <h3 class="text-xl font-semibold mb-4">Speak With Our Concierge</h3>
                        <p class="text-sm text-gray-200 mb-6">
                            Our specialists can recommend the right watch, confirm availability, and arrange servicing appointments.
                        </p>
                        <div class="space-y-4 text-sm">
                            <div>
                                <span class="block text-gray-400 uppercase tracking-wide">Call</span>
                                <a href="tel:+442034562178" class="text-white hover:text-gray-300">+44 (0)20 3456 2178</a>
                            </div>
                            <div>
                                <span class="block text-gray-400 uppercase tracking-wide">Email</span>
                                <a href="mailto:hello@zentara.co.uk" class="text-white hover:text-gray-300">hello@zentara.co.uk</a>
                            </div>
                            <div>
                                <span class="block text-gray-400 uppercase tracking-wide">Showroom</span>
                                <p>Unit 12, Cavendish Arcade, London W1</p>
                                <p class="text-gray-400">By appointment Monday - Saturday</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white shadow-sm rounded-lg p-8">
                        <h4 class="text-lg font-semibold text-gray-900 mb-4">Need Something Fast?</h4>
                        <ul class="space-y-4 text-sm text-gray-600">
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-gray-400 mt-1 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 1.791-3 4s1.343 4 3 4 3-1.791 3-4-1.343-4-3-4z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2 12c0 5.523 4.477 10 10 10 1.753 0 3.402-.45 4.834-1.243l3.227 1.212-.845-3.356A9.967 9.967 0 0022 12c0-5.523-4.477-10-10-10S2 6.477 2 12z" />
                                </svg>
                                <div>
                                    <strong class="text-gray-900">Live Chat</strong>
                                    <p>Weekdays 9:00 - 19:00 GMT via the chat icon on every product page.</p>
                                </div>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-gray-400 mt-1 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8m-9 10h.01" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                <div>
                                    <strong class="text-gray-900">Order Tracking</strong>
                                    <p>Use the tracking link in your dispatch email or contact us with your order number.</p>
                                </div>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-gray-400 mt-1 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-6h6v6m-9 4h12a2 2 0 002-2V7a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <div>
                                    <strong class="text-gray-900">Virtual Consultations</strong>
                                    <p>Book a video appointment to see sizing, dial details, and strap options up close.</p>
                                </div>
                            </li>
                        </ul>
                    </div>

                    <div>
                        <h4 class="text-sm font-semibold text-gray-900 uppercase tracking-wide mb-3">Connect With Us</h4>
                        <div class="flex space-x-4">
                            <a href="#" class="flex items-center text-gray-900 hover:text-gray-600 text-sm font-medium">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 1.17.055 1.97.24 2.424.403a4.92 4.92 0 011.675 1.09 4.924 4.924 0 011.09 1.675c.163.454.348 1.254.403 2.424.058 1.266.07 1.646.07 4.85s-.012 3.584-.07 4.85c-.055 1.17-.24 1.97-.403 2.424a4.932 4.932 0 01-1.09 1.675 4.932 4.932 0 01-1.675 1.09c-.454.163-1.254.348-2.424.403-1.266.058-1.646.07-4.85.07s-3.584-.012-4.85-.07c-1.17-.055-1.97-.24-2.424-.403a4.92 4.92 0 01-1.675-1.09 4.92 4.92 0 01-1.09-1.675c-.163-.454-.348-1.254-.403-2.424C2.175 15.746 2.163 15.366 2.163 12s.012-3.584.07-4.85c.055-1.17.24-1.97.403-2.424a4.92 4.92 0 011.09-1.675 4.92 4.92 0 011.675-1.09c.454-.163 1.254-.348 2.424-.403C8.416 2.175 8.796 2.163 12 2.163zm0 1.838c-3.17 0-3.548.012-4.795.069-1.027.047-1.584.216-1.953.36-.49.19-.84.418-1.207.785a3.085 3.085 0 00-.785 1.207c-.144.369-.313.926-.36 1.953-.057 1.247-.069 1.625-.069 4.795s.012 3.548.069 4.795c.047 1.027.216 1.584.36 1.953.19.49.418.84.785 1.207.367.367.717.595 1.207.785.369.144.926.313 1.953.36 1.247.057 1.625.069 4.795.069s3.548-.012 4.795-.069c1.027-.047 1.584-.216 1.953-.36.49-.19.84-.418 1.207-.785.367-.367.595-.717.785-1.207.144-.369.313-.926.36-1.953.057-1.247.069-1.625.069-4.795s-.012-3.548-.069-4.795c-.047-1.027-.216-1.584-.36-1.953a3.077 3.077 0 00-.785-1.207 3.077 3.077 0 00-1.207-.785c-.369-.144-.926-.313-1.953-.36-1.247-.057-1.625-.069-4.795-.069zm0 3.243a4.757 4.757 0 110 9.514 4.757 4.757 0 010-9.514zm0 7.861a3.104 3.104 0 100-6.209 3.104 3.104 0 000 6.209zm6.406-8.491a1.11 1.11 0 11-2.221 0 1.11 1.11 0 012.221 0z" />
                                </svg>
                                Instagram
                            </a>
                            <a href="#" class="flex items-center text-gray-900 hover:text-gray-600 text-sm font-medium">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M19 0h-3a5 5 0 00-5 5v3H8v4h3v12h4V12h3.642L19 8h-4V5a1 1 0 011-1h3z" />
                                </svg>
                                Facebook
                            </a>
                            <a href="#" class="flex items-center text-gray-900 hover:text-gray-600 text-sm font-medium">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M20.447 20.452H17.2v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.135 1.445-2.135 2.939v5.667H9.07V9h3.112v1.561h.045c.433-.82 1.49-1.686 3.066-1.686 3.277 0 3.881 2.158 3.881 4.968v6.609zM5.337 7.433a1.857 1.857 0 110-3.714 1.857 1.857 0 010 3.714zM6.943 20.452H3.73V9h3.213v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0z" />
                                </svg>
                                LinkedIn
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
                            <h4 class="font-semibold text-gray-900 mb-2">Are your watches authentic?</h4>
                            <p class="text-gray-600 text-sm">
                                Yes. Every piece is authenticated by British Horological Institute accredited watchmakers and accompanied by documentation confirming provenance, condition, and warranty coverage.
                            </p>
                        </div>

                        <div>
                            <h4 class="font-semibold text-gray-900 mb-2">How long does delivery take?</h4>
                            <p class="text-gray-600 text-sm">
                                In-stock watches ship within one business day. UK mainland delivery is typically next-day and fully insured. International shipping options are available on request.
                            </p>
                        </div>

                        <div>
                            <h4 class="font-semibold text-gray-900 mb-2">Can I view a watch before purchasing?</h4>
                            <p class="text-gray-600 text-sm">
                                Absolutely. Book a virtual consultation or arrange a private viewing at our London showroom to inspect dial details, movement condition, and strap options.
                            </p>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div>
                            <h4 class="font-semibold text-gray-900 mb-2">Do you offer financing?</h4>
                            <p class="text-gray-600 text-sm">
                                We partner with leading finance providers to offer interest-free instalments and tailored plans on purchases over &pound;1,000. Ask the team for a bespoke quote.
                            </p>
                        </div>

                        <div>
                            <h4 class="font-semibold text-gray-900 mb-2">What is your returns policy?</h4>
                            <p class="text-gray-600 text-sm">
                                New and unworn pieces can be returned within 30 days. Certified pre-owned watches include a 14-day inspection window. All returns must include original packaging and paperwork.
                            </p>
                        </div>

                        <div>
                            <h4 class="font-semibold text-gray-900 mb-2">Can you service watches not purchased from Zentara UK?</h4>
                            <p class="text-gray-600 text-sm">
                                Yes. Our in-house watchmakers service most luxury and heritage brands. Submit the form above with the model reference and we will confirm pricing and timelines.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-user-layout>

