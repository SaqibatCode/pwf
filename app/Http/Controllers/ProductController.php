<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    // Seller Side
    public function index_seller()
    {
        return view('dashboard.seller.product.product');
    }

    public function add_new_product()
    {
        $categories = Category::all();
        return view('dashboard.seller.product.product_types.add-new-product', compact('categories'));
    }

    // Ajax Functions
    public function fetchBrands($categoryId)
    {
        $categories = Category::with('brands')->find($categoryId);
        return response()->json($categories->brands);
    }
    public function getAttributesForCategory($categoryId)
    {
        // Load the category with its associated attributes and their values
        $category = Category::with(['attributes.values'])->find($categoryId);

        // Return the attributes along with their values
        return response()->json($category->attributes);
    }
}
