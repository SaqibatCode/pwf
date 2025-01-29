@extends('store-front.layout.layout')

@section('main-content')
    @if ($seller->userProfile)
        <section class="px-4 sm:px-12 py-8">
            <div class="mx-auto max-w-7xl bg-skin-fill rounded-lg shadow-md overflow-hidden">
                {{-- Cover Image --}}
                <div class="relative h-48 sm:h-64 bg-skin-fill overflow-hidden">
                    <img src="{{ asset($seller->userProfile->cover_photo ?? 'assets/images/default-cover.jpg') }}"
                        alt="Seller Cover Image" class="absolute inset-0 w-full h-full object-cover object-center">
                    <div class="absolute inset-0 bg-skin-fill/25"></div>
                </div>

                <div class="px-4 sm:px-8 py-6 relative">
                    {{-- Profile Image --}}
                    <div
                        class="absolute -top-16 left-4 sm:left-8 border-4 border-skin-fill rounded-full w-24 h-24 sm:w-32 sm:h-32  overflow-hidden">
                        <img src="{{ asset($seller->userProfile->profile_photo ?? 'assets/images/default-profile.jpg') }}"
                            alt="Seller Profile Image" class="w-full h-full object-cover object-center">
                    </div>

                    <div class="mt-12 sm:mt-16">
                        {{-- Seller Name and Description --}}
                        <div class="flex justify-between items-center">
                            <div>
                                <h1 class="text-2xl font-bold text-skin-primary font-unbounded">{{ $seller->first_name }}
                                    {{ $seller->last_name }}</h1>
                            </div>
                        </div>

                        @if ($seller->userProfile->seller_description)
                            <p class="mt-2 text-sm text-skin-gray">{{ $seller->userProfile->seller_description }}</p>
                        @endif


                        {{-- Seller Details --}}
                        <div class="mt-4 flex flex-wrap gap-2">
                            <span class="text-sm font-medium text-skin-gray flex items-center gap-1">
                                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15.75 17.25v-.062c0-.195-.05-.383-.144-.543l-3.437-5.155a1.125 1.125 0 0 0-2.248 0L8.39 16.645c-.094.16-.144.348-.144.543v.062m3.75 0h-7.5M18.5 14.25a2.25 2.25 0 0 1-2.25 2.25h-1.5a2.25 2.25 0 0 1-2.25-2.25V6.75a2.25 2.25 0 0 1 2.25-2.25h1.5a2.25 2.25 0 0 1 2.25 2.25v7.5Z" />
                                </svg>
                                Member since: {{ $seller->created_at->format('F Y') }}</span>
                            @if ($seller->verification == 'Verified')
                                <span class="text-sm font-medium text-skin-primary flex items-center gap-1">
                                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                    </svg>
                                    Verified
                                </span>
                            @else()
                                <span class="text-sm font-medium text-skin-primary flex items-center gap-1">
                                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M18.364 18.364A9 9 0 0 0 5.636 5.636m12.728 12.728A9 9 0 0 1 5.636 5.636m12.728 12.728L5.636 5.636" />
                                    </svg>
                                    Unverified
                                </span>
                            @endif
                        </div>
                    </div>

                </div>


                {{-- Seller's Products --}}
                <div class="px-4 sm:px-8 py-6 bg-skin-fill-secondary">
                    <h2 class="text-2xl font-bold text-skin-primary mb-4 font-unbounded">Seller's Products</h2>
                    @if (count($products) > 0)
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">

                            @foreach ($products as $product)
                                <div
                                    class="product-card-main h-full justify-between flex flex-col">
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
                                            alt="{{ $product->product_name }}"
                                            class="max-w-64">
                                    </div>
                                    <div class="">
                                        <div class="flex justify-between gap-4">
                                            <div class="flex flex-col gap-1">
                                                <a href="{{ route('show.product', $product->slug) }}">
                                                    <h4
                                                        class="font-semibold text-xl text-[#111928]">
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
                            @endforeach
                        </div>
                    @else
                        <p class="col-span-full text-center text-skin-gray py-8">No products available from this seller yet
                        </p>
                    @endif
                </div>

            </div>
        </section>
    @else
        <section class="px-4 sm:px-12 py-8">
            <h2>Seller Has Not Setup Their Profile Yet!</h2>
        </section>
    @endif
@endsection
