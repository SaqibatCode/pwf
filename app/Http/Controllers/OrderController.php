<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Models\Product;
use App\Models\Order;
use App\Models\ChildOrder;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function addToCart(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $sellerId = $product->user_id;
        $quantity = $request->input('quantity');

        $cart = session()->get('cart', []);

        if (!isset($cart[$sellerId])) {
            $cart[$sellerId] = [];
        }

        $existingItemIndex = null;
        foreach ($cart[$sellerId] as $index => $item) {
            if ($item['product_id'] == $product->id) {
                $existingItemIndex = $index;
                break;
            }
        }

        if ($existingItemIndex !== null) {
            // Update Quantity for Existing item
            $cart[$sellerId][$existingItemIndex]['quantity'] += $quantity;
        } else {
            // Adding a new item
            $cart[$sellerId][] = [
                'product_id' => $product->id,
                'quantity' => $quantity
            ];
        }


        session()->put('cart', $cart);

        return redirect()->route('cart.show')->with('success', 'Product added to cart.');
    }

    public function showCart()
    {

        $cart = session()->get('cart', []);

        $groupedCartItems = [];
        foreach ($cart as $sellerId => $items) {
            $seller = User::with('payment_methods')->find($sellerId);
            $products = Product::whereIn('id', array_column($items, 'product_id'))->get();
            $groupedCartItems[] = [
                'seller' => $seller,
                'items' =>  $items,
                'products' => $products,
                'payment_method' => 'cod' //default value
            ];
        }
        return view('store-front.cart', compact('groupedCartItems'));
    }

    public function updateCart(Request $request)
    {
        $request->validate([
            'items.*.*.product_id' => 'required|integer',
            'items.*.*.quantity' => 'required|integer|min:1',
            'payment_method.*' => 'nullable|in:cod,screenshot'
        ]);


        $cart = session()->get('cart', []);
        $updatedItems = $request->input('items');
        $paymentMethods = $request->input('payment_method', []);


        foreach ($updatedItems as $sellerIndex => $items) {
            $sellerId = null;

            $cartKeys = array_keys($cart);
            if (isset($cartKeys[$sellerIndex])) {
                $sellerId = $cartKeys[$sellerIndex];
            }

            if ($sellerId !== null) {
                foreach ($items as $itemIndex => $item) {
                    $product_id = $item['product_id'];
                    $quantity = $item['quantity'];

                    foreach ($cart[$sellerId] as $index => $cartItem) {
                        if ($cartItem['product_id'] == $product_id) {
                            $cart[$sellerId][$index]['quantity'] = $quantity;
                        }
                    }
                }
            }
            if (isset($paymentMethods[$sellerIndex])) {
                $paymentMethod = $paymentMethods[$sellerIndex];
                if ($sellerId !== null) {
                    foreach ($cart as $key => $value) {
                        if ($key == $sellerId) {
                            $groupedCartItems = [];
                            foreach ($cart as $sellerId => $items) {
                                $seller = User::find($sellerId);
                                $products = Product::whereIn('id', array_column($items, 'product_id'))->get();
                                $groupedCartItems[] = [
                                    'seller' => $seller,
                                    'items' =>  $items,
                                    'products' => $products,
                                    'payment_method' => $paymentMethod
                                ];
                            }
                            session()->put('cart', $cart);
                            return view('cart.show', compact('groupedCartItems'));
                        }
                    }
                }
            }
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Cart Updated Successfully');
    }

    public function removeCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer',
        ]);

        $cart = session()->get('cart', []);
        $productId = $request->input('product_id');
        foreach ($cart as $sellerId => $items) {
            foreach ($items as $index => $item) {
                if ($item['product_id'] == $productId) {
                    unset($cart[$sellerId][$index]);
                    $cart[$sellerId] = array_values($cart[$sellerId]);
                    if (empty($cart[$sellerId])) {
                        unset($cart[$sellerId]);
                    }
                    break;
                }
            }
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Product removed from cart');
    }

    public function emptyCart()
    {
        session()->forget('cart');
        return redirect()->back()->with('success', 'Cart emptied.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'payment_method.*' => 'required|in:cod,screenshot',
            'payment_screenshot.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->back()->with('error', 'No product in cart');
        }

        $user = Auth::user();
        $order = Order::create([
            'user_id' => $user->id,
            'address' => 'some test address', // Get address from request
            'phone' => '1234567890', // Get phone from request
            'email' => $user->email,
            'delivery_instructions' => 'leave at the door' // Get delivery instructions from request
        ]);

        foreach ($cart as $sellerId => $items) {
            foreach ($items as $item) {
                $product = Product::find($item['product_id']);
                if ($product && $product->stock_quanity >= $item['quantity']) {
                    $product->decrement('stock_quanity', $item['quantity']);

                    $childOrder = new ChildOrder();
                    $childOrder->order_id = $order->id;
                    $childOrder->product_id = $item['product_id'];
                    $childOrder->seller_id = $sellerId;
                    $childOrder->quantity = $item['quantity'];
                    $paymentMethods = $request->input('payment_method');
                    $paymentScreenshots = $request->file('payment_screenshot');

                    if (isset($paymentMethods)) {
                        foreach ($paymentMethods as $index => $paymentMethod) {
                            $sellerKeys = array_keys($cart);
                            if (isset($sellerKeys[$index])) {
                                if ($paymentMethod === 'screenshot' && isset($paymentScreenshots[$index])) {
                                    $image = $paymentScreenshots[$index];
                                    $imageName = time() . '-' . $image->getClientOriginalName();
                                    $image->move(public_path('uploads/payment_screenshots'), $imageName);
                                    $childOrder->payment_screenshot =  'uploads/payment_screenshots/' . $imageName;
                                }
                            }
                        }
                    }
                    $childOrder->save();
                } else {
                    $order->delete();
                    return redirect()->back()->with('error', 'Product  ' . $product->product_name . ' is out of stock');
                }
            }
        }

        session()->forget('cart'); // Clear the cart
        return redirect()->route('order.success')->with('success', 'Order placed successfully!');
    }

    public function success()
    {
        return view('store-front.order-success');
    }
}
