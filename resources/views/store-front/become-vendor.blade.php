@extends('store-front.layout.layout')

@section('main-content')
    <div class="container mx-auto px-4 py-8 font-poppins">
        <div class="text-center my-12">
            <h2 class="section-heading mb-4">Playware Seller Signup</h2>
            <p class="text-gray-600 ">Choose the right plan for your business needs. We offer various
                options to suit every type of seller.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 py-12">
            <!-- Individual Seller Plan -->
            <div class="bg-white border  shadow-md rounded-lg p-6 flex flex-col">
                <h3 class="text-xl font-semibold text-gray-900  mb-4">Individual Seller</h3>
                <div class="mb-4">
                    <ul class="list-disc list-inside text-gray-700  text-sm space-y-2">
                        <li>Hold Over Payment (If done via Platform/Platform Account).</li>
                        <li>No claiming on F2F deal.</li>
                        <li>2% cut after Payment hold.</li>
                        <li>50 Sales per Month.</li>
                        <li>Customer Support.</li>
                        <li>Sale posts will be on hold and approved after review.</li>
                    </ul>
                </div>
                <div class="mt-auto">
                    <p class="text-2xl font-bold text-center text-gray-900  mb-2">Free</p>
                    <a href="{{ route('register.seller') }}"
                        class="block w-full bg-skin-secondary text-center hover:bg-skin-primary text-white font-semibold py-2 px-4 rounded-md focus:outline-none focus:ring-2 focus:ring-skin-secondary focus:ring-opacity-50">
                        Sign Up
                    </a>
                </div>
            </div>

            <!-- Individual Seller (Verified) Plan -->
            <div class="bg-white border  shadow-md rounded-lg p-6 flex flex-col">
                <h3 class="text-xl font-semibold text-gray-900  mb-4">Individual Seller (Verified)</h3>
                <div class="mb-4">
                    <ul class="list-disc list-inside text-gray-700  text-sm space-y-2">
                        <li>No Hold on Payment.</li>
                        <li>Direct Payment-to-seller (Easypaisa/Bank account).</li>
                        <li>0% Cut on any sale.</li>
                        <li>1000 Sales per month.</li>
                        <li>Fast sale post approval.</li>
                        <li>Instant Customer Service (10am to 10pm).</li>
                    </ul>
                </div>
                <div class="mt-auto">
                    <p class="text-2xl font-bold text-center text-gray-900  mb-2">PKR 2999/-</p>
                    <a href="{{ route('register.seller') }}"
                        class="block w-full bg-skin-secondary text-center hover:bg-skin-primary text-white font-semibold py-2 px-4 rounded-md focus:outline-none focus:ring-2 focus:ring-skin-secondary focus:ring-opacity-50">
                        Sign Up
                    </a>
                </div>
            </div>


            <!-- Shopkeeper Seller (Verified) Plan -->
            <div class="bg-white border  shadow-md rounded-lg p-6 flex flex-col">
                <h3 class="text-xl font-semibold text-gray-900  mb-4">Shopkeeper Seller (Verified)
                </h3>
                <div class="mb-4">
                    <ul class="list-disc list-inside text-gray-700  text-sm space-y-2">
                        <li>No Hold over Payments.</li>
                        <li>Direct Payment-to-seller (Easypaisa/Bank account).</li>
                        <li>Credit/Debit Card Option (Coming Soon).</li>
                        <li>0% Cut on any sale.</li>
                        <li>5000 Sales per month.</li>
                        <li>Instant Post Approval.</li>
                        <li>24/7 Instant Customer Service.</li>
                        <li>Access to Backlog inventory.
                            (Seller to Seller Distribution and Inventory/Stock list at whole sale rate).</li>
                    </ul>
                </div>
                <div class="mt-auto">
                    <p class="text-2xl font-bold text-center text-gray-900  mb-2">PKR 4999/-</p>
                    <a href="{{ route('register.seller') }}"
                        class="block w-full bg-skin-secondary text-center hover:bg-skin-primary text-white font-semibold py-2 px-4 rounded-md focus:outline-none focus:ring-2 focus:ring-skin-secondary focus:ring-opacity-50">
                        Sign Up
                    </a>
                </div>
            </div>

            <!-- Enterprise Plan -->
            <div class="bg-white border  shadow-md rounded-lg p-6 flex flex-col">
                <h3 class="text-xl font-semibold text-gray-900  mb-4">Enterprise (Verified)</h3>
                <div class="mb-4">
                    <ul class="list-disc list-inside text-gray-700  text-sm space-y-2">
                        <li>Custom Profile.</li>
                        <li>No Hold over Payments.</li>
                        <li>Direct Payment-to-seller (Easypaisa/Bank account).</li>
                        <li>Credit/Debit Card Option (Coming Soon).</li>
                        <li>0% Cut on any sale.</li>
                        <li>Unlimited Sales per Month.</li>
                        <li>Instant Post.</li>
                        <li>24/7 Priority Customer Service.</li>
                    </ul>
                </div>
                <div class="mt-auto">
                    <p class="text-2xl font-bold text-center text-gray-900  mb-2">Contact Us</p>
                    <a
                        class="block w-full bg-skin-secondary text-center hover:bg-skin-primary text-white font-semibold py-2 px-4 rounded-md focus:outline-none focus:ring-2 focus:ring-skin-secondary focus:ring-opacity-50">
                        Contact Us
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
