@extends('store-front.layout.layout')
@section('additional_head')
    <!-- Slick CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css" />
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css" />
@endsection

@section('additional_foot')
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            // Initialize main slider (slider-single)
            $('.slider-single').slick({
                slidesToShow: 1,
                slidesToScroll: 1,
                arrows: false,
                fade: true,
                asNavFor: '.slider-nav'
            });

            // Initialize navigation slider (slider-nav)
            $('.slider-nav').slick({
                slidesToShow: 3,
                slidesToScroll: 1,
                asNavFor: '.slider-single',
                dots: false,
                centerMode: true,
                focusOnSelect: true
            });
        });
    </script>
@endsection
@section('main-content')
    <!-- BREADCRUMBS -->
    <section class="bg-gray-100 px-4 font-unbounded">
        <div class="container mx-auto py-4">
            <p class="text-sm">
                <a href="#" class="text-skin-secondary">Home</a> /
                <a href="#" class="text-skin-secondary">Shop</a> /
                @if ($product->category)
                    <a href="/{{ $product->category->slug }}" class="text-skin-secondary">{{ $product->category->name }}</a>
                    /
                @else
                    <span>Category: Not Available</span> /
                @endif
                <span>{{ $product->product_name }}</span>
            </p>
        </div>
    </section>

    <section class="px-4 font-unbounded">

        <div class="container mx-auto pb-12">

            <!-- PRODUCT NAME HEADER  -->
            <div class="grid grid-cols-1 lg:grid-cols-2 border-b py-4">
                <div>
                    <h2 class="text-skin-primary text-2xl font-bold mb-3">{{ $product->product_name }}</h2>

                    <ul class="flex flex-col sm:flex-row text-sm text-gray-600">
                        <li class="pl-0 sm:px-4 sm:border-r border-black">
                            @if ($product->brand)
                                Brand: <a href="/{{ $product->brand->slug }}"
                                    class="text-skin-secondary">{{ $product->brand->name }}</a>
                            @else
                                Brand: Not Available
                            @endif
                        </li>
                        </li>
                        <li class="sm:px-4 sm:border-r border-black"><a href="">1 Review</a></li>
                        <li class="sm:px-4">SKU: {{ $product->sku }}</li>
                    </ul>

                </div>
                <div class="flex gap-4 justify-start lg:justify-end mt-3 lg:mt-0">

                    <a href="#">
                        <svg class="text-2xl text-[#3b5998]" stroke="currentColor" fill="currentColor" stroke-width="0"
                            viewBox="0 0 512 512" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M504 256C504 119 393 8 256 8S8 119 8 256c0 123.78 90.69 226.38 209.25 245V327.69h-63V256h63v-54.64c0-62.15 37-96.48 93.67-96.48 27.14 0 55.52 4.84 55.52 4.84v61h-31.28c-30.8 0-40.41 19.12-40.41 38.73V256h68.78l-11 71.69h-57.78V501C413.31 482.38 504 379.78 504 256z">
                            </path>
                        </svg>
                    </a>

                    <a href="#">
                        <svg class="text-2xl text-[#C13584]" stroke="currentColor" fill="currentColor" stroke-width="0"
                            viewBox="0 0 448 512" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z">
                            </path>
                        </svg>
                    </a>


                    <a href="#">
                        <svg class="text-2xl text-[#0762C8]" stroke="currentColor" fill="currentColor" stroke-width="0"
                            viewBox="0 0 448 512" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M416 32H31.9C14.3 32 0 46.5 0 64.3v383.4C0 465.5 14.3 480 31.9 480H416c17.6 0 32-14.5 32-32.3V64.3c0-17.8-14.4-32.3-32-32.3zM135.4 416H69V202.2h66.5V416zm-33.2-243c-21.3 0-38.5-17.3-38.5-38.5S80.9 96 102.2 96c21.2 0 38.5 17.3 38.5 38.5 0 21.3-17.2 38.5-38.5 38.5zm282.1 243h-66.4V312c0-24.8-.5-56.7-34.5-56.7-34.6 0-39.9 27-39.9 54.9V416h-66.4V202.2h63.7v29.2h.9c8.9-16.8 30.6-34.5 62.9-34.5 67.2 0 79.7 44.3 79.7 101.9V416z">
                            </path>
                        </svg>
                    </a>


                </div>
            </div>

            <!-- PRODUCT INFO AND IMAGES -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 py-4">

                <div id="page">
                    <div class="sm:px-6">
                        <div class="column small-11 small-centered">
                            <div class="slider slider-single">
                                @foreach ($product->pictures as $img)
                                    <div class="">
                                        <img src="{{ asset($img->image) }}" alt="" class="object-contain mx-auto">
                                    </div>
                                @endforeach
                            </div>
                            <div class="slider slider-nav">

                                @foreach ($product->pictures as $img)
                                    <div class="">
                                        <div class="border w-[110px] transition-all duration-300 hover:border-blue-600">
                                            <img src="{{ asset($img->image) }}" alt="">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col gap-1">
                    <div class="flex flex-col gap-2 pb-6 border-b">
                        <div class="flex items-center gap-2">
                            @if ($product->sale_price !== null)
                                <h2 class="text-2xl font-bold text-skin-odd">Rs.{{ $product->price }}</h2> <del
                                    class="text-sm">Rs.{{ $product->price }}</del>
                            @else
                                <h2 class="text-2xl font-bold text-skin-odd">Rs.{{ $product->price }}</h2>
                            @endif

                        </div>
                        <div>
                            @if ($product->stock_quanity >= 1)
                                <p class="text-sm">Status: <span class="text-skin-unique font-bold">In Stock</span></p>
                            @else
                                <p class="text-sm">Status: <span class="text-skin-unique font-bold">Out Of Stock</span></p>
                            @endif
                        </div>
                    </div>
                    <div class="px-4 py-6 border-b">
                        <ul class="flex flex-col gap-2 list-disc text-sm text-gray-600">
                            <p>{{ $product->description }}</p>
                        </ul>
                    </div>

                    <div class="py-6 border-b flex flex-col sm:flex-row items-start sm:items-end gap-4 sm:gap-6">
                        <form action="{{ route('cart.add', $product) }}" method="POST" class="flex items-center gap-6">
                            @csrf

                            <!-- Quantity Section -->
                            <div class="flex items-center gap-4">
                                <span class="text-gray-600 text-sm">Quantity:</span>
                                <div class="flex items-center justify-center bg-gray-100 rounded-md p-1">
                                    <!-- Quantity Input -->
                                    <input type="number" name="quantity" id="quantity" value="1" min="1"
                                        class="px-4 py-2 border rounded-md w-16 text-lg font-semibold text-gray-700">
                                </div>
                            </div>

                            <!-- Add to Cart Button -->
                            <button type="submit"
                                class="btn-1 px-8 py-2 bg-blue-600 text-white rounded-md text-lg font-medium hover:bg-blue-700 transition-colors duration-300">
                                Add To Cart
                            </button>
                        </form>
                    </div>
                    @if (session('cart_message'))
                        <div class="mt-4 text-green-600 font-semibold">
                            {{ session('cart_message') }}
                        </div>
                    @endif
                    <div class="py-6 flex flex-col gap-1">
                        @if ($product->category)
                            <p class="text-sm">Category: <a href="/{{ $product->category->slug }}"
                                    class="text-skin-secondary transition-all duration-300 hover:text-skin-primary">{{ $product->category->name }}</a>
                            </p>
                        @else
                            <p class="text-sm">Category: Not Available</p>
                        @endif
                    </div>
                </div>

            </div>

            <div class="py-4">
                <div class="mb-6">
                    <h2 class="section-heading text-2xl text-start text-skin-gray">About Seller</h2>
                </div>
                <div class="flex flex-col md:flex-row gap-4 justify-center items-center">
                    <div class="max-w-20 max-h-20">
                        <img src="assets/images/image/pngwing.com.png" alt="" class="max-w-20 max-h-20">
                    </div>
                    <div class="">
                        <h5 class="font-unbounded text-lg">{{ $product->user->first_name }}</h5>
                        <p class="text-gray-500 mb-2">{{ $product->user->verification }}Seller</p>
                        <a href="{{ route('show.seller.portfolio', $product->user->slug) }}"
                            class="border rounded-md p-2 text-xs hover:text-skin-secondary">View Seller
                            Profile</a>
                    </div>
                    <div class="border rounded-md p-2">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-gray-500 font-unbounded text-sm">From</p>
                                <p class="font-unbounded font-bold">{{ $product->user->first_name }}</p>
                            </div>
                            <div>
                                <p class="text-gray-500 font-unbounded text-sm">Rating</p>
                                <p class="font-unbounded font-bold">4.5</p>
                            </div>
                            <div>
                                <p class="text-gray-500 font-unbounded text-sm">Member Since</p>
                                <p class="font-unbounded font-bold">{{ $product->user->created_at->format('F j, Y') }}
                                </p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

    </section>

    <section class="px-4 font-unbounded">
        <div class="container mx-auto pb-12">
            <div class="mb-4 border-b border-gray-200">
                <ul id="myTabs" class="flex justify-center flex-wrap -mb-px text-sm font-medium text-center"
                    role="tablist">
                    <li class="me-2" role="presentation">
                        <button id="description-tab"
                            class="inline-block p-4 border-b-2 rounded-t-lg !text-skin-secondary !border-blue-700 transition-all duration-300"
                            data-tab-target="#description-content" type="button" role="tab"
                            aria-controls="description-content" aria-selected="true">
                            Description
                        </button>
                    </li>
                    <li class="me-2" role="presentation">
                        <button id="specification-tab"
                            class="inline-block p-4 border-b-2 rounded-t-lg text-skin-primary border-gray-700 transition-all duration-300 hover:text-skin-secondary hover:border-blue-700"
                            data-tab-target="#specification-content" type="button" role="tab"
                            aria-controls="specification-content" aria-selected="false">
                            Specification
                        </button>
                    </li>
                    <li class="me-2" role="presentation">
                        <button id="reviews-tab"
                            class="inline-block p-4 border-b-2 rounded-t-lg text-skin-primary border-gray-700 transition-all duration-300 hover:text-skin-secondary hover:border-blue-700"
                            data-tab-target="#reviews-content" type="button" role="tab"
                            aria-controls="reviews-content" aria-selected="false">
                            Reviews
                        </button>
                    </li>
                </ul>
            </div>
            <div id="tab-contents">
                <div class="p-4 max-h-[500px] overflow-auto" id="description-content" role="tabpanel"
                    aria-labelledby="description-tab">
                    <p class="text-sm">
                        {{ $product->description }}
                    </p>
                </div>
                <div class="hidden p-4 overflow-auto" id="specification-content" role="tabpanel"
                    aria-labelledby="specification-tab">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 shadow-md rounded-md">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Attribute
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Value
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="keyValueTableBody"
                                class="bg-white divide-y divide-gray-200">
                                @if ($product->parts)
                                    @foreach ($product->parts as $parts)
                                        <tr class="hover:bg-gray-100-800">
                                            <td
                                                class="px-6 py-4 whitespace-nowrap uppercase text-sm font-medium text-gray-900">
                                                {{ STR_REPLACE('_', ' ', $parts->key) }}</td>
                                            <td
                                                class="px-6 py-4 whitespace-nowrap uppercase text-sm text-gray-500">
                                                {{ $parts->value }}</td>
                                        </tr>
                                    @endforeach
                                @endif
                                @if ($productAttributes)
                                    @foreach ($productAttributes as $attribute)
                                        <tr class="hover:bg-gray-100-800">
                                            <td
                                                class="px-6 py-4 whitespace-nowrap uppercase text-sm font-medium text-gray-900">
                                                {{ $attribute['attribute_name'] }}</td>
                                            <td
                                                class="px-6 py-4 whitespace-nowrap uppercase text-sm text-gray-500">
                                                {{ $attribute['attribute_value'] }}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>

                    </div>
                </div>
                <div class="hidden p-4 max-h-[500px] overflow-auto" id="reviews-content" role="tabpanel"
                    aria-labelledby="reviews-tab">
                    <p class="text-sm">
                        This is the reviews tab's content <strong class="font-medium text-skin-secondary">Reviews</strong>.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="px-4">
        <div class="container mx-auto pb-12">

            <div class="flex justify-center items-center p-4 sm:p-5 mb-8 border-b bg-gray-100">
                <h3 class="section-heading">Related Products</h3>
            </div>

            <div
                class="grid place-items-center grid-cols-1 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-4 2xl:grid-cols-5 gap-4">
                @foreach ($relatedProducts as $product)
                    <div class="product-card-main">
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
                            <img src="{{ asset($product->pictures[0]->image) }}"
                                alt="{{ $product->product_name }}" class="max-w-64">
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



        </div>
    </section>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tabs = document.querySelectorAll('#myTabs button');
            const tabContents = document.querySelectorAll('#tab-contents > div');

            function activateTab(tabId) {

                tabs.forEach(tab => {
                    tab.classList.remove('!text-skin-secondary', '!border-blue-700');
                    tab.classList.add('text-skin-primary', 'border-gray-700', 'hover:text-skin-secondary',
                        'hover:border-blue-700');
                    tab.setAttribute('aria-selected', false)
                });

                tabContents.forEach(content => {
                    content.classList.add('hidden')
                })

                const selectedTab = document.querySelector(`#${tabId}-tab`);
                selectedTab.classList.remove('text-skin-primary', 'border-gray-700', 'hover:text-skin-secondary',
                    'hover:border-blue-700')
                selectedTab.classList.add('!text-skin-secondary', '!border-blue-700')
                selectedTab.setAttribute('aria-selected', true);

                const selectedContent = document.querySelector(selectedTab.getAttribute('data-tab-target'))
                selectedContent.classList.remove('hidden');
            }

            tabs.forEach(tab => {
                tab.addEventListener('click', function(e) {
                    const targetId = this.getAttribute('id').replace('-tab', '')
                    activateTab(targetId)
                });
            });
            //set default selected tab
            activateTab('description');
        });
    </script>
@endsection
