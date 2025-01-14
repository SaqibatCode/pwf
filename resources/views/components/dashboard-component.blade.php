@if (session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
        <span class="block sm:inline">

            {{ session('success') }}

        </span>
    </div>
@endif
<div class="flex justify-center min-h-screen bg-gray-100">

    <div class="container mx-auto flex p-6 bg-white shadow-md rounded-lg mt-8 max-w-8xl">

        <!-- Left Sidebar Navigation -->
        <aside class="bg-gray-800 text-white w-64 flex-shrink-0 rounded-l-lg overflow-hidden">
            <div class="p-4">
                <h2 class="text-xl font-semibold mb-4">User Dashboard</h2>
                <ul>
                    <li class="{{ request()->routeIs('buyer.account.edit') ? 'bg-gray-900' : '' }}">
                        <a href="{{ route('buyer.account.edit') }}" class="block py-2 px-4 hover:bg-gray-700">My
                            Profile</a>
                    </li>
                    <li class="{{ request()->routeIs('buyer.orders.index') ? 'bg-gray-900' : '' }}">
                        <a href="{{ route('buyer.orders.index') }}" class="block py-2 px-4 hover:bg-gray-700">My
                            Orders</a>
                    </li>
                    <li>
                        <form method="post" class="block py-2 px-4 hover:bg-gray-700" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="">Logout</button>
                        </form>

                    </li>
                </ul>
            </div>
        </aside>

        <!-- Main Content Area (Rendered from Views) -->
        <main class="flex-1 overflow-y-auto p-6">
            {{ $slot }}
        </main>
    </div>
</div>
