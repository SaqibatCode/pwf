@extends('store-front.layout.layout')

@section('main-content')
    <div class="container mx-auto p-6 md:p-8 lg:p-10">
        <h2 class="text-4xl font-extrabold text-gray-900 mb-10 text-center md:text-left tracking-tight transition-colors duration-300 hover:text-gray-700">
            Your Shopping Cart
        </h2>

        @if (session('success'))
            <div class="bg-green-50 border border-green-300 text-green-700 px-5 py-4 rounded-lg relative mb-6 transition-all duration-300 shadow-sm hover:shadow-md" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
                <button class="absolute top-2 right-2 text-green-500 hover:text-green-800 focus:outline-none" onclick="this.parentNode.remove();">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
        @endif
        @if (session('error'))
            <div class="bg-red-50 border border-red-300 text-red-700 px-5 py-4 rounded-lg relative mb-6 transition-all duration-300 shadow-sm hover:shadow-md" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
                <button class="absolute top-2 right-2 text-red-500 hover:text-red-800 focus:outline-none" onclick="this.parentNode.remove();">
                     <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
        @endif

        @if (!empty($groupedCartItems))
            @foreach ($groupedCartItems as $index => $cartItems)
                <div class="bg-white shadow-xl rounded-2xl overflow-hidden transition-all duration-300 hover:shadow-2xl border mb-8">
                    <div class="px-8 py-5 bg-gray-50 border-b">
                        <h3 class="text-2xl font-semibold text-gray-900 tracking-wide mb-1">Vendor: <span class="text-indigo-600">{{ $cartItems['seller']->first_name }}</span></h3>
                        <p class="text-sm text-gray-500 italic mt-1">Review your items from this vendor.</p>
                    </div>
                    <div class="p-8">
                        <div class="overflow-x-auto">
                            <table class="w-full table-auto">
                                <thead>
                                <tr class="text-left text-gray-700">
                                    <th class="py-4 px-3 font-semibold tracking-wide">Product</th>
                                    <th class="py-4 px-3 font-semibold tracking-wide">Price</th>
                                    <th class="py-4 px-3 font-semibold tracking-wide">Quantity</th>
                                    <th class="py-4 px-3 font-semibold tracking-wide">Total</th>
                                    <th class="py-4 px-3 font-semibold tracking-wide">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ($cartItems['items'] as $itemIndex => $item)
                                        @php
                                            $product = $cartItems['products']
                                                ->where('id', $item['product_id'])
                                                ->first();
                                        @endphp
                                        <tr class="border-b transition-colors duration-200 hover:bg-gray-50">
                                            <td class="py-4 px-3 text-gray-800">{{ $product->product_name }}</td>
                                            <td class="py-4 px-3 text-gray-800">${{ number_format($product->price, 2) }}</td>
                                            <td class="py-4 px-3">
                                                <form action="{{ route('cart.update') }}" method="POST" class="inline-block">
                                                 @csrf
                                                    <input type="number"
                                                        name="items[{{ $index }}.{{ $itemIndex }}][quantity]"
                                                        value="{{ $item['quantity'] }}" min="1"
                                                        class="border rounded px-3 py-2 w-20 text-center quantity-input focus:ring-2 focus:ring-indigo-300 focus:border-indigo-500">
                                                    <input type="hidden"
                                                        name="items[{{ $index }}.{{ $itemIndex }}][product_id]"
                                                        value="{{ $item['product_id'] }}">
                                                    </form>
                                                </td>
                                                <td class="py-4 px-3 text-gray-800 font-semibold">${{ number_format($product->price * $item['quantity'], 2) }}</td>
                                                <td class="py-4 px-3">
                                                    <form action="{{ route('cart.remove') }}" method="POST" class="inline-block">
                                                        @csrf
                                                        <input type="hidden" name="product_id" value="{{ $item['product_id'] }}">
                                                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-3 rounded text-sm focus:outline-none transition-colors duration-200">Remove</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot class="font-semibold text-gray-800">
                                        <tr>
                                            <td colspan="3" class="text-right py-4 px-3"><strong>Total Amount for this Seller:</strong></td>
                                            <td class="py-4 px-3 font-bold">
                                                  ${{ number_format(collect($cartItems['items'])->reduce(function ($total, $item) use ($cartItems) {
                                                      $product = $cartItems['products']->where('id', $item['product_id'])->first();
                                                      return $total + $product->price * $item['quantity'];
                                                  }, 0),2) }}
                                                </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>

                             <div class="mt-8 border-t pt-5">
                                 <p class="font-semibold text-gray-800 mb-3">Payment Method:</p>
                                <div class="flex items-center gap-6">
                                    <label class="inline-flex items-center">
                                        <input type="radio"
                                            class="form-radio h-5 w-5 text-indigo-600 payment-radio focus:ring-indigo-300"
                                            name="payment_method[{{ $index }}]" value="cod"
                                            {{ $cartItems['payment_method'] === 'cod' ? 'checked' : '' }}>
                                        <span class="ml-3 text-gray-700 tracking-wide">Cash On Delivery</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="radio"
                                            class="form-radio h-5 w-5 text-indigo-600 payment-radio focus:ring-indigo-300"
                                            name="payment_method[{{ $index }}]" value="screenshot"
                                            {{ $cartItems['payment_method'] === 'screenshot' ? 'checked' : '' }}>
                                        <span class="ml-3 text-gray-700 tracking-wide">Upload Screenshot</span>
                                    </label>

                                </div>
                                 <div class="mt-5 payment-screenshot-container"  @if($cartItems['payment_method'] !== 'screenshot') style="display: none" @endif>
                                        <label for="payment_screenshot" class="block text-gray-700 text-sm font-medium mb-2 tracking-wide">Payment Screenshot:</label>
                                        <input type="file" name="payment_screenshot[{{$index}}]" class="border rounded py-3 px-4 w-full focus:ring-2 focus:ring-indigo-300 focus:border-indigo-500 transition-all duration-200">
                                    </div>
                            </div>

                             @if ($cartItems['seller']->payment_methods->isNotEmpty())
                                  <div class="mt-8 border-t pt-5">
                                       <p class="font-semibold text-gray-800 mb-3 tracking-wide">Available Payment Methods</p>
                                          <div class="flex flex-col gap-5">
                                              @foreach ($cartItems['seller']->payment_methods as $paymentMethod)
                                                  <div class="bg-gray-50 rounded-xl p-6 border border-gray-200 transition-all duration-300 shadow-sm hover:shadow-md">
                                                      <h2 class="text-lg font-semibold text-gray-900 mb-3 tracking-wide">{{ $paymentMethod->bank_name }}</h2>
                                                      <ul class="list-none pl-0 text-gray-700 space-y-1">
                                                        <li class="mb-1"><span class="font-medium">Bank Name:</span> {{ $paymentMethod->bank_name }}</li>
                                                        <li class="mb-1"><span class="font-medium">Account Number:</span> {{ $paymentMethod->account_number }}</li>
                                                        <li class="mb-1"><span class="font-medium">Branch Code:</span> {{ $paymentMethod->branch_code }}</li>
                                                        <li class="mb-1"><span class="font-medium">IBAN:</span> {{ $paymentMethod->iban }}</li>
                                                        <li class="mb-1"><span class="font-medium">Swift Code:</span> {{ $paymentMethod->swift_code }}</li>
                                                      </ul>
                                                  </div>
                                              @endforeach
                                          </div>
                                   </div>
                            @endif
                        </div>
                     </div>
            @endforeach

                <div class="flex justify-between items-center mt-10 space-x-4">
                    <form action="{{ route('cart.empty') }}" method="POST" class="inline-block">
                            @csrf
                         @method('DELETE')
                             <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-3 px-5 rounded-lg focus:outline-none transition-colors duration-200">Empty Cart</button>
                     </form>
                     <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-3 px-5 rounded-lg focus:outline-none transition-colors duration-200" id="placeOrderButton">Place Order</button>
               </div>

        @else
            <p class="mt-6 text-gray-600 text-center italic">Your Cart is Empty</p>
        @endif
    </div>
    <form action="{{ route('order.store') }}" method="POST" class="hidden" id="orderForm"  enctype="multipart/form-data">
         @csrf
        </form>
   <script>
    document.addEventListener('DOMContentLoaded', function () {
            const paymentRadios = document.querySelectorAll('.payment-radio');

            paymentRadios.forEach(radio => {
                radio.addEventListener('change', function () {
                    const container = this.closest('.bg-white').querySelector(
                        '.payment-screenshot-container');
                    if (this.value === 'screenshot') {
                        container.style.display = 'block';
                    } else {
                        container.style.display = 'none';
                    }
                });
            });


        const placeOrderButton = document.getElementById('placeOrderButton');
        const orderForm = document.getElementById('orderForm');


        placeOrderButton.addEventListener('click', function(event) {
            event.preventDefault();
                const paymentMethods = {};
              const paymentScreenshots = {};

              document.querySelectorAll('.bg-white').forEach((vendorCard, index) => {

              const paymentMethodRadio = vendorCard.querySelector('input[name="payment_method['+index+']"]:checked');
              const paymentScreenshotInput = vendorCard.querySelector('input[name="payment_screenshot['+index+']"]');

               if(paymentMethodRadio) {
                 paymentMethods[index] = paymentMethodRadio.value;
                 }
                   if(paymentScreenshotInput && paymentScreenshotInput.files.length > 0) {
                           paymentScreenshots[index] = paymentScreenshotInput.files[0]
                    }
              });

                let formData = new FormData(orderForm);
                   for (const key in paymentMethods) {
                       formData.append('payment_method['+key+']', paymentMethods[key]);
                    }

                   for (const key in paymentScreenshots) {
                        formData.append('payment_screenshot['+key+']', paymentScreenshots[key]);
                    }



            fetch(orderForm.action, {
              method: 'POST',
              body: formData,
            })
            .then(response => {
                 if (response.ok) {
                     window.location.href = "{{ route('order.success') }}";
                 }else{
                    return response.json().then(errorData => {
                         if (errorData && errorData.errors) {
                              let errorString = '';
                              for (const key in errorData.errors) {
                                     errorData.errors[key].forEach(message => {
                                         errorString += message + '<br/>';
                                       });
                                   }
                                    const errorDiv = document.createElement('div');
                                      errorDiv.innerHTML = '<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert"><span class="block sm:inline">'+errorString+'</span><button class="absolute top-2 right-2 text-red-500 hover:text-red-800 focus:outline-none" onclick="this.parentNode.remove();"><svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button></div>'
                                       document.querySelector('.container').prepend(errorDiv);
                           }else if(errorData && errorData.message) {
                             const errorDiv = document.createElement('div');
                                errorDiv.innerHTML = '<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert"><span class="block sm:inline">'+errorData.message+'</span><button class="absolute top-2 right-2 text-red-500 hover:text-red-800 focus:outline-none" onclick="this.parentNode.remove();"><svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button></div>'
                                       document.querySelector('.container').prepend(errorDiv);
                           } else {
                                 const errorDiv = document.createElement('div');
                                 errorDiv.innerHTML = '<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert"><span class="block sm:inline">Some error occured, please try again later.</span><button class="absolute top-2 right-2 text-red-500 hover:text-red-800 focus:outline-none" onclick="this.parentNode.remove();"><svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button></div>'
                                        document.querySelector('.container').prepend(errorDiv);
                            }

                      });
                 }

             })
               .catch(error => {
                  const errorDiv = document.createElement('div');
                  errorDiv.innerHTML = '<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert"><span class="block sm:inline">Some error occured, please try again later.</span><button class="absolute top-2 right-2 text-red-500 hover:text-red-800 focus:outline-none" onclick="this.parentNode.remove();"><svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button></div>'
                  document.querySelector('.container').prepend(errorDiv);
            });
        });
    });
  </script>
@endsection
