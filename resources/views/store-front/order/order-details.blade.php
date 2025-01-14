@extends('store-front.layout.layout')

@section('main-content')
    <x-dashboard-component>
        <div class="bg-white p-8 rounded shadow-md w-full">
            <div class="flex justify-between items-center mb-6 border-b pb-4">
                <h2 class="text-3xl font-semibold text-gray-800">Order Details</h2>
                <span class="rounded-full bg-gray-200 px-4 py-1 text-gray-600 font-medium text-sm">Order
                    #{{ $order->id }}</span>
            </div>

            <div class="mb-4 flex flex-wrap gap-4">
                <div class="text-gray-700 font-semibold">
                    <p class="mb-1"> <span class="font-bold text-gray-800">Order Date:
                        </span>{{ $order->created_at->format('Y-m-d H:i:s') }}</p>
                </div>

            </div>

            <h3 class="text-2xl font-semibold mb-4 text-gray-800 mt-8">Items</h3>

            <div class="overflow-x-auto rounded-lg border border-gray-200">
                <table class="min-w-full leading-normal">
                    <thead class="bg-gray-100 border-b border-gray-300">
                        <tr>
                            <th class="px-5 py-3 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">
                                Product</th>
                            <th class="px-5 py-3 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">
                                Seller</th>
                            <th class="px-5 py-3 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">
                                Quantity</th>
                            <th class="px-5 py-3 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">
                                Price</th>
                            <th class="px-5 py-3 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">
                                Subtotal</th>
                            <th class="px-5 py-3 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">
                                Status</th>
                            <th class="px-5 py-3 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">
                                Tracking ID</th>
                            <th class="px-5 py-3 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">
                                Action</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        @foreach ($order->childOrders as $childOrder)
                            <tr class="border-b border-gray-200 hover:bg-gray-50">
                                <td class="px-5 py-4 text-sm">{{ $childOrder->product->product_name }}</td>
                                <td class="px-5 py-4 text-sm">{{ $childOrder->seller->first_name }}</td>
                                <td class="px-5 py-4 text-sm">{{ $childOrder->quantity }}</td>
                                <td class="px-5 py-4 text-sm">Rs. {{ number_format($childOrder->product->price, 2) }}</td>
                                <td class="px-5 py-4 text-sm">Rs.
                                    {{ number_format($childOrder->quantity * $childOrder->product->price, 2) }}
                                </td>
                                <td class="px-5 py-4 text-sm">{{ ucfirst($childOrder->status) }}</td>
                                <td class="px-5 py-4 text-sm">{{ $childOrder->tracking_id ?? 'N/A' }}</td>
                                <td>
                                    @if ($childOrder->status == 'Order Dispatched')
                                        <form action="{{ route('buyer.mark.delivered') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $childOrder->id }}">
                                            <button type="submit"
                                                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                                                Order Received
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-6  flex justify-end">
                <p class="text-xl text-gray-700 font-semibold">Total: <span class="text-2xl font-bold text-gray-900">Rs.
                        {{ number_format(
                            $order->childOrders->sum(function ($childOrder) {
                                return $childOrder->quantity * $childOrder->product->price;
                            }),
                            2,
                        ) }}</span>
                </p>
            </div>
        </div>
    </x-dashboard-component>
@endsection
