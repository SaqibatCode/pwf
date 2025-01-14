<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('page-title') - Playware</title>
    <link rel="stylesheet" href="{{ asset('style/output.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @yield('additional_head')
</head>

<body>
    <header class="px-4 relative">
        <div class="lg:container mx-auto py-2 border-b border-[#EAEAEA]">
            <div class="flex items-center justify-between h-16">
                <!-- <div> -->
                <!-- Placeholder for left content if needed -->
                <!-- </div> -->
                <div class="flex items-center">
                    <img class="min-h-12" src="{{ asset('store-front/images/logo/circuit.svg') }}" alt="Workflow">
                    <div class="ml-4">
                        <!-- Placeholder for additional branding -->
                    </div>
                </div>
                <div class="flex gap-4">

                    @if (Auth::check())
                        <p>Good Day, {{ Auth::user()->first_name }}</p>
                        <a href=""><i class="fa-solid fa-user"></i></a>

                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit"><i class="fa-solid fa-power-off"></i></button>
                        </form>
                    @else
                        <a href="{{ route('buyer.login') }}">
                            <p>Login<i class="fa-solid fa-power-off"></i></p>
                        </a>
                    @endif
                    <a href="{{ route('cart.show') }}"><i class="fa-solid fa-bag-shopping"></i></a>
                </div>
            </div>
        </div>
        <div class="container mx-auto py-2 font-semibold px-4">
            <div class="flex items-center justify-between">
                <div>
                    <a href="#" class="text-skin-secondary text-sm">All Categories</a>
                </div>
                <div class="hidden lg:flex gap-10 tracking-widest text-sm relative">
                    <div class="relative group">
                        <a href="{{ route('show.shop') }}" class="hover:text-skin-secondary font-semibold">All
                            Products</a>
                        <div
                            class="submenu absolute left-0 hidden group-hover:block bg-white shadow-lg rounded-lg py-2 z-50 min-w-56">
                            <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Product 1</a>
                            <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Product 2</a>
                            <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Product 3</a>
                        </div>
                    </div>
                    <div class="relative group">
                        <a href="#" class="hover:text-skin-secondary font-semibold">Complete Build</a>
                        <div
                            class="submenu absolute left-0 hidden group-hover:block bg-white shadow-lg rounded-lg py-2 z-50 min-w-56">
                            <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Build Option 1</a>
                            <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Build Option 2</a>
                        </div>
                    </div>
                    <div class="relative group">
                        <a href="#" class="hover:text-skin-secondary font-semibold">Bundled Packages</a>
                        <div
                            class="submenu absolute left-0 hidden group-hover:block bg-white shadow-lg rounded-lg py-2 z-50 min-w-56">
                            <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Package 1</a>
                            <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Package 2</a>
                        </div>
                    </div>
                    <a href="#" class="text-skin-secondary flex gap-2 items-center">
                        <img src="{{ asset('store-front/images/icons/dot-hot.png') }}" alt="" class="h-5 w-5">
                        Become a Vendor
                    </a>
                </div>
                <div>
                </div>
                <!-- Mobile menu button -->
                <div class="lg:hidden relative">
                    <button id="menu-toggle" class="text-2xl focus:outline-none">
                        <i class="fa-solid fa-bars"></i>
                    </button>
                </div>

                <!-- Mobile menu -->
            </div>
        </div>

        <div id="mobile-menu"
            class="lg:hidden flex absolute z-[9999] left-0 top-28 w-full flex-col gap-4 mt-4 bg-white p-4 shadow-lg rounded-lg">
            <a href="#" class="hover:text-skin-secondary">Home</a>
            <div class="mobile-submenu">
                <a href="#" class="flex justify-between items-center hover:text-skin-secondary">
                    All Products
                    <i class="fa-solid fa-chevron-down"></i>
                </a>
                <div class="submenu hidden flex-col gap-2 mt-2">
                    <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Product 1</a>
                    <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Product 2</a>
                    <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Product 3</a>
                </div>
            </div>
            <div class="mobile-submenu">
                <a href="#" class="flex justify-between items-center hover:text-skin-secondary">
                    Complete Build
                    <i class="fa-solid fa-chevron-down"></i>
                </a>
                <div class="submenu hidden flex-col gap-2 mt-2">
                    <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Build Option 1</a>
                    <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Build Option 2</a>
                </div>
            </div>
            <div class="mobile-submenu">
                <a href="#" class="flex justify-between items-center hover:text-skin-secondary">
                    Bundled Packages
                    <i class="fa-solid fa-chevron-down"></i>
                </a>
                <div class="submenu hidden flex-col gap-2 mt-2">
                    <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Package 1</a>
                    <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Package 2</a>
                </div>
            </div>
            <a href="#" class="text-skin-secondary flex gap-2 items-center">
                <img src="{{ asset('store-front/images/icons/dot-hot.png') }}" alt="" class="h-5 w-5"> Become
                a Vendor
            </a>
        </div>

    </header>


    @yield('main-content')

    <!-- NEWS LETTER -->

    <section class="h-[265px] bg-skin-secondary">
        <div class="container mx-auto h-full">
            <div class="grid grid-cols-1 md:grid-cols-2 h-full">
                <div class="flex flex-col justify-center px-4 md:pl-24">
                    <span class="text-sm md:text-lg text-white mb-4">Subscribe to our newsletter</span>
                    <h4 class="text-3xl sm:text-3xl md:text-5xl font-bold text-white">Get Exciting Offers <br> Directly
                        to your Email.</h4>
                </div>
                <div class="flex gap-4 justify-center items-center">
                    <form action="" class="flex gap-4 justify-center items-center">
                        <input type="email" placeholder="Email" name="email"
                            class="placeholder:text-skin-gray p-2 sm:p-4 rounded-md">
                        <button
                            class=" py-2 px-3 sm:py-4 sm:px-6 text-base text-skin-secondary bg-white rounded-md font-semibold">Subscribe</button>
                    </form>
                </div>
            </div>
        </div>
    </section>


    <Footer>
        <div class="container mx-auto px-6 pt-6">
            <!-- Social media icons container -->
            <div class="mb-6 flex justify-center">
                <a href="#!" type="button"
                    class="m-1 h-9 w-9 rounded-full border-2 border-white uppercase leading-normal text-skin-gray transition duration-150 ease-in-out hover:bg-black hover:bg-opacity-5 focus:outline-none focus:ring-0"
                    data-te-ripple-init data-te-ripple-color="light">
                    <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-full w-4" fill="currentColor"
                        viewBox="0 0 24 24">
                        <path
                            d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z" />
                    </svg>
                </a>

                <a href="#!" type="button"
                    class="m-1 h-9 w-9 rounded-full border-2 border-white uppercase leading-normal text-skin-gray transition duration-150 ease-in-out hover:bg-black hover:bg-opacity-5 focus:outline-none focus:ring-0"
                    data-te-ripple-init data-te-ripple-color="light">
                    <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-full w-4" fill="currentColor"
                        viewBox="0 0 24 24">
                        <path
                            d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z" />
                    </svg>
                </a>

                <a href="#!" type="button"
                    class="m-1 h-9 w-9 rounded-full border-2 border-white uppercase leading-normal text-skin-gray transition duration-150 ease-in-out hover:bg-black hover:bg-opacity-5 focus:outline-none focus:ring-0"
                    data-te-ripple-init data-te-ripple-color="light">
                    <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-full w-4" fill="currentColor"
                        viewBox="0 0 24 24">
                        <path
                            d="M7 11v2.4h3.97c-.16 1.029-1.2 3.02-3.97 3.02-2.39 0-4.34-1.979-4.34-4.42 0-2.44 1.95-4.42 4.34-4.42 1.36 0 2.27.58 2.79 1.08l1.9-1.83c-1.22-1.14-2.8-1.83-4.69-1.83-3.87 0-7 3.13-7 7s3.13 7 7 7c4.04 0 6.721-2.84 6.721-6.84 0-.46-.051-.81-.111-1.16h-6.61zm0 0 17 2h-3v3h-2v-3h-3v-2h3v-3h2v3h3v2z"
                            fill-rule="evenodd" clip-rule="evenodd" />
                    </svg>
                </a>

                <a href="#!" type="button"
                    class="m-1 h-9 w-9 rounded-full border-2 border-white uppercase leading-normal text-skin-gray transition duration-150 ease-in-out hover:bg-black hover:bg-opacity-5 focus:outline-none focus:ring-0"
                    data-te-ripple-init data-te-ripple-color="light">
                    <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-full w-4" fill="currentColor"
                        viewBox="0 0 24 24">
                        <path
                            d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                    </svg>
                </a>

                <a href="#!" type="button"
                    class="m-1 h-9 w-9 rounded-full border-2 border-white uppercase leading-normal text-skin-gray transition duration-150 ease-in-out hover:bg-black hover:bg-opacity-5 focus:outline-none focus:ring-0"
                    data-te-ripple-init data-te-ripple-color="light">
                    <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-full w-4" fill="currentColor"
                        viewBox="0 0 24 24">
                        <path
                            d="M4.98 3.5c0 1.381-1.11 2.5-2.48 2.5s-2.48-1.119-2.48-2.5c0-1.38 1.11-2.5 2.48-2.5s2.48 1.12 2.48 2.5zm.02 4.5h-5v16h5v-16zm7.982 0h-4.968v16h4.969v-8.399c0-4.67 6.029-5.052 6.029 0v8.399h4.988v-10.131c0-7.88-8.922-7.593-11.018-3.714v-2.155z" />
                    </svg>
                </a>

                <a href="#!" type="button"
                    class="m-1 h-9 w-9 rounded-full border-2 border-white uppercase leading-normal text-skin-gray transition duration-150 ease-in-out hover:bg-black hover:bg-opacity-5 focus:outline-none focus:ring-0"
                    data-te-ripple-init data-te-ripple-color="light">
                    <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-full w-4" fill="currentColor"
                        viewBox="0 0 24 24">
                        <path
                            d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z" />
                    </svg>
                </a>
            </div>


            <!-- Links section -->
            <div class="grid grid-cols-2 lg:grid-cols-4">
                <div class="mb-6 text-start">
                    <h5 class="mb-2.5 font-bold uppercase">Quick Links</h5>

                    <ul class="mb-0 list-none">
                        <li>
                            <a href="#!"
                                class="text-skin-gray hover:text-skin-secondary duration-300 transition-all font-semibold">Shop</a>
                        </li>
                        <li>
                            <a href="#!"
                                class="text-skin-gray hover:text-skin-secondary duration-300 transition-all font-semibold">About
                                us</a>
                        </li>
                        <li>
                            <a href="#!"
                                class="text-skin-gray hover:text-skin-secondary duration-300 transition-all font-semibold">Contact
                                Us</a>
                        </li>
                        <li>
                            <a href="#!"
                                class="text-skin-gray hover:text-skin-secondary duration-300 transition-all font-semibold">Support</a>
                        </li>
                    </ul>
                </div>

                <div class="mb-6 text-start">
                    <h5 class="mb-2.5 font-bold uppercase">Useful Links</h5>

                    <ul class="mb-0 list-none">
                        <li>
                            <a href="#!"
                                class="text-skin-gray hover:text-skin-secondary duration-300 transition-all font-semibold">Terms
                                & Conditions</a>
                        </li>
                        <li>
                            <a href="#!"
                                class="text-skin-gray hover:text-skin-secondary duration-300 transition-all font-semibold">FAQ's</a>
                        </li>
                        <li>
                            <a href="#!"
                                class="text-skin-gray hover:text-skin-secondary duration-300 transition-all font-semibold">About
                                Us</a>
                        </li>
                        <li>
                            <a href="#!"
                                class="text-skin-gray hover:text-skin-secondary duration-300 transition-all font-semibold">Contact
                                Us</a>
                        </li>
                    </ul>
                </div>

                <div class="mb-6 text-start">
                    <h5 class="mb-2.5 font-bold uppercase">Find More</h5>

                    <ul class="mb-0 list-none">
                        <li>
                            <a href="#!"
                                class="text-skin-gray hover:text-skin-secondary duration-300 transition-all font-semibold">Monitor</a>
                        </li>
                        <li>
                            <a href="#!"
                                class="text-skin-gray hover:text-skin-secondary duration-300 transition-all font-semibold">Headphone</a>
                        </li>
                        <li>
                            <a href="#!"
                                class="text-skin-gray hover:text-skin-secondary duration-300 transition-all font-semibold">Graphic
                                Card</a>
                        </li>
                        <li>
                            <a href="#!"
                                class="text-skin-gray hover:text-skin-secondary duration-300 transition-all font-semibold">Mouse</a>
                        </li>
                    </ul>
                </div>

                <div class="mb-6 text-start">
                    <h5 class="mb-2.5 font-bold uppercase">Brands</h5>

                    <ul class="mb-0 list-none">
                        <li>
                            <a href="#!"
                                class="text-skin-gray hover:text-skin-secondary duration-300 transition-all font-semibold">BenQ</a>
                        </li>
                        <li>
                            <a href="#!"
                                class="text-skin-gray hover:text-skin-secondary duration-300 transition-all font-semibold">Asus</a>
                        </li>
                        <li>
                            <a href="#!"
                                class="text-skin-gray hover:text-skin-secondary duration-300 transition-all font-semibold">Razer</a>
                        </li>
                        <li>
                            <a href="#!"
                                class="text-skin-gray hover:text-skin-secondary duration-300 transition-all font-semibold">Logitech</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Copyright section -->
        <div class="w-full p-4 text-start container mx-auto">
            <p class="text-skin-gray font-medium">
                Copyright © <span id="current_year">2024</span> <a class="text-skin-gray"
                    href="#">Playware</a>. All
                Rights Reserved.
            </p>
        </div>
    </Footer>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <!-- Initialize Swiper -->
    <script>
        var swiper = new Swiper(".mySwiper", {
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
        });

        var productSwiper = new Swiper(".productSwiper", {
            slidesPerView: 4, // Adjust to show multiple products
            spaceBetween: 20, // Adjust spacing between slides
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true, // Enables clicking on pagination dots to navigate
            },
            autoplay: {
                delay: 3000, // Autoplay interval in milliseconds
            },
            breakpoints: {
                320: {
                    slidesPerView: 1,
                    spaceBetween: 10,
                },
                640: {
                    slidesPerView: 2,
                    spaceBetween: 10,
                },
                768: {
                    slidesPerView: 3,
                    spaceBetween: 15,
                },
                1024: {
                    slidesPerView: 5,
                    spaceBetween: 20,
                },
            },
        });

        document.getElementById('current_year').innerText = new Date().getFullYear();

        document.addEventListener("DOMContentLoaded", () => {
            const menuToggle = document.getElementById("menu-toggle");
            const mobileMenu = document.getElementById("mobile-menu");
            const mobileSubmenus = document.querySelectorAll(".mobile-submenu");

            menuToggle.addEventListener("click", () => {
                mobileMenu.classList.toggle("hidden");
            });

            mobileSubmenus.forEach((submenu) => {
                const link = submenu.querySelector("a");
                const dropdown = submenu.querySelector(".submenu");

                link.addEventListener("click", (e) => {
                    e.preventDefault(); // Prevent default link action
                    dropdown.classList.toggle("hidden");
                });
            });
        });
    </script>

    @yield('additional_foot')
</body>

</html>
