@extends('store-front.layout.layout')

@section('main-content')
    <x-dashboard-component>
        <div class="bg-white p-8 rounded shadow-md w-full">
             <div class="flex justify-between items-center mb-6 border-b pb-4">
                <h2 class="text-3xl font-semibold text-gray-800">My Orders</h2>
              </div>

            @if ($orders->isEmpty())
                <p class="text-center text-gray-600 py-12">You don't have any orders yet.</p>
            @else
                <div class="overflow-x-auto rounded-lg border border-gray-200">
                    <table class="min-w-full leading-normal">
                        <thead class="bg-gray-100 border-b border-gray-300">
                            <tr>
                                <th class="px-5 py-3  text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">
                                    Order ID</th>
                                <th class="px-5 py-3  text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">
                                    Date</th>
                                <th class="px-5 py-3  text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">
                                    Total</th>
                                <th class="px-5 py-3  text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">
                                    Status</th>
                                <th class="px-5 py-3 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">
                                    Details</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white">
                            @foreach ($orders as $order)
                                <tr class="border-b border-gray-200 hover:bg-gray-50">
                                    <td class="px-5 py-4 text-sm ">#{{ $order->id }}</td>
                                    <td class="px-5 py-4 text-sm">
                                        {{ $order->created_at->format('Y-m-d') }}</td>
                                        <td class="px-5 py-4 text-sm">
                                          Rs. {{ number_format($order->childOrders->sum(function ($childOrder) {
                                                return $childOrder->quantity * $childOrder->product->price;
                                            }), 2) }}
                                      </td>
                                      <td class="px-5 py-4 text-sm">
                                          {{ $order->childOrders->first()->status ?? 'Pending' }}
                                       </td>
                                    <td class="px-5 py-4 text-sm">
                                        <a href="{{ route('buyer.orders.show', $order->id) }}"
                                            class="text-blue-500 hover:underline">View Details</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
         </div>
     </x-dashboard-component>
@endsection
