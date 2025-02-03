@extends('store-front.layout.layout')

@section('main-content')
    <!-- HERO SECTION -->

    <section class="mb-12">

        <div class="swiper mySwiper min-h-[500px] text-white">
            <div class="swiper-wrapper min-h-[500px]">
                @forelse($sliders as $slider)
                    <div class="swiper-slide min-h-[500px] max-h-[700px] object-contain relative">
                        <div
                            class="absolute left-0 w-full h-full flex flex-col justify-center items-center sm:items-start px-24">
                            <h3 class="text-4xl md:text-6xl lg:text-7xl font-extralight">
                                {{ $slider->sub_heading ?? '' }}
                            </h3>
                            <h2 class="text-5xl md:text-7xl lg:text-8xl font-semibold">
                                {{ $slider->heading ?? '' }}
                            </h2>
                            <h2
                                class="text-sm md:text-base lg:text-lg md:tracking-[8px] lg:tracking-[9px] font-semibold text-[#656565] uppercase my-4">
                                {{ $slider->description ?? '' }}
                            </h2>
                            @if (isset($slider->price))
                                <span class="text-xl md:text-3xl lg:text-4xl tracking-wider font-bold mb-4">
                                    {{ $slider->price }}
                                </span>
                            @endif
                            @if (isset($slider->button_url) && isset($slider->button_text))
                                <a href="{{ $slider->button_url }}"
                                    class="rounded-full border-2 border-[#FCCDC5] py-2 px-4 uppercase text-xs lg:text-sm font-bold tracking-[1.05px]">
                                    {{ $slider->button_text }}
                                </a>
                            @endif
                        </div>
                        <img src="{{ $slider->image_desktop ?? asset('store-front/images/banner-images/banner.png') }}"
                            class="min-h-[500px] max-h-[700px] object-contain" alt="Banner Image">
                    </div>
                @empty
                    <!-- Static Slider Fallback if no data in DB -->
                    <div class="swiper-slide min-h-[500px] max-h-[700px] object-contain relative">
                        <div
                            class="absolute left-0 w-full h-full flex flex-col justify-center items-center sm:items-start px-24">
                            <h3 class="text-4xl md:text-6xl lg:text-7xl font-extralight">The New Collection</h3>
                            <h2 class="text-5xl md:text-7xl lg:text-8xl font-semibold">Smartwatches</h2>
                            <h2
                                class="text-sm md:text-base lg:text-lg md:tracking-[8px] lg:tracking-[9px] font-semibold text-[#656565] uppercase my-4">
                                Shop to get what you love
                            </h2>
                            <span class="text-xl md:text-3xl lg:text-4xl tracking-wider font-bold mb-4">$720.99</span>
                            <a href="#"
                                class="rounded-full border-2 border-[#FCCDC5] py-2 px-4 uppercase text-xs lg:text-sm font-bold tracking-[1.05px]">
                                Start Buying
                            </a>
                        </div>
                        <img src="{{ asset('store-front/images/banner-images/banner.png') }}"
                            class="min-h-[500px] max-h-[700px] object-contain" alt="Static Banner Image">
                    </div>
                @endforelse
            </div>

            <div class="swiper-button-next custom-banner-button !right-3">
                <img src="{{ asset('store-front/images/icons/right-arrow.png') }}" alt="" class="h-auto min-w-12">
            </div>
            <div class="swiper-button-prev custom-banner-button !left-3">
                <img src="{{ asset('store-front/images/icons/left-arrow.png') }}" alt="" class="h-auto min-w-12">
            </div>
        </div>



    </section>


    <!-- HOT PICKS FOR GAMERS -->

    <section class="mb-20">
        <div class="px-12">
            <div class="max-w-xl mx-auto mb-12">
                <h2 class="section-heading">Hot Picks for Gamers and Creators</h2>
            </div>



            <div class="swiper productSwiper !pb-20">
                <div class="swiper-wrapper">
                    @foreach ($products as $product)
                        <div class="swiper-slide product-card-main">
                            <div class="mb-1">
                                @if ($product->condition == 'Used')
                                    <span
                                        class="bg-skin-primary py-1 px-2 rounded-md text-xs text-white font-unbounded">Used</span>
                                @else
                                    <span
                                        class="bg-skin-secondary py-1 px-2 rounded-md text-xs text-white font-unbounded">New</span>
                                @endif
                            </div>
                            <div class="img flex flex-col justify-center items-center mb-4 overflow-hidden">
                                <div style="height: 160px; display: flex; align-items: center; justify-content: center;">
                                    <img src="{{ asset($product->pictures[0]->image) }}"
                                        alt="{{ $product->product_name }}" class="max-w-64 max-h-full object-contain"
                                        style="max-height: 100%; max-width: 100%;">
                                </div>
                            </div>
                            <div>
                                <div class="flex justify-between gap-4">
                                    <div class="flex flex-col gap-1">
                                        <a href="{{ route('show.product', $product->slug) }}">
                                            <h4 class="font-semibold text-xl text-[#111928]">{{ $product->product_name }}
                                            </h4>
                                            <h6 class="text-base font-semibold">Rs. {{ number_format($product->price, 2) }}
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
                <div
                    class="swiper-button-prev bg-skin-secondary min-w-12 min-h-12 !top-1/3 rounded-full p-2 after:text-white after:!text-2xl">
                </div>
                <div
                    class="swiper-button-next bg-skin-secondary min-w-12 min-h-12 !top-1/3 rounded-full p-2 after:text-white after:!text-2xl">
                </div>
                <div class="swiper-pagination bottom-0"></div>
            </div>
        </div>
    </section>

    <section class="mb-20">
        <div class="px-12">
            <div class="max-w-xl mx-auto mb-12">
                <h2 class="section-heading">Explore Our Categories</h2>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 place-items-center">
                @foreach ($categories as $cat)
                    <div class="max-h-[305px] max-w-[270px]">

                        <div class="rounded-md overflow-hidden">
                            <img src="{{ asset($cat->image) }}" alt="">
                        </div>

                        <div class="font-unbounded text-center mt-4 flex flex-col gap-2">
                            <a href="{{ route('show.single.categories', $cat->slug) }}">
                                <h5 class="text-2xl">{{ $cat->name }}</h5>
                            </a>
                            <span class="text-skin-gray text-base">8 Products Available</span>
                        </div>

                    </div>
                @endforeach

            </div>

            <div class="flex flex-col justify-center items-center mt-12">
                <button
                    class="bg-skin-secondary rounded-md font-unbounded font-semibold text-base px-2 py-1 text-white">View
                    All Categories</button>
            </div>

        </div>
    </section>


    <!-- GRAPHIC CARDS -->
    <section class="mb-20">
        <div class="px-12">
            <div class="max-w-lg mx-auto mb-12">
                <h2 class="section-heading">Graphic Cards</h2>
            </div>



            <div class="swiper productSwiper !pb-20">
                <div class="swiper-wrapper">
                    @foreach ($products as $product)
                        @if ($product->category?->name == 'Graphic Cards')
                            <div class="swiper-slide product-card-main">
                                <div class="mb-1">
                                    @if ($product->condition == 'Used')
                                        <span
                                            class="bg-skin-primary py-1 px-2 rounded-md text-xs text-white font-unbounded">Used</span>
                                    @else
                                        <span
                                            class="bg-skin-secondary py-1 px-2 rounded-md text-xs text-white font-unbounded">New</span>
                                    @endif
                                </div>
                                <div class="img flex flex-col justify-center items-center mb-4 overflow-hidden">
                                    <div
                                        style="height: 160px; display: flex; align-items: center; justify-content: center;">
                                        <img src="{{ asset($product->pictures[0]->image) }}"
                                            alt="{{ $product->product_name }}" class="max-w-64 max-h-full object-contain"
                                            style="max-height: 100%; max-width: 100%;">
                                    </div>
                                </div>
                                <div>
                                    <div class="flex justify-between gap-4">
                                        <div class="flex flex-col gap-1">
                                            <a href="{{ route('show.product', $product->slug) }}">
                                                <h4 class="font-semibold text-xl text-[#111928]">
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
                        @endif
                    @endforeach
                </div>
                <div
                    class="swiper-button-prev bg-skin-secondary min-w-12 min-h-12 !top-1/3 rounded-full p-2 after:text-white after:!text-2xl">
                </div>
                <div
                    class="swiper-button-next bg-skin-secondary min-w-12 min-h-12 !top-1/3 rounded-full p-2 after:text-white after:!text-2xl">
                </div>
                <div class="swiper-pagination bottom-0"></div>
            </div>





        </div>
    </section>

    <!-- PROCESSORS -->
    <section class="mb-20">
        <div class="px-12">
            <div class="max-w-lg mx-auto mb-12">
                <h2 class="section-heading">Processors</h2>
            </div>



            <div class="swiper productSwiper !pb-20">
                <div class="swiper-wrapper">
                    @foreach ($products as $product)
                        @if ($product->category?->name == 'Processors')
                            <div class="swiper-slide product-card-main">
                                <div class="mb-1">
                                    @if ($product->condition == 'Used')
                                        <span
                                            class="bg-skin-primary py-1 px-2 rounded-md text-xs text-white font-unbounded">Used</span>
                                    @else
                                        <span
                                            class="bg-skin-secondary py-1 px-2 rounded-md text-xs text-white font-unbounded">New</span>
                                    @endif
                                </div>
                                <div class="img flex flex-col justify-center items-center mb-4 overflow-hidden">
                                    <div
                                        style="height: 160px; display: flex; align-items: center; justify-content: center;">
                                        <img src="{{ asset($product->pictures[0]->image) }}"
                                            alt="{{ $product->product_name }}" class="max-w-64 max-h-full object-contain"
                                            style="max-height: 100%; max-width: 100%;">
                                    </div>
                                </div>
                                <div>
                                    <div class="flex justify-between gap-4">
                                        <div class="flex flex-col gap-1">
                                            <a href="{{ route('show.product', $product->slug) }}">
                                                <h4 class="font-semibold text-xl text-[#111928]">
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
                        @endif
                    @endforeach
                </div>
                <div
                    class="swiper-button-prev bg-skin-secondary min-w-12 min-h-12 !top-1/3 rounded-full p-2 after:text-white after:!text-2xl">
                </div>
                <div
                    class="swiper-button-next bg-skin-secondary min-w-12 min-h-12 !top-1/3 rounded-full p-2 after:text-white after:!text-2xl">
                </div>
                <div class="swiper-pagination bottom-0"></div>
            </div>
        </div>
    </section>

    <!-- Storage -->
    <section class="mb-20">
        <div class="px-12">
            <div class="max-w-lg mx-auto mb-12">
                <h2 class="section-heading">Storage</h2>
            </div>



            <div class="swiper productSwiper !pb-20">
                <div class="swiper-wrapper">
                    @foreach ($products as $product)
                        @if ($product->category?->name == 'Storage')
                            <div class="swiper-slide product-card-main">
                                <div class="mb-1">
                                    @if ($product->condition == 'Used')
                                        <span
                                            class="bg-skin-primary py-1 px-2 rounded-md text-xs text-white font-unbounded">Used</span>
                                    @else
                                        <span
                                            class="bg-skin-secondary py-1 px-2 rounded-md text-xs text-white font-unbounded">New</span>
                                    @endif
                                </div>
                                <div class="img flex flex-col justify-center items-center mb-4 overflow-hidden">
                                    <div
                                        style="height: 160px; display: flex; align-items: center; justify-content: center;">
                                        <img src="{{ asset($product->pictures[0]->image) }}"
                                            alt="{{ $product->product_name }}" class="max-w-64 max-h-full object-contain"
                                            style="max-height: 100%; max-width: 100%;">
                                    </div>
                                </div>
                                <div>
                                    <div class="flex justify-between gap-4">
                                        <div class="flex flex-col gap-1">
                                            <a href="{{ route('show.product', $product->slug) }}">
                                                <h4 class="font-semibold text-xl text-[#111928]">
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
                        @endif
                    @endforeach
                </div>
                <div
                    class="swiper-button-prev bg-skin-secondary min-w-12 min-h-12 !top-1/3 rounded-full p-2 after:text-white after:!text-2xl">
                </div>
                <div
                    class="swiper-button-next bg-skin-secondary min-w-12 min-h-12 !top-1/3 rounded-full p-2 after:text-white after:!text-2xl">
                </div>
                <div class="swiper-pagination bottom-0"></div>
            </div>





        </div>
    </section>


    <!-- Motherboards -->
    <section class="mb-20">
        <div class="px-12">
            <div class="max-w-lg mx-auto mb-12">
                <h2 class="section-heading">Motherboards</h2>
            </div>



            <div class="swiper productSwiper !pb-20">
                <div class="swiper-wrapper">
                    @foreach ($products as $product)
                        @if ($product->category?->name == 'Motherboards')
                            <div class="swiper-slide product-card-main">
                                <div class="mb-1">
                                    @if ($product->condition == 'Used')
                                        <span
                                            class="bg-skin-primary py-1 px-2 rounded-md text-xs text-white font-unbounded">Used</span>
                                    @else
                                        <span
                                            class="bg-skin-secondary py-1 px-2 rounded-md text-xs text-white font-unbounded">New</span>
                                    @endif
                                </div>
                                <div class="img flex flex-col justify-center items-center mb-4 overflow-hidden">
                                    <div
                                        style="height: 160px; display: flex; align-items: center; justify-content: center;">
                                        <img src="{{ asset($product->pictures[0]->image) }}"
                                            alt="{{ $product->product_name }}" class="max-w-64 max-h-full object-contain"
                                            style="max-height: 100%; max-width: 100%;">
                                    </div>
                                </div>
                                <div>
                                    <div class="flex justify-between gap-4">
                                        <div class="flex flex-col gap-1">
                                            <a href="{{ route('show.product', $product->slug) }}">
                                                <h4 class="font-semibold text-xl text-[#111928]">
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
                        @endif
                    @endforeach
                </div>
                <div
                    class="swiper-button-prev bg-skin-secondary min-w-12 min-h-12 !top-1/3 rounded-full p-2 after:text-white after:!text-2xl">
                </div>
                <div
                    class="swiper-button-next bg-skin-secondary min-w-12 min-h-12 !top-1/3 rounded-full p-2 after:text-white after:!text-2xl">
                </div>
                <div class="swiper-pagination bottom-0"></div>
            </div>
        </div>
    </section>
@endsection
