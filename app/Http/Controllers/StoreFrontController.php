<?php

namespace App\Http\Controllers;

use App\Models\Category;
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

            return redirect()->intended(route('/'));
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
}
