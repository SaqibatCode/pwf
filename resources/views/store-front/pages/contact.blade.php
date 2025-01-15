{{-- resources/views/store-front/pages/contact.blade.php --}}
@extends('store-front.layout.layout')

@section('main-content')
    <div class="container mx-auto px-4 py-8">
        <h2 class="section-heading mb-8 text-center">Get in Touch</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-start">
            <!-- Contact Information -->
            <div class="relative p-6 bg-white dark:bg-gray-800 shadow-lg rounded-lg">
                <div class="mb-6">
                    <h3 class="text-2xl font-semibold text-gray-900 dark:text-gray-100 mb-4">Our Location</h3>
                    <p class="text-gray-700 dark:text-gray-300 prose mb-4">{!! $contact->address ?? 'No Address Provided' !!}</p>
                </div>
                <div class="mb-6">
                    <h3 class="text-2xl font-semibold text-gray-900 dark:text-gray-100 mb-4">Contact Us</h3>
                    <p class="text-gray-700 dark:text-gray-300 mb-2">
                        <strong>Phone:</strong> <a href="tel:{{ $contact->phone ?? '#' }}" class="text-skin-secondary hover:text-skin-primary">{!! $contact->phone ?? 'No phone number provided' !!}</a>
                    </p>
                     <p class="text-gray-700 dark:text-gray-300">
                        <strong>Email:</strong> <a href="mailto:{{ $contact->email ?? '#' }}" class="text-skin-secondary hover:text-skin-primary">{!! $contact->email ?? 'No email provided' !!}</a>
                    </p>
                </div>

                 <div class="absolute bottom-0 left-0 w-full h-16 flex items-center justify-center">
                     <img src="{{ asset('store-front/images/icons/dot-hot.png') }}" alt="" class="h-10 w-10">
                 </div>
            </div>


             <!-- Contact Form -->
             <div class="p-6 bg-white dark:bg-gray-800 shadow-lg rounded-lg">
                <h3 class="text-2xl font-semibold text-gray-900 dark:text-gray-100 mb-6 text-center">Send us a Message</h3>
                <form action="" method="POST" class="space-y-4">
                     @csrf
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Your Name</label>
                        <input type="text" name="name" id="name"
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:border-skin-secondary focus:ring focus:ring-skin-secondary focus:ring-opacity-50"
                            required>
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Your Email</label>
                        <input type="email" name="email" id="email"
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:border-skin-secondary focus:ring focus:ring-skin-secondary focus:ring-opacity-50"
                             required>
                    </div>
                    <div>
                        <label for="message" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Your Message</label>
                       <textarea name="message" id="message" rows="4"
                             class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:border-skin-secondary focus:ring focus:ring-skin-secondary focus:ring-opacity-50"
                            required></textarea>
                    </div>
                   <div>
                    <button type="submit"
                         class="w-full bg-skin-secondary hover:bg-skin-primary text-white font-semibold py-2 px-4 rounded-md focus:outline-none focus:ring-2 focus:ring-skin-secondary focus:ring-opacity-50">Send Message</button>
                   </div>
                </form>
             </div>

        </div>
    </div>
@endsection
