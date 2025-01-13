@extends('store-front.layout.layout')

@section('main-content')
    <div class="container mx-auto p-4">
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">
                @if (session('success'))
                    {{ session('success') }}
                @else
                    Your order was placed successfully.
                @endif
            </span>
        </div>
        <p class="text-lg mt-4">Thank you for your order!</p>
        <p class="mt-4">You will receive a confirmation email shortly.</p>
        <a href="/" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-4 inline-block">Go
            Back to Home</a>
    </div>
@endsection
