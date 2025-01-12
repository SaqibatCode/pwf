<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class StoreFrontController extends Controller
{
    public function index()
    {
        $products = Product::all();
        $categoryNames = ['Graphic Cards', 'Monitors', 'Laptops', 'Storage', 'Processors'];
        $categories = Category::whereIn('name', $categoryNames)->get();
        return view('store-front.home', compact('products', 'categories'));
    }

    public function show_product($slug)
    {
        $product = Product::where('slug', $slug)->with('brand', 'category', 'pictures', 'user')->first();
        $relatedProducts = Product::where('category_id', $product->category_id)->where('stock_quanity', '>=', 1)->with('user')->latest()->take(5)->get();

        // dd($relatedProducts);
        return view('store-front.product-details', compact('product', 'relatedProducts'));
    }

    public function show_shop(){
        $products = Product::with('pictures', 'user')->where('status','approved')->where('stock_quanity', '>=', 1)->paginate('10');
        return view('store-front.products' ,compact('products'));
    }
}
