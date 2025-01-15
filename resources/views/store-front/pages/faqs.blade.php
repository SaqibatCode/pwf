{{-- faqs.blade.php --}}
@extends('store-front.layout.layout')

@section('main-content')
    <div class="container mx-auto px-4 py-8">
        <h2 class="section-heading mb-8">Frequently Asked Questions</h2>

        <div class="space-y-6">
            @forelse ($faqs as $faq)
                <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-2">{!! $faq->question !!}</h3>
                    <p class="text-gray-700 dark:text-gray-300">{!! $faq->answer !!}</p>
                </div>
            @empty
                <p class="text-gray-500 dark:text-gray-400">No FAQs available yet.</p>
            @endforelse
        </div>

    </div>
@endsection
