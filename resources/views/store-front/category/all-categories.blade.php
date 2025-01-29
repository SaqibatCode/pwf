@extends('store-front.layout.layout')

@section('main-content')
    <section class="px-4 sm:px-12 py-8">
        <div class="mx-auto max-w-7xl">
            <h2 class="mb-8 text-3xl font-bold text-skin-primary font-unbounded text-center py-12">Browse Our Categories</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
                @foreach ($categories as $category)
                    <a href="{{ route('show.single.categories', $category->slug) }}"
                        class="category-card-main group relative block overflow-hidden rounded-lg shadow-md transition-shadow hover:shadow-lg">
                        <div class="category-card bg-skin-fill rounded-lg relative overflow-hidden">
                            <div class="category-img relative overflow-hidden pb-[100%]">
                                <img src="{{ asset($category->image) }}" alt="{{ $category->category_name }}"
                                    class="absolute inset-0 w-full h-full object-cover transition-transform duration-300 group-hover:scale-110">
                            </div>
                            <div
                                class="category-content p-4 absolute bottom-0 left-0 w-full transition-transform duration-300 transform translate-y-full group-hover:translate-y-0">
                                <div class="bg-skin-fill/75 rounded p-1">
                                  <h3
                                        class="font-semibold text-lg text-skin-primary group-hover:text-skin-inverted transition-colors duration-300 ">
                                        {{ $category->name }}
                                    </h3>
                                    <p
                                        class="text-sm text-skin-gray group-hover:text-skin-inverted transition-colors duration-300 mt-1 ">
                                        {{ $category->products_count }} Products</p>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>
@endsection
