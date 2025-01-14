@extends('store-front.layout.layout')

@section('main-content')
    <section class="px-4 sm:px-12 py-8">
        <div class="mx-auto max-w-7xl">

            {{-- Breadcrumb --}}
            <div class="mb-6">
                <nav class="flex" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3">
                        <li class="inline-flex items-center">
                            <a href="{{ route('show.shop') }}"
                                class="inline-flex items-center text-sm font-medium text-skin-primary hover:text-skin-secondary">
                                <svg class="w-3 h-3 mr-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
                                </svg>
                                Shop
                            </a>
                        </li>
                        @foreach ($category as $cat)
                            <li>
                                <div class="flex items-center">
                                    <svg class="w-3 h-3 text-skin-gray mx-1" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="m1 9 4-4-4-4" />
                                    </svg>
                                    <span
                                        class="ml-1 text-sm font-medium text-skin-primary md:ml-2 ">{{ $cat->name }}</span>
                                </div>
                            </li>
                        @endforeach

                    </ol>
                </nav>
            </div>
            {{-- End Breadcrumb --}}


            @foreach ($category as $cat)
                <div class="mb-8 flex justify-between items-center">
                    <h1 class="text-3xl font-bold text-skin-primary font-unbounded">{{ $cat->name }}</h1>

                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
                    @forelse($cat->products as $product)
                        <div class="product-card-main group/product relative rounded-lg shadow-md overflow-hidden transition-shadow hover:shadow-lg">
                            <div class="mb-2 p-2 bg-skin-fill/75 rounded-t-lg flex justify-end">
                                @if ($product->condition == 'Used')
                                    <span
                                        class="bg-skin-primary py-1 px-2 rounded-md text-xs text-white font-unbounded">Used</span>
                                @else
                                    <span
                                        class="bg-skin-secondary py-1 px-2 rounded-md text-xs text-white font-unbounded">New</span>
                                @endif
                            </div>
                            <div class="img flex flex-col justify-center items-center mb-4 overflow-hidden">
                                <img src="{{ asset($product->pictures[0]->image) }}"
                                    alt="{{ $product->product_name }}" class="max-w-64 transition-transform duration-300 group-hover/product:scale-105">
                            </div>
                            <div class="p-4">
                                <div class="flex justify-between gap-4">
                                    <div class="flex flex-col gap-1">
                                        <a href="{{ route('show.product', $product->slug) }}">
                                            <h4 class="font-semibold text-xl text-[#111928] group-hover/product:text-skin-primary transition-colors duration-300">
                                                {{ $product->product_name }}
                                            </h4>
                                            <h6 class="text-base font-semibold">Rs.
                                                {{ number_format($product->price, 2) }}
                                            </h6>
                                        </a>
                                    </div>
                                    <div class="flex flex-col">
                                        <span
                                            class="text-skin-gray font-semibold">{{ $product->user->first_name ?? 'No Brand' }}</span>
                                        <span class="text-skin-gray w-max font-semibold">14
                                            Reviews</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="col-span-full text-center text-skin-gray py-8">No products available in this category yet
                        </p>
                    @endforelse
                </div>
            @endforeach

        </div>
    </section>
@endsection
