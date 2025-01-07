<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    public function index()
    {
        $product = Product::with(['category', 'pictures'])->latest()->paginate(10);
        // return response()->json($product[0]);
        return view('dashboard.seller.products.index', compact('product'));
    }


    /*****************************************************
     *
     *
     * Helper Functions For Products
     *
     *
     *****************************************************/


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


    /*****************************************************
     *
     *
     * New Product Functions
     *
     *
     *****************************************************/

    public function show_add_new_product_page()
    {
        $category = Category::all();
        return view('dashboard.seller.products.types.add-new-product.add-new-product', compact('category'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

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
                'reason' => $validatedData['reason'],
                'sale_price' => $validatedData['sp'],
                'sku' => $validatedData['sku'],
                'stock_quanity' => $validatedData['stock'],
                'description' => $validatedData['description'],
                'user_id' => Auth::user()->id,
            ]);

            // Attach attributes
            if ($request->has('attribute')) {
                foreach ($request->attribute as $attributeId => $value) {
                    $attributeValue = \App\Models\AttributeValue::find($value);

                    if ($attributeValue) {
                        $product->attributes()->attach($attributeId, [
                            'attribute_value_id' => $attributeValue->id,
                        ]);
                    }
                }
            }

            // Handle file uploads
            if ($request->hasFile('file')) {
                foreach ($request->file('file') as $file) {
                    $path = public_path('images/products');

                    // Create the directory if it doesn't exist
                    if (!is_dir($path)) {
                        mkdir($path, 0777, true);
                    }

                    $fileName = time() . '_' . $file->getClientOriginalName();
                    $file->move($path, $fileName);

                    // Attach the image path to the product
                    $product->pictures()->create(['image' => 'images/products/' . $fileName]);
                }
            }

            // Commit the transaction
            DB::commit();

            // Return success response
            return response()->json([
                'success' => true,
                'message' => 'Product added successfully!',
            ]);
        } catch (\Exception $e) {
            // Rollback the transaction if any exception occurs
            DB::rollBack();

            // Return error response
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while adding the product.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function edit($id)
    {
        // Fetch the product along with relationships
        $product = Product::with(['category', 'brand', 'attributes', 'pictures'])
            ->findOrFail($id);

        // Get all categories for the dropdown
        $categories = Category::all();

        // Return a view (you can name it however you like)
        // e.g. `edit-product.blade.php` inside the same folder structure
        return view('dashboard.seller.products.types.add-new-product.edit-new-product', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            // Validate input
            $validatedData = $request->validate([
                'product_name'   => 'required|string|max:255',
                'category_name'  => 'required|exists:categories,id',
                'brand_name'     => 'required|exists:brands,id',
                'warranty'       => 'required|string',
                'price'          => 'required|numeric',
                'sp'             => 'nullable|numeric',
                'sku'            => 'required|string|max:255',
                'stock'          => 'required|integer|min:0',
                'reason'         => 'nullable|string',
                'year'           => 'required',
                'description'    => 'nullable|string',
                'remove_images' => 'array',         // optional array of picture IDs to remove
                'remove_images.*' => 'numeric',     // each must be a number (the picture ID)
                'file'   => 'nullable|array|max:10', // up to 10 new files
                'file.*' => 'file|mimes:jpeg,png,jpg|max:2048',
            ]);

            // Find existing product
            $product = Product::findOrFail($id);

            // Update product fields
            $product->update([
                'product_name'   => $validatedData['product_name'],
                'category_id'    => $validatedData['category_name'],
                'brand_id'       => $validatedData['brand_name'],
                'warranty'       => $validatedData['warranty'],
                'price'          => $validatedData['price'],
                'sale_price'     => $validatedData['sp'],
                'sku'            => $validatedData['sku'],
                'stock_quanity'  => $validatedData['stock'],
                'year_of_make'   => $validatedData['year'],
                'description'    => $validatedData['description'],
                // 'reason' is optional in your table; include it if you store it:
                'reason'         => $validatedData['reason'] ?? null,
            ]);

            // Detach existing attribute pivot data
            $product->attributes()->detach();

            // If attributes are provided, re-attach them
            if ($request->has('attribute')) {
                foreach ($request->attribute as $attributeId => $value) {
                    $attributeValue = \App\Models\AttributeValue::find($value);

                    if ($attributeValue) {
                        $product->attributes()->attach($attributeId, [
                            'attribute_value_id' => $attributeValue->id,
                        ]);
                    }
                }
            }

            // 4) Remove any pictures marked for deletion
            $removeImages = $request->input('remove_images', []);
            if (!empty($removeImages)) {
                // Eager load pictures to avoid N+1
                $product->load('pictures');

                foreach ($product->pictures as $pic) {
                    if (in_array($pic->id, $removeImages)) {
                        // Delete the file from disk
                        $imagePath = public_path($pic->image);
                        if (File::exists($imagePath)) {
                            File::delete($imagePath);
                        }
                        // Delete the record from DB
                        $pic->delete();
                    }
                }
            }

            // 5) Handle uploading new pictures
            if ($request->hasFile('file')) {
                foreach ($request->file('file') as $file) {
                    $path = public_path('images/products');
                    if (!is_dir($path)) {
                        mkdir($path, 0777, true);
                    }

                    $fileName = time() . '_' . $file->getClientOriginalName();
                    $file->move($path, $fileName);

                    $product->pictures()->create([
                        'image' => 'images/products/' . $fileName
                    ]);
                }
            }

            DB::commit();

            // Return a JSON response if you're handling this via AJAX
            return response()->json([
                'success' => true,
                'message' => 'Product updated successfully.',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating the product.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }


    /*****************************************************
     *
     *
     * Used Product Functions
     *
     *
     *****************************************************/

    public function show_add_used_product_page()
    {
        $category = Category::all();
        return view('dashboard.seller.products.types.add-used-product.add-used-product', compact('category'));
    }

    public function edit_used($id)
    {
        // Fetch the product along with relationships
        $product = Product::with(['category', 'brand', 'attributes', 'pictures'])
            ->findOrFail($id);

        // Get all categories for the dropdown
        $categories = Category::all();

        // Return a view (you can name it however you like)
        // e.g. `edit-product.blade.php` inside the same folder structure
        return view('dashboard.seller.products.types.add-used-product.edit-used-product', compact('product', 'categories'));
    }

    public function store_used(Request $request)
    {
        DB::beginTransaction();

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
                'repaired' => 'nullable|string',
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
                'reason' => $validatedData['reason'],
                'repaired' => $validatedData['repaired'],
                'warranty' => $validatedData['warranty'],
                'price' => $validatedData['price'],
                'year_of_make' => $validatedData['year'],
                'condition' => 'used',
                'sale_price' => $validatedData['sp'],
                'sku' => $validatedData['sku'],
                'stock_quanity' => $validatedData['stock'],
                'description' => $validatedData['description'],
                'user_id' => Auth::user()->id,
            ]);

            // Attach attributes
            if ($request->has('attribute')) {
                foreach ($request->attribute as $attributeId => $value) {
                    $attributeValue = \App\Models\AttributeValue::find($value);

                    if ($attributeValue) {
                        $product->attributes()->attach($attributeId, [
                            'attribute_value_id' => $attributeValue->id,
                        ]);
                    }
                }
            }

            // Handle file uploads
            if ($request->hasFile('file')) {
                foreach ($request->file('file') as $file) {
                    $path = public_path('images/products');

                    // Create the directory if it doesn't exist
                    if (!is_dir($path)) {
                        mkdir($path, 0777, true);
                    }

                    $fileName = time() . '_' . $file->getClientOriginalName();
                    $file->move($path, $fileName);

                    // Attach the image path to the product
                    $product->pictures()->create(['image' => 'images/products/' . $fileName]);
                }
            }

            // Commit the transaction
            DB::commit();

            // Return success response
            return response()->json([
                'success' => true,
                'message' => 'Product added successfully!',
            ]);
        } catch (\Exception $e) {
            // Rollback the transaction if any exception occurs
            DB::rollBack();

            // Return error response
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while adding the product.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update_used(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            // Validate input
            $validatedData = $request->validate([
                'product_name'   => 'required|string|max:255',
                'category_name'  => 'required|exists:categories,id',
                'brand_name'     => 'required|exists:brands,id',
                'warranty'       => 'required|string',
                'price'          => 'required|numeric',
                'sp'             => 'nullable|numeric',
                'sku'            => 'required|string|max:255',
                'stock'          => 'required|integer|min:0',
                'reason'         => 'nullable|string',
                'repaired'       => 'nullable|string',
                'year'           => 'required',
                'description'    => 'nullable|string',
                'remove_images' => 'array',         // optional array of picture IDs to remove
                'remove_images.*' => 'numeric',     // each must be a number (the picture ID)
                'file'   => 'nullable|array|max:10', // up to 10 new files
                'file.*' => 'file|mimes:jpeg,png,jpg|max:2048',
            ]);

            // Find existing product
            $product = Product::findOrFail($id);

            // Update product fields
            $product->update([
                'product_name'   => $validatedData['product_name'],
                'category_id'    => $validatedData['category_name'],
                'brand_id'       => $validatedData['brand_name'],
                'warranty'       => $validatedData['warranty'],
                'price'          => $validatedData['price'],
                'sale_price'     => $validatedData['sp'],
                'sku'            => $validatedData['sku'],
                'stock_quanity'  => $validatedData['stock'],
                'year_of_make'   => $validatedData['year'],
                'description'    => $validatedData['description'],
                'reason'         => $validatedData['reason'] ?? null,
                'repaired'       => $validatedData['repaired'] ?? null
            ]);

            // Detach existing attribute pivot data
            $product->attributes()->detach();

            // If attributes are provided, re-attach them
            if ($request->has('attribute')) {
                foreach ($request->attribute as $attributeId => $value) {
                    $attributeValue = \App\Models\AttributeValue::find($value);

                    if ($attributeValue) {
                        $product->attributes()->attach($attributeId, [
                            'attribute_value_id' => $attributeValue->id,
                        ]);
                    }
                }
            }

            // 4) Remove any pictures marked for deletion
            $removeImages = $request->input('remove_images', []);
            if (!empty($removeImages)) {
                // Eager load pictures to avoid N+1
                $product->load('pictures');

                foreach ($product->pictures as $pic) {
                    if (in_array($pic->id, $removeImages)) {
                        // Delete the file from disk
                        $imagePath = public_path($pic->image);
                        if (File::exists($imagePath)) {
                            File::delete($imagePath);
                        }
                        // Delete the record from DB
                        $pic->delete();
                    }
                }
            }

            // 5) Handle uploading new pictures
            if ($request->hasFile('file')) {
                foreach ($request->file('file') as $file) {
                    $path = public_path('images/products');
                    if (!is_dir($path)) {
                        mkdir($path, 0777, true);
                    }

                    $fileName = time() . '_' . $file->getClientOriginalName();
                    $file->move($path, $fileName);

                    $product->pictures()->create([
                        'image' => 'images/products/' . $fileName
                    ]);
                }
            }

            DB::commit();

            // Return a JSON response if you're handling this via AJAX
            return response()->json([
                'success' => true,
                'message' => 'Product updated successfully.',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating the product.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

     /*****************************************************
     *
     *
     * Complete Pc Product Product Functions
     *
     *
     *****************************************************/

     public function show_add_complete_pc_product_page()
     {
         $category = Category::all();
         return view('dashboard.seller.products.types.add-complete-pc-build.add-complete-pc-build', compact('category'));
     }



     /*****************************************************
     *
     *
     * Common Product Functions
     *
     *
     *****************************************************/

    public function destroy($id)
    {
        // Find the product by ID
        $product = Product::findOrFail($id);

        // Delete the associated pictures (if any)
        foreach ($product->pictures as $picture) {
            // Delete the image file from the server
            $imagePath = public_path($picture->image);
            if (File::exists($imagePath)) {
                File::delete($imagePath);  // Delete the image file from the server
            }
            // Delete the picture record from the database
            $picture->delete();
        }

        // Delete the product
        $product->delete();

        // Redirect to the product list with a success message
        return redirect()->route('product.index')->with('success', 'Product Deleted Successfully.');
    }
}
