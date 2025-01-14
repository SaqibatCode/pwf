<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\ChildOrder;
use App\Models\Product;
use App\Models\User;
use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class StoreFrontController extends Controller
{
    public function index()
    {
        $products = Product::with('category', 'brand', 'user')->get();
        $categoryNames = ['Graphic Cards', 'Monitors', 'Laptops', 'Storage', 'Processors'];
        $categories = Category::whereIn('name', $categoryNames)->get();
        // return response()->json($products);
        return view('store-front.home', compact('products', 'categories'));
    }

    public function show_product($slug)
    {
        $product = Product::where('slug', $slug)->with('brand', 'category', 'pictures', 'user')->first();
        $relatedProducts = Product::where('category_id', $product->category_id)->where('stock_quanity', '>=', 1)->with('user')->latest()->take(5)->get();

        // dd($relatedProducts);
        return view('store-front.product-details', compact('product', 'relatedProducts'));
    }

    public function show_shop()
    {
        $products = Product::with('pictures', 'user')->where('status', 'approved')->where('stock_quanity', '>=', 1)->paginate('10');
        return view('store-front.products', compact('products'));
    }

    public function show_login()
    {
        return view('store-front.login');
    }
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended(route('home'));
        }

        return back()->withErrors([
            'email' => 'Invalid Credentials Provided',
        ])->onlyInput('email');
    }

    public function show_register()
    {
        return view('store-front.register');
    }
    public function register(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'father_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'dob' => 'required|date',
            'city' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required',
            'password'    => 'required|string|min:8',
            'terms' => 'required|accepted',
        ]);

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'father_name' => $request->father_name,
            'email' => $request->email,
            'cnic' => 'N/A',
            'verification' => 'Verified',
            'type' => 'buyer',
            'address' => $request->address,
            'dob' => $request->dob,
            'city' => $request->city,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->intended('/'); // Redirect after registration
    }
    public function show_account()
    {
        return view('store-front.account');
    }


    public function edit_user()
    {
        $user = auth()->user(); // Get the currently authenticated user
        return view('store-front.account', compact('user')); // Make sure the view path is correct
    }

    public function update_user(Request $request)
    {
        $user = auth()->user(); // Get the currently authenticated user

        // Validate the form data
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'father_name' => 'required|string|max:255',
            'dob' => 'required|date',
            'city' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'password' => 'nullable|string|min:8', // Only validate password if changed
        ]);

        // Update user model fields
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->father_name = $request->father_name;
        $user->dob = $request->dob;
        $user->city = $request->city;
        $user->phone = $request->phone;
        $user->address = $request->address;

        // Hash and update password if changed.
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        // Redirect to the profile page with a success message.
        return redirect()->back()->with('success', 'Account updated successfully!');
    }

    public function indexOrders()
    {
        $user = auth()->user();
        $orders = $user->orders()->with('childOrders.product', 'childOrders.seller')->latest()->get();
        return view('store-front.order.orders', compact('orders'));
    }

    public function showOrder($id)
    {
        $user = auth()->user();
        $order = $user->orders()->with('childOrders.product', 'childOrders.seller')->findOrFail($id);
        return view('store-front.order.order-details', compact('order'));
    }

    public function mark_complete(Request $req)
    {
        $order = ChildOrder::findOrFail($req->id);
        $order->status = 'Delivered & Completed';
        $order->save();

        return redirect()->back()->with('success', 'Order Completed Successfully');
    }


    public function show_all_categories()
    {
        $categories = Category::withCount('products')->get();
        return view('store-front.category.all-categories', ['categories' => $categories]);
    }
    public function show_single_category($slug)
    {
        $category = Category::with('products')->where('slug', $slug)->get();

        return view('store-front.category.category-single', compact('category'));
    }

    public function show_seller_portfolio($slug)
    {
        $seller = User::with('products','userProfile')
            ->where('slug', $slug)
            ->firstOrFail();

        $products = $seller->products;

        return view('store-front.seller-portfolio', compact('seller', 'products'));
    }
}
