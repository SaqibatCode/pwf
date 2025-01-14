<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Models\Product;
use App\Models\Order;
use App\Models\ChildOrder;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;

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
    private function getUploadErrorMessage($errorCode)
    {
        switch ($errorCode) {
            case UPLOAD_ERR_INI_SIZE:
                return "The uploaded file exceeds the upload_max_filesize directive in php.ini.";
            case UPLOAD_ERR_FORM_SIZE:
                return "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.";
            case UPLOAD_ERR_PARTIAL:
                return "The uploaded file was only partially uploaded.";
            case UPLOAD_ERR_NO_FILE:
                return "No file was uploaded.";
            case UPLOAD_ERR_NO_TMP_DIR:
                return "Missing a temporary folder.";
            case UPLOAD_ERR_CANT_WRITE:
                return "Failed to write file to disk.";
            case UPLOAD_ERR_EXTENSION:
                return "A PHP extension stopped the file upload.";
            default:
                return "Unknown file upload error.";
        }
    }
    public function store(Request $request)
    {

        $request->validate([
            'payment_method.*' => 'required|in:cod,screenshot',
            'payment_screenshot.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'address'              => 'required',
            'phone'                => 'required',
            'email'                => 'required',
            'delivery_instructions' => 'nullable'
        ]);

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->back()->with('error', 'No product in cart');
        }

        try {
            DB::beginTransaction(); // Start the database transaction

            $user = Auth::user();
            $order = Order::create([
                'user_id' => $user->id,
                'address' => $request->address,
                'phone' =>  $request->phone,
                'email' =>  $request->email,
                'delivery_instructions' => $request->delivery_instructions,

            ]);





            foreach ($cart as $sellerId => $items) {
                $paymentScreenshot = $request->file('payment_screenshot_' . $sellerId);
                $paymentMethods = $request->input('payment_method_' . $sellerId);
                $paymentMethod = '';
                if ($paymentMethods == 'screenshot') {
                    $paymentMethod = 'Online';
                } else {
                    $paymentMethod = 'COD';
                }
                foreach ($items as $item) {
                    $product = Product::find($item['product_id']);

                    if (!$product || $product->stock_quanity < $item['quantity']) {
                        throw new \Exception('Product ' . ($product ? $product->product_name : 'with ID ' . $item['product_id']) . ' is out of stock or does not exist.');
                    }

                    $product->decrement('stock_quanity', $item['quantity']);

                    $childOrder = new ChildOrder();
                    $childOrder->order_id = $order->id;
                    $childOrder->product_id = $item['product_id'];
                    $childOrder->seller_id = $sellerId;
                    $childOrder->quantity = $item['quantity'];
                    $childOrder->payment_type = $paymentMethod;
                    if ($paymentScreenshot) {
                        // Generate a unique name for the file
                        $fileName = time() . '_' . uniqid() . '.' . $paymentScreenshot->getClientOriginalExtension();
                        // Move the file to the root public folder
                        $paymentScreenshot->move(public_path('payment_screenshots'), $fileName);
                        // Save the file path
                        $filePath = 'payment_screenshots/' . $fileName;
                        $childOrder->payment_screenshot = $filePath;
                    }

                    $childOrder->save();
                }
            }
            DB::commit(); // Commit the database transaction
        } catch (\Exception $e) {
            DB::rollBack();  // Rollback the database transaction
            Log::error('Error creating order: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error creating order: ' . $e->getMessage());
        }


        session()->forget('cart'); // Clear the cart
        return redirect()->route('order.success')->with('success', 'Order placed successfully!');
    }

    public function success()
    {
        return view('store-front.order-success');
    }





    /********************************************
        Seller Side Orders Routes
     *********************************************/

    public function get_seller_order()
    {

        $orders = Order::with('childOrders.seller', 'user')->latest()->paginate(10);

        // return response()->json($orders);
        return view('dashboard.seller.order.all-orders', compact('orders'));
    }
    public function get_seller_pending_order()
    {
        $orders = Order::with('childOrders.seller', 'user')
            ->whereHas('childOrders', function ($query) {
                $query->where('status', 'Pending Approval'); // Replace with your desired status
            })
            ->latest()
            ->paginate(10);

        return view('dashboard.seller.order.all-orders', compact('orders'));
    }
    public function get_seller_completed_order()
    {
        $orders = Order::with('childOrders.seller', 'user')
            ->whereHas('childOrders', function ($query) {
                $query->where('status', 'Delivered & Completed'); // Replace with your desired status
            })
            ->latest()
            ->paginate(10);

        return view('dashboard.seller.order.all-orders', compact('orders'));
    }
    public function get_seller_dispatched_order()
    {
        $orders = Order::with('childOrders.seller', 'user')
            ->whereHas('childOrders', function ($query) {
                $query->where('status', 'Order Dispatched'); // Replace with your desired status
            })
            ->latest()
            ->paginate(10);

        return view('dashboard.seller.order.all-orders', compact('orders'));
    }


    public function markPaymentReceived($orderId)
    {
        $order = ChildOrder::findOrFail($orderId);
        $order->status = 'Payment Received';
        $order->save();

        return redirect()->back()->with('success', 'Payment marked as received.');
    }

    public function dispatchOrder(Request $request, $orderId)
    {
        $request->validate([
            'tracking_id' => 'required|string',
        ]);

        $order = ChildOrder::findOrFail($orderId);
        $order->status = 'Order Dispatched';
        $order->tracking_id = $request->tracking_id;
        $order->save();

        return redirect()->back()->with('success', 'Order dispatched successfully.');
    }

    public function get_admin_order()
    {

        $orders = Order::with('childOrders.seller', 'user')->latest()->paginate(10);

        // return response()->json($orders);
        return view('dashboard.admin.order.all-orders', compact('orders'));
    }

    public function updateStatus(Request $request, $id)
    {
        // Log for debugging
        Log::info('Update order status request received:', [
            'id' => $id,
            'status' => $request->status,
        ]);

        // 1. Validate the request data
        $request->validate([
            'status' => 'required|in:Pending Approval,Order Dispatched,Delivered & Completed,Payment Received',
        ]);

        // 2. Find the Child Order
        $childOrder = ChildOrder::find($id);

        if (!$childOrder) {
            // Log if order is not found
            Log::error('Order not found with id:', ['id' => $id]);

            return redirect()->back()->with('error', 'Order not found.');
        }

        // 3. Update the order status
        try {
            $childOrder->status = $request->status;
            $childOrder->save();

            // Log successful order update
            Log::info('Order status updated successfully', ['id' => $id, 'newStatus' => $request->status]);

            // 4. Redirect back with a success message
            return redirect()->back()->with('success', 'Order status updated successfully.');
        } catch (\Exception $e) {
            // Log error
            Log::error('Error updating order status:', [
                'id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            // Redirect back with error message
            return redirect()->back()->with('error', 'There was an error updating the order status. Please try again.');
        }
    }
}
