{{-- resources/views/store-front/pages/contact.blade.php --}}
@extends('store-front.layout.layout')

@section('main-content')
    <div class="container mx-auto px-4 py-12 font-poppins">
        <h2 class="section-heading mb-12 text-center">Get in Touch</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-start">
            <!-- Contact Information -->
            <div class="relative p-8 bg-white shadow-lg rounded-xl">
                <div class="mb-8">
                    <h3 class="text-3xl font-semibold text-gray-900 mb-5">Our Location</h3>
                    <div class="text-gray-700 prose mb-5">{!! $contact->address ?? 'No Address Provided' !!}</div>
                </div>
                <div class="mb-8">
                    <h3 class="text-3xl font-semibold text-gray-900 mb-5">Contact Us</h3>
                    <p class="text-gray-700 mb-3">
                        <strong class="font-medium">Phone:</strong>
                        <a href="tel:{{ $contact->phone ?? '#' }}"
                           class="text-skin-secondary hover:text-skin-primary transition-colors">{!! $contact->phone ?? 'No phone number provided' !!}</a>
                    </p>
                    <p class="text-gray-700">
                        <strong class="font-medium">Email:</strong>
                        <a href="mailto:{{ $contact->email ?? '#' }}"
                           class="text-skin-secondary hover:text-skin-primary transition-colors">{!! $contact->email ?? 'No email provided' !!}</a>
                    </p>
                </div>

                <div class="absolute bottom-0 left-0 w-full h-16 flex items-center justify-center">
                    <img src="{{ asset('store-front/images/icons/dot-hot.png') }}" alt="" class="h-10 w-10">
                </div>
            </div>

            <!-- Contact Form -->
            <div class="p-8 bg-white shadow-lg rounded-xl">
                <h3 class="text-3xl font-semibold text-gray-900 mb-8 text-center">Send us a Message</h3>
                <form action="" method="POST" class="space-y-6">
                    @csrf
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Your Name</label>
                        <input type="text" name="name" id="name"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-skin-secondary focus:ring focus:ring-skin-secondary focus:ring-opacity-50 px-4 py-2 transition-shadow duration-200 ease-in-out"
                               required
                               placeholder="Enter your name">
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Your Email</label>
                        <input type="email" name="email" id="email"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-skin-secondary focus:ring focus:ring-skin-secondary focus:ring-opacity-50 px-4 py-2 transition-shadow duration-200 ease-in-out"
                               required
                               placeholder="Enter your email">
                    </div>
                    <div>
                        <label for="message" class="block text-sm font-medium text-gray-700 mb-2">Your Message</label>
                        <textarea name="message" id="message" rows="5"
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-skin-secondary focus:ring focus:ring-skin-secondary focus:ring-opacity-50 px-4 py-2 transition-shadow duration-200 ease-in-out"
                                  required
                                  placeholder="Write your message"></textarea>
                    </div>
                    <div>
                        <button type="submit"
                                class="w-full bg-skin-secondary hover:bg-skin-primary text-white font-semibold py-3 px-6 rounded-md focus:outline-none focus:ring-2 focus:ring-skin-secondary focus:ring-opacity-50 transition-colors">Send
                            Message
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
@endsection
