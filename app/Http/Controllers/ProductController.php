<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index()
    {
        return view('dashboard.seller.products.index');
    }

    public function show_add_new_product_page()
    {
        $category = Category::all();
        return view('dashboard.seller.products.types.add-new-product.add-new-product', compact('category'));
    }

    public function getBrands($categoryId)
    {
        $category = Category::findOrFail($categoryId);
        $brands = $category->brands()->get();
        return response()->json($brands);
    }

    public function getAttributesAndValues($categoryId)
    {
        $category = Category::findOrFail($categoryId);

        // Fetch attributes related to the category
        $attributes = $category->attributes; // Assuming Category has many-to-many with Attribute

        $attributesWithValues = [];

        foreach ($attributes as $attribute) {
            $attributeValues = $attribute->values; // Get values for each attribute
            $attributesWithValues[] = [
                'attribute' => $attribute,
                'values' => $attributeValues
            ];
        }

        return response()->json($attributesWithValues);
    }

    public function store(Request $request)
    {

        try {
            // Validate input
            $validatedData = $request->validate([
                'product_name' => 'required|string|max:255',
                'category_name' => 'required|exists:categories,id',
                'brand_name' => 'required|exists:brands,id',
                'warranty' => 'required|string',
                'price' => 'required|numeric',
                'sp' => 'nullable|numeric',
                'sku' => 'required|string|max:255',
                'stock' => 'required|integer|min:0',
                'reason' => 'nullable|string',
                'year' => 'required',
                'description' => 'nullable|string',
                'file' => 'required|array|min:4|max:10', // Max 10 files
                'file.*' => 'file|mimes:jpeg,png,jpg|max:2048', // Secure file types & size validation
            ]);

            $sellerName = Auth::user()->first_name;
            $slug = Product::generateSlug($validatedData['product_name'], $sellerName);

            // Store product data
            $product = Product::create([
                'product_name' => $validatedData['product_name'],
                'category_id' => $validatedData['category_name'],
                'brand_id' => $validatedData['brand_name'],
                'slug' => $slug,
                'warranty' => $validatedData['warranty'],
                'price' => $validatedData['price'],
                'year_of_make' => $validatedData['year'],
                'condition' => 'new',
                'sale_price' => $validatedData['sp'],
                'sku' => $validatedData['sku'],
                'stock_quantity' => $validatedData['stock'],
                'description' => $validatedData['description'],
                'user_id' => Auth::user()->id,
            ]);

            if ($request->has('attribute')) {
                foreach ($request->attribute as $attributeId => $value) {
                    // Store the attribute-value pair for the product
                    $product->attributes()->attach($attributeId, ['attribute_id' => $value]);
                }
            }
            // Handle file uploads
            if ($request->hasFile('file')) {
                foreach ($request->file('file') as $file) {
                    // Get the path for the 'assets/images/products' folder
                    $path = public_path('assets/images/products'); // Path where the files will be stored

                    // Check if the directory exists, if not, create it
                    if (!is_dir($path)) {
                        mkdir($path, 0777, true); // Create the directory if it doesn't exist
                    }

                    // Store the file in the 'assets/images/products' directory
                    $fileName = time() . '_' . $file->getClientOriginalName(); // Unique filename
                    $file->move($path, $fileName);

                    // Attach the image path to the product
                    $product->pictures()->create(['image' => 'assets/images/products/' . $fileName]);
                }
            }

            // Return success response
            return response()->json([
                'success' => true,
                'message' => 'Product added successfully!',
            ]);
        } catch (\Exception $e) {
            // Handle any unexpected errors and return a detailed error response
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while adding the product.',
                'error' => $e->getMessage(),
            ], 500); // Return HTTP 500 Internal Server Error
        }
    }
}
