@if (session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
        <span class="block sm:inline">
            {{ session('success') }}
        </span>
    </div>
@endif

<div class="flex justify-center min-h-screen bg-gray-100 relative">
    <div
        class="container mx-auto flex flex-col md:flex-row p-6 bg-white shadow-md rounded-xl my-12 max-w-8xl font-poppins">
        <!-- Hamburger Menu for Mobile -->
        <div class="md:hidden mb-4">
            <button id="sidebarToggle" class="text-skin-secondary focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7">
                    </path>
                </svg>
            </button>
        </div>

        <!-- Left Sidebar Navigation -->
        <aside id="sidebar"
            class="bg-skin-secondary text-white h-full max-h-[950px] md:max-h-full absolute md:static top-24 flex-shrink-0 rounded-lg overflow-hidden duration-200 -translate-x-72 md:translate-x-0 md:block">
            <div class="p-4">
                <h2 class="text-xl font-semibold mb-4">User Dashboard</h2>
                <ul class="space-y-2">
                    <li
                        class="{{ request()->routeIs('buyer.account.edit') ? 'bg-white rounded-lg text-skin-secondary' : '' }}">
                        <a href="{{ route('buyer.account.edit') }}"
                            class="block py-2 px-4 hover:bg-gray-200 duration-200 hover:text-skin-secondary rounded-lg">My
                            Profile</a>
                    </li>
                    <li
                        class="{{ request()->routeIs('buyer.orders.index') ? 'bg-white rounded-lg text-skin-secondary' : '' }}">
                        <a href="{{ route('buyer.orders.index') }}"
                            class="block py-2 px-4 hover:bg-gray-200 duration-200 hover:text-skin-secondary rounded-lg">My
                            Orders</a>
                    </li>
                    <li>
                        <form method="post"
                            class="block py-2 px-4 hover:bg-gray-200 duration-200 hover:text-skin-secondary rounded-lg"
                            action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="">Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        </aside>

        <!-- Main Content Area (Rendered from Views) -->
        <main class="flex-1 overflow-y-auto md:p-6">
            {{ $slot }}
        </main>
    </div>
</div>

<script>
      document.getElementById('sidebarToggle').addEventListener('click', function() {
        var sidebar = document.getElementById('sidebar');
        sidebar.classList.toggle('-translate-x-72');
    });
</script>
