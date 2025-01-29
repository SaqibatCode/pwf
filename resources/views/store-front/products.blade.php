@extends('store-front.layout.layout')

@section('main-content')
    <section class="px-4 sm:px-12">

        <div class="mx-auto py-12">

            <div class="grid grid-cols-6 sm:border rounded-xl">

                <form method="GET" action="{{ route('show.shop') }}">
                    <!-- Price Range Filter -->
                    <div class="relative min-h-screen">
                        <div class="p-6 bg-skin-fill h-max lg:flex flex-col gap-8 max-lg:hidden sticky top-12 left-0">
                            <div class="flex flex-col gap-3">
                                <h3 class="filter-heading">Price</h3>
                                <input class="product-form-inp" placeholder="Lowest" type="number" name="min_price"
                                    value="{{ request('min_price') }}">
                                <input class="product-form-inp" placeholder="Highest" type="number" name="max_price"
                                    value="{{ request('max_price') }}">

                                <button type="submit"
                                    class="mt-3 rounded-md w-full py-1 text-sm border border-blue-700 font-semibold bg-white text-skin-primary hover:border-blue-700 hover:bg-skin-secondary hover:text-skin-inverted transition-all duration-300 font-unbounded">
                                    Filter
                                </button>
                            </div>

                            <!-- Category Filter (Dynamic categories based on available products) -->
                            <div class="flex flex-col gap-3">
                                <h3 class="filter-heading">Category</h3>
                                <ul class="flex flex-col gap-2">
                                    @foreach ($categories as $category)
                                        <li>
                                            <label class="flex items-center color-li group"
                                                for="category-{{ $category->slug }}">
                                                <input class="filter-checkbox" type="checkbox" name="category[]"
                                                    value="{{ $category->slug }}" id="category-{{ $category->slug }}"
                                                    {{ in_array($category->slug, request('category', [])) ? 'checked' : '' }}>
                                                <span class="color-text">{{ $category->name }}</span>
                                            </label>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>

                            <!-- Brand Filter (Dynamic brands based on available products) -->
                            <div class="flex flex-col gap-3">
                                <h3 class="filter-heading">Brand</h3>
                                <ul class="flex flex-col gap-2">
                                    @foreach ($brands as $brand)
                                        <li>
                                            <label class="flex items-center color-li group" for="brand-{{ $brand->slug }}">
                                                <input class="filter-checkbox" type="checkbox" name="brand[]"
                                                    value="{{ $brand->slug }}" id="brand-{{ $brand->slug }}"
                                                    {{ in_array($brand->slug, request('brand', [])) ? 'checked' : '' }}>
                                                <span class="color-text">{{ $brand->name }}</span>
                                            </label>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>

                            <!-- Optional Filters for Color, Size, Tags (If applicable to your products) -->
                            <div class="flex flex-col gap-3">
                                <h3 class="filter-heading">Color</h3>
                                <ul class="flex flex-col gap-2">
                                    <li><label class="flex items-center color-li group"><input class="filter-checkbox"
                                                type="checkbox" name="color[]" value="white"><span
                                                class="color-text">White</span></label></li>
                                    <li><label class="flex items-center color-li group"><input class="filter-checkbox"
                                                type="checkbox" name="color[]" value="black"><span
                                                class="color-text">Black</span></label></li>
                                    <!-- Add more colors as needed -->
                                </ul>
                            </div>

                            <!-- Size Filter -->
                            <div class="flex flex-col gap-3">
                                <h3 class="filter-heading">Size</h3>
                                <ul class="flex flex-col gap-2">
                                    <li><label class="flex items-center color-li group"><input class="filter-checkbox"
                                                type="checkbox" name="size[]" value="big"><span
                                                class="color-text">Big</span></label></li>
                                    <li><label class="flex items-center color-li group"><input class="filter-checkbox"
                                                type="checkbox" name="size[]" value="medium"><span
                                                class="color-text">Medium</span></label></li>
                                    <li><label class="flex items-center color-li group"><input class="filter-checkbox"
                                                type="checkbox" name="size[]" value="small"><span
                                                class="color-text">Small</span></label></li>
                                </ul>
                            </div>

                            <!-- Tags Filter -->
                            <div class="flex flex-col gap-3">
                                <h3 class="filter-heading">Tags</h3>
                                <ul class="flex flex-wrap gap-2 w-full">
                                    <li><label class="tags-check-label group"><input class="tags-checkbox" type="checkbox"
                                                name="tags[]" value="smartphone"><span
                                                class="tags-text">Smartphone</span></label></li>
                                    <li><label class="tags-check-label group"><input class="tags-checkbox" type="checkbox"
                                                name="tags[]" value="laptop"><span class="tags-text">Laptop</span></label>
                                    </li>
                                    <li><label class="tags-check-label group"><input class="tags-checkbox" type="checkbox"
                                                name="tags[]" value="tv"><span class="tags-text">TV</span></label></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </form>



                <div class="lg:col-span-5 max-lg:col-span-6 bg-skin-fill">


                    <div class=" p-0 py-4 sm:p-4 border-b sm:border-b-0  sm:border-l flex items-end justify-between gap-4">

                        <div class="flex-1 flex flex-col md:flex-row gap-2 sm:gap-0 justify-between md:items-center">

                            <p class="text-xs sm:text-sm text-skin-primary font-unbounded">Showing
                                {{ $products->firstItem() }}–{{ $products->lastItem() }} of {{ $products->total() }}
                                results
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
                            <div class="product-card-main h-full flex flex-col justify-between">
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
