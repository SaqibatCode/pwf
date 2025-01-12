@extends('store-front.layout.layout')

@section('main-content')
    <section class="px-4 sm:px-12">

        <div class="mx-auto py-12">

            <div class="grid grid-cols-6 sm:border rounded-xl">

                <div class="relative min-h-screen">
                    <div class="p-6 bg-skin-fill h-max lg:flex flex-col gap-8 max-lg:hidden sticky top-12 left-0">

                        <div class="flex flex-col gap-3">
                            <h3 class="filter-heading">Price</h3>

                            <!-- <div class="relative mb-6">
                                    <input id="labels-range-input" type="range" value="0" min="100" max="1500"
                                        class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer">
                                    <span class="text-sm text-skin-primary absolute start-0 -bottom-6">Rs100</span>
                                    <span class="text-sm text-skin-primary absolute end-0 -bottom-6">Rs1500</span>
                                </div> -->


                            <input class="product-form-inp" placeholder="Lowest" type="number" name=""
                                id="" value="0">
                            <input class="product-form-inp" placeholder="Highest" type="number" name=""
                                id="" value="500">

                            <button
                                class="mt-3 rounded-md w-full py-1 text-sm border border-blue-700 font-semibold bg-white text-skin-primary hover:border-blue-700 hover:bg-skin-secondary hover:text-skin-inverted transition-all duration-300 font-unbounded">
                                Filter</button>
                        </div>

                        <div class="flex flex-col gap-3">
                            <h3 class="filter-heading">Color</h3>

                            <ul class="flex flex-col gap-2">
                                <li class="color-li group"><span class="color-circle bg-white"></span><span
                                        class="color-text">White</span></li>
                                <li class="color-li group"><span class="color-circle bg-black"></span><span
                                        class="color-text">Black</span></li>
                                <li class="color-li group"><span class="color-circle bg-green-600"></span><span
                                        class="color-text">Green</span></li>
                                <li class="color-li group"><span class="color-circle bg-red-600"></span><span
                                        class="color-text">Red</span></li>
                                <li class="color-li group"><span class="color-circle bg-yellow-400"></span><span
                                        class="color-text">Yellow</span></li>
                            </ul>

                        </div>


                        <div class="flex flex-col gap-3">
                            <h3 class="filter-heading">Size</h3>

                            <ul class="flex flex-col gap-2">
                                <li class=""><label class="flex items-center color-li group" for="big"><input
                                            class="filter-checkbox" type="checkbox" name="big" id="big"><span
                                            class="color-text">Big</span></label></li>
                                <li class=""><label class="flex items-center color-li group" for="medium"><input
                                            class="filter-checkbox" type="checkbox" name="medium" id="medium"><span
                                            class="color-text">Medium</span></label></li>
                                <li class=""><label class="flex items-center color-li group" for="small"><input
                                            class="filter-checkbox" type="checkbox" name="small" id="small"><span
                                            class="color-text">Small</span></label></li>
                            </ul>

                        </div>


                        <div class="flex flex-col gap-3">
                            <h3 class="filter-heading">Tags</h3>

                            <ul class="flex flex-wrap gap-2 w-full">
                                <li class=""><label class="tags-check-label group" for="smartphone"><input
                                            class="tags-checkbox" type="checkbox" name="smartphone" id="smartphone"><span
                                            class="tags-text">Smartphone</span></label></li>
                                <li class=""><label class="tags-check-label group" for="laptop"><input
                                            class="tags-checkbox" type="checkbox" name="laptop" id="laptop"><span
                                            class="tags-text">Laptop</span></label></li>
                                <li class=""><label class="tags-check-label group" for="tv"><input
                                            class="tags-checkbox" type="checkbox" name="tv" id="tv"><span
                                            class="tags-text">TV</span></label>
                                </li>
                            </ul>
                        </div>

                    </div>
                </div>


                <div class="lg:col-span-5 max-lg:col-span-6 bg-skin-fill">


                    <div class=" p-0 py-4 sm:p-4 border-b sm:border-b-0  sm:border-l flex items-end justify-between gap-4">

                        <div class="flex-1 flex flex-col md:flex-row gap-2 sm:gap-0 justify-between md:items-center">

                            <p class="text-xs sm:text-sm text-skin-primary font-unbounded">Showing
                                {{ $products->firstItem() }}–{{ $products->lastItem() }} of {{ $products->total() }} results
                            </p>

                            <select
                                class="text-xs sm:text-sm w-max border rounded-md py-1 focus:ring-0 focus:outline-none font-unbounded"
                                name="" id="">
                                <option value="default">Default Sorting</option>
                                <option value="popular">Sort By Popularity</option>
                                <option value="latest">Sort By Latest</option>
                                <option value="low-to-high">Sort By Price: Low To High</option>
                                <option value="high-to-low">Sort By Price: High To Low</option>
                            </select>
                        </div>

                        <button
                            class="lg:hidden rounded-md w-max py-1 px-2 sm:px-8 text-xs border border-blue-700 font-bold bg-white text-skin-primary  hover:bg-skin-secondary hover:text-skin-inverted duration-300 font-unbounded"
                            type="button" data-drawer-target="drawer-right-example"
                            data-drawer-show="drawer-right-example" data-drawer-placement="right"
                            aria-controls="drawer-right-example">
                            < Filter</button>

                    </div>

                    <div id="shopProductssa"
                        class="py-4 sm:p-4 grid place-items-center grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-3 2xl:grid-cols-5 gap-4 sm:border sm:border-b-0 sm:border-r-0">
                        @foreach ($products as $product)
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
                                    <img src="{{ asset('store-front/images/products/graphic-cards/image-1.png') }}"
                                        alt="{{ $product->product_name }}" class="max-w-64">
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
                        @endforeach
                        {{ $products->links() }}


                    </div>


                </div>


            </div>

        </div>


    </section>
@endsection
